<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Enums\RegistrationStatus;
use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Requests\UpdatePaymentProofRequest;
use App\Mail\PaymentProofUploaded;
use App\Models\Email;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;   
use Illuminate\Support\Facades\Log;  
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    public function index(): View
    {
        $registrations = Registration::query()
            ->with(['event', 'transaction'])
            ->where('user_id', auth()->id())
            ->latest('registered_at')
            ->paginate(5);

        return view('registrations.index', compact('registrations'));
    }

    public function create(Event $event): View|RedirectResponse
    {
        if (! $event->isPublished()) {
            abort(404);
        }

        $user = auth()->user();

        $existingRegistration = $event->registrations()
            ->where('user_id', $user->id)
            ->latest('registered_at')
            ->first();

        $existingIsTerminal = $existingRegistration
            && (
                in_array($existingRegistration->status, [RegistrationStatus::Cancelled, RegistrationStatus::Refunded], true)
                || in_array($existingRegistration->transaction?->status, [PaymentStatus::Refunded, PaymentStatus::Rejected], true)
            );

        if ($existingRegistration && ! $existingIsTerminal) {
            return redirect()
                ->to(route('registrations.show', $existingRegistration) . '#tiket')
                ->with('status', 'Anda sudah terdaftar di event ini. Kami arahkan ke tiket Anda.');
        }

        // Wajib lengkapi profil dasar sebelum daftar
        if (! $user->phone || ! $user->province || ! $user->city || ! $user->address) {
            return redirect()
                ->route('profile.edit')
                ->with('status', 'Lengkapi nomor telepon, provinsi, kota, dan alamat sebelum mendaftar event.');
        }

        return view('registrations.create', compact('event'));
    }

    public function store(StoreRegistrationRequest $request, Event $event): RedirectResponse
    {
        $user = $request->user();

        $existingRegistration = $event->registrations()
            ->where('user_id', $user->id)
            ->latest('registered_at')
            ->first();

        if ($existingRegistration) {
            return redirect()
                ->to(route('registrations.show', $existingRegistration) . '#tiket')
                ->with('status', 'Anda sudah terdaftar di event ini. Kami arahkan ke tiket Anda.');
        }

        $remainingSlots = $event->remainingSlots();

        if ($remainingSlots !== null && $remainingSlots <= 0) {
            return back()->withErrors(['event' => 'Kuota event sudah penuh.'])->withInput();
        }

        $formData = $request->safe()->only('form_data')['form_data'] ?? [];

        // Gunakan DB Transaction agar aman
        return DB::transaction(function () use ($user, $event, $formData) {
            $registration = Registration::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'status' => RegistrationStatus::Pending,
                'form_data' => $formData,
                'registered_at' => now(),
            ]);

            $registration->transaction()->create([
                'amount' => $event->price,
                'status' => PaymentStatus::Pending,
                'payment_method' => config('payment.method', 'Virtual Account'),
            ]);

            return redirect()
                ->route('registrations.show', $registration)
                ->with('status', 'Pendaftaran berhasil dibuat, silakan lakukan pembayaran.');
        });
    }

    public function show(Registration $registration): View
    {
        $this->authorize('view', $registration);

        $registration->loadMissing(['event', 'transaction.refund']);
        $timeoutMinutes = config('payment.proof_timeout_minutes', 5);

        $paymentMethod = config('payment.method', 'Virtual Account');

        if ($registration->transaction && ! $registration->transaction->payment_method) {
            $registration->transaction->forceFill(['payment_method' => $paymentMethod])->save();
        }

        $paymentAccount = collect(config('payment.accounts', []))
            ->firstWhere('is_primary', true)
            ?? collect(config('payment.accounts', []))->first();

        $registeredAt = $registration->registered_at ?? $registration->created_at;
        $expiresAt = $registeredAt?->copy()->addMinutes($timeoutMinutes);

        if ($expiresAt && $expiresAt->isPast()) {
            $isPending = $registration->status === RegistrationStatus::Pending;
            $transactionPending = $registration->transaction?->status === PaymentStatus::Pending;
            $hasProof = filled($registration->transaction?->payment_proof_path);

            if ($isPending && $transactionPending && ! $hasProof) {
                $event = $registration->event;

                DB::transaction(function () use ($registration) {
                    $registration->transaction?->delete();
                    $registration->delete();
                });

                return redirect()
                    ->route('events.show', $event)
                    ->with('status', 'Pendaftaran dibatalkan karena melewati batas waktu pembayaran.');
            }
        }

        $remainingSeconds = max(0, $expiresAt ? now()->diffInSeconds($expiresAt, false) : 0);

        return view('registrations.show', [
            'registration' => $registration,
            'paymentAccount' => $paymentAccount,
            'paymentMethod' => $paymentMethod,
            'paymentTimeoutMinutes' => $timeoutMinutes,
            'remainingSeconds' => $remainingSeconds,
        ]);
    }

    public function uploadProof(UpdatePaymentProofRequest $request, Registration $registration): RedirectResponse
    {
        $this->authorize('update', $registration);

        $transaction = $registration->transaction;
        $paymentMethod = config('payment.method', 'Virtual Account');

        // 1. UPDATE DATABASE (Data Gambar)
        if (! $transaction) {
            $transaction = $registration->transaction()->create([
                'amount' => $registration->event->price,
                'status' => PaymentStatus::Pending,
                'payment_method' => $paymentMethod,
            ]);
        } elseif (! $transaction->payment_method) {
            $transaction->payment_method = $paymentMethod;
        }

        // Hapus file lama jika ada
        if ($transaction->payment_proof_path) {
            Storage::disk('public')->delete($transaction->payment_proof_path);
        }

        // Upload file baru
        $proof = $request->file('payment_proof');
        $path = $proof->store('payment-proofs', 'public');

        // Simpan path ke database
        $transaction->forceFill([
            'payment_proof_path' => $path,
            'status' => PaymentStatus::AwaitingVerification,
            'paid_at' => now(),
            'payment_method' => $paymentMethod,
        ])->save();

        // 2. KIRIM EMAIL (DIBUNGKUS TRY-CATCH)
        // Ini bagian kuncinya. Jika SMTP error, dia akan masuk ke 'catch' dan TIDAK bikin crash.
        try {
            $registration->loadMissing(['event', 'user']);
            $adminEmail = config('mail.admin_address') ?? config('mail.from.address');

            if ($adminEmail) {
                // Kirim langsung tanpa antrean (beban email masih ringan)
                Mail::to($adminEmail)->send(new PaymentProofUploaded($registration));
            }

            Email::create([
                'user_id' => $registration->user_id, // Tambahkan user_id agar tidak error
                'registration_id' => $registration->id,
                'type' => 'payment_proof_uploaded',
                'recipient' => $adminEmail,
                'subject' => 'Bukti Pembayaran Baru',
                'payload' => [
                    'registration_id' => $registration->id,
                ],
                'sent_at' => now(),
            ]);

        } catch (\Exception $e) {
            // Jika error, catat di log sistem tapi biarkan user lanjut redirect
            Log::error("Gagal kirim email bukti bayar: " . $e->getMessage());
            
            // Redirect dengan pesan peringatan (bukan error 500)
            return redirect()
                ->route('registrations.show', $registration) // PENTING: Gunakan route explicit, jangan back()
                ->with('status', 'Bukti berhasil diunggah! (Notifikasi email ke admin tertunda karena gangguan koneksi).');
        }

        // 3. REDIRECT SUKSES
        // Pastikan redirect ke 'registrations.show' (GET route), bukan kembali ke POST route.
        return redirect()
            ->to(route('registrations.show', $registration) . '#konfirmasi')
            ->with('status', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }

    public function expire(Request $request, Registration $registration): JsonResponse
    {
        $this->authorize('update', $registration);

        $registration->loadMissing(['transaction', 'event']);

        $isPending = $registration->status === RegistrationStatus::Pending;
        $transactionPending = $registration->transaction?->status === PaymentStatus::Pending;
        $hasProof = filled($registration->transaction?->payment_proof_path);

        if (! $isPending || ! $transactionPending || $hasProof) {
            return response()->json(['message' => 'Tidak dapat membatalkan pendaftaran ini.'], 422);
        }

        DB::transaction(function () use ($registration) {
            $registration->transaction?->delete();
            $registration->delete();
        });

        return response()->json([
            'redirect' => route('events.show', $registration->event),
            'message' => 'Pendaftaran dibatalkan karena tidak ada bukti pembayaran.',
        ]);
    }
}
