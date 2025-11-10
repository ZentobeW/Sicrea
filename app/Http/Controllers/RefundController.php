<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Enums\RefundStatus;
use App\Http\Requests\StoreRefundRequest;
use App\Mail\RefundRequested;
use App\Models\Email;
use App\Models\Refund;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class RefundController extends Controller
{
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
            'status' => PaymentStatus::AwaitingVerification,
        ]);

        $refund->loadMissing('transaction.registration.event', 'transaction.registration.user');

        Mail::to(config('mail.from.address'))
            ->queue(new RefundRequested($refund));

        Email::create([
            'registration_id' => $registration->id,
            'type' => 'refund_requested',
            'recipient' => config('mail.from.address'),
            'subject' => 'Permintaan Refund Baru',
            'payload' => [
                'registration_id' => $registration->id,
                'refund_id' => $refund->id,
            ],
            'sent_at' => now(),
        ]);

        return back()->with('status', 'Permohonan refund telah dikirim. Menunggu proses verifikasi admin.');
    }
}
