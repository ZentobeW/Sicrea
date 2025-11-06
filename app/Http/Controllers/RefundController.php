<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Enums\RefundStatus;
use App\Http\Requests\StoreRefundRequest;
use App\Mail\RefundRequested;
use App\Models\RefundRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class RefundController extends Controller
{
    public function store(StoreRefundRequest $request): RedirectResponse
    {
        $registration = $request->registration();

        $refund = RefundRequest::updateOrCreate(
            ['registration_id' => $registration->id],
            [
                'status' => RefundStatus::Pending,
                'reason' => $request->validated('reason'),
                'requested_at' => now(),
            ]
        );

        $registration->update([
            'payment_status' => PaymentStatus::AwaitingVerification,
        ]);

        $refund->loadMissing('registration.event', 'registration.user');

        Mail::to(config('mail.from.address'))
            ->queue(new RefundRequested($refund));

        return back()->with('status', 'Permohonan refund telah dikirim. Menunggu proses verifikasi admin.');
    }
}
