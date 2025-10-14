<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Enums\RegistrationStatus;
use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Requests\UpdatePaymentProofRequest;
use App\Mail\PaymentProofUploaded;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function index(): View
    {
        $registrations = Registration::query()
            ->with(['event'])
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

        if ($event->capacity && $event->available_slots !== null && $event->available_slots <= 0) {
            return back()->withErrors(['event' => 'Kuota event sudah penuh.'])->withInput();
        }

        $formData = $request->safe()->only('form_data')['form_data'] ?? [];

        $registration = Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => RegistrationStatus::Pending,
            'payment_status' => PaymentStatus::Pending,
            'amount' => $event->price,
            'form_data' => $formData,
            'registered_at' => now(),
        ]);

        if ($event->available_slots !== null) {
            $event->decrement('available_slots');
        }

        return redirect()->route('registrations.show', $registration)->with('status', 'Pendaftaran berhasil dibuat, silakan lakukan pembayaran.');
    }

    public function show(Registration $registration): View
    {
        $this->authorize('view', $registration);

        $registration->loadMissing(['event', 'refundRequest']);

        return view('registrations.show', compact('registration'));
    }

    public function uploadProof(UpdatePaymentProofRequest $request, Registration $registration): RedirectResponse
    {
        $this->authorize('update', $registration);

        $proof = $request->file('payment_proof');
        $path = $proof->store('payment-proofs', 'public');

        $registration->update([
            'payment_proof_path' => $path,
            'payment_status' => PaymentStatus::AwaitingVerification,
            'paid_at' => now(),
        ]);

        $registration->loadMissing(['event', 'user']);

        Mail::to(config('mail.from.address'))
            ->queue(new PaymentProofUploaded($registration));

        return back()->with('status', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }
}
