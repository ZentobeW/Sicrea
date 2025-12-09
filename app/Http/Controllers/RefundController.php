<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Enums\RefundStatus;
use App\Http\Requests\StoreRefundRequest;
use App\Mail\RefundRequested;
use App\Mail\RefundApproved;
use App\Mail\RefundRejected;
use App\Models\Registration;
use App\Models\Email;
use App\Models\Refund;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;

class RefundController extends Controller
{
    public function create(Registration $registration): View|RedirectResponse
    {
        $this->authorize('requestRefund', $registration);

        $registration->loadMissing(['event', 'transaction']);

        $transaction = $registration->transaction;

        if (! $transaction || $transaction->status !== PaymentStatus::Verified) {
            return redirect()
                ->route('registrations.show', $registration)
                ->with('status', 'Refund hanya tersedia untuk pembayaran terverifikasi.');
        }

        $amount = $transaction->amount ?? $registration->event->price ?? 0;
        $adminFee = round($amount * 0.10);
        $netAmount = max($amount - $adminFee, 0);

        return view('registrations.refund', [
            'registration' => $registration,
            'transaction' => $transaction,
            'amount' => $amount,
            'adminFee' => $adminFee,
            'netAmount' => $netAmount,
        ]);
    }

    public function store(StoreRefundRequest $request): RedirectResponse
    {
        $registration = $request->registration();

        $transaction = $registration->transaction;

        $refund = Refund::updateOrCreate(
            ['transaction_id' => $transaction->id],
            [
                'status' => RefundStatus::Pending,
                'reason' => $request->validated('reason'),
                'requested_at' => now(),
            ]
        );

        $transaction->update([
            'status' => PaymentStatus::Refunded,
        ]);

        $refund->loadMissing('transaction.registration.event', 'transaction.registration.user');

        $adminEmail = config('mail.admin_address') ?? config('mail.from.address');
        $userEmail = $registration->user->email ?? null;

        if ($adminEmail) {
            // Kirim langsung tanpa antrean
            Mail::to($adminEmail)->send(new RefundRequested($refund));
        }

        if ($userEmail) {
            // Kirim langsung tanpa antrean
            Mail::to($userEmail)->send(new RefundRequested($refund));

            Email::create([
                'registration_id' => $registration->id,
                'user_id' => $registration->user_id,
                'type' => 'refund_requested_user',
                'recipient' => $userEmail,
                'subject' => 'Permintaan Refund Diproses',
                'payload' => [
                    'registration_id' => $registration->id,
                    'refund_id' => $refund->id,
                ],
                'sent_at' => now(),
            ]);
        }

        Email::create([
            'registration_id' => $registration->id,
            'type' => 'refund_requested',
            'recipient' => $adminEmail,
            'subject' => 'Permintaan Refund Baru',
            'payload' => [
                'registration_id' => $registration->id,
                'refund_id' => $refund->id,
            ],
            'sent_at' => now(),
        ]);

        return redirect()
            ->route('profile.show', ['tab' => 'refund'])
            ->with('status', 'Permohonan refund telah dikirim. Menunggu proses verifikasi admin.');
    }
}
