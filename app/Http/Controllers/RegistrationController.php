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
            ->paginate(10);

        return view('registrations.index', compact('registrations'));
    }

    public function create(Event $event): View|RedirectResponse
    {
        if (! $event->isPublished()) {
            abort(404);
        }

        return view('registrations.create', compact('event'));
    }

    public function store(StoreRegistrationRequest $request, Event $event): RedirectResponse
    {
        $user = $request->user();

        $remainingSlots = $event->remainingSlots();

        if ($remainingSlots !== null && $remainingSlots <= 0) {
            return back()->withErrors(['event' => 'Kuota event sudah penuh.'])->withInput();
        }

        $formData = $request->safe()->only('form_data')['form_data'] ?? [];

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

        return redirect()->route('registrations.show', $registration)->with('status', 'Pendaftaran berhasil dibuat, silakan lakukan pembayaran.');
    }

    public function show(Registration $registration): View
    {
        $this->authorize('view', $registration);

        $registration->loadMissing(['event', 'transaction.refund']);

        $paymentMethod = config('payment.method', 'Virtual Account');

        if ($registration->transaction && ! $registration->transaction->payment_method) {
            $registration->transaction->forceFill(['payment_method' => $paymentMethod])->save();
        }

        $paymentAccount = collect(config('payment.accounts', []))
            ->firstWhere('is_primary', true)
            ?? collect(config('payment.accounts', []))->first();

        return view('registrations.show', [
            'registration' => $registration,
            'paymentAccount' => $paymentAccount,
            'paymentMethod' => $paymentMethod,
        ]);
    }

    public function uploadProof(UpdatePaymentProofRequest $request, Registration $registration): RedirectResponse
    {
        $this->authorize('update', $registration);

        $transaction = $registration->transaction;

        $paymentMethod = config('payment.method', 'Virtual Account');

        if (! $transaction) {
            $transaction = $registration->transaction()->create([
                'amount' => $registration->event->price,
                'status' => PaymentStatus::Pending,
                'payment_method' => $paymentMethod,
            ]);
        } elseif (! $transaction->payment_method) {
            $transaction->payment_method = $paymentMethod;
        }

        if ($transaction->payment_proof_path) {
            Storage::disk('public')->delete($transaction->payment_proof_path);
        }

        $proof = $request->file('payment_proof');
        $path = $proof->store('payment-proofs', 'public');

        $transaction->forceFill([
            'payment_proof_path' => $path,
            'status' => PaymentStatus::AwaitingVerification,
            'paid_at' => now(),
            'payment_method' => $paymentMethod,
        ])->save();

        $registration->loadMissing(['event', 'user']);

        $adminEmail = config('mail.admin_address') ?? config('mail.from.address');

        if ($adminEmail) {
            Mail::to($adminEmail)->queue(new PaymentProofUploaded($registration));
        }

        Email::create([
            'registration_id' => $registration->id,
            'type' => 'payment_proof_uploaded',
            'recipient' => $adminEmail,
            'subject' => 'Bukti Pembayaran Baru',
            'payload' => [
                'registration_id' => $registration->id,
            ],
            'sent_at' => now(),
        ]);

        return redirect()
            ->to(route('registrations.show', $registration) . '#konfirmasi')
            ->with('status', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }
}
