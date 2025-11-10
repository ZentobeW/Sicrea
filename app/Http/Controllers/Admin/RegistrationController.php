<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Enums\RefundStatus;
use App\Enums\RegistrationStatus;
use App\Http\Controllers\Controller;
use App\Mail\PaymentVerified;
use App\Mail\RegistrationApproved;
use App\Models\Email;
use App\Models\Refund;
use App\Models\Registration;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $applyFilters = function ($query) use ($request) {
            return $query
                ->when($request->string('payment_status'), function ($registrationQuery, $status) {
                    $registrationQuery->whereHas('transaction', fn ($transactionQuery) => $transactionQuery->where('status', $status));
                })
                ->when($request->integer('event_id'), fn ($registrationQuery, $eventId) => $registrationQuery->where('event_id', $eventId));
        };

        $isRefundView = $request->string('view') === 'refunds';

        $registrationsQuery = Registration::query()
            ->with(['event', 'user', 'transaction.refund'])
            ->when($isRefundView, fn ($query) => $query->whereHas('transaction.refund'))
            ->orderByDesc('registered_at');

        $applyFilters($registrationsQuery);

        $registrations = $registrationsQuery
            ->paginate(12)
            ->withQueryString();

        $summaryBase = Registration::query()
            ->when($isRefundView, fn ($query) => $query->whereHas('transaction.refund'));
        $applyFilters($summaryBase);

        $transactionSummaryBase = Transaction::query()
            ->whereHas('registration', function ($registrationQuery) use ($applyFilters, $isRefundView) {
                $applyFilters($registrationQuery);

                if ($isRefundView) {
                    $registrationQuery->whereHas('transaction.refund');
                }
            });

        $registrationSummary = [
            'total' => (clone $summaryBase)->count(),
            'awaiting' => (clone $transactionSummaryBase)->whereIn('status', [
                PaymentStatus::Pending,
                PaymentStatus::AwaitingVerification,
            ])->count(),
            'verified' => (clone $transactionSummaryBase)->where('status', PaymentStatus::Verified)->count(),
            'amount' => (clone $transactionSummaryBase)->sum('amount'),
            'pendingRefunds' => Refund::query()
                ->where('status', RefundStatus::Pending)
                ->when($request->integer('event_id'), function ($query, $eventId) use ($applyFilters) {
                    $query->whereHas('transaction.registration', fn ($registrationQuery) => $applyFilters($registrationQuery)->where('event_id', $eventId));
                })
                ->count(),
        ];

        $refundBase = Refund::query()
            ->with('transaction.registration')
            ->when($request->integer('event_id'), function ($query, $eventId) use ($applyFilters) {
                $query->whereHas('transaction.registration', function ($registrationQuery) use ($applyFilters, $eventId) {
                    $applyFilters($registrationQuery);
                    $registrationQuery->where('event_id', $eventId);
                });
            });

        $refundSummary = [
            'total' => (clone $refundBase)->count(),
            'approved' => (clone $refundBase)->whereIn('status', [RefundStatus::Approved, RefundStatus::Completed])->count(),
            'amount' => (clone $refundBase)->get()->sum(fn ($refund) => optional($refund->transaction)->amount ?? 0),
        ];
            'registrationSummary' => $registrationSummary,
            'refundSummary' => $refundSummary,
            'isRefundView' => $isRefundView,
        ]);
    }

    public function show(Registration $registration): View
    {
        $registration->load(['event', 'user', 'transaction.refund']);

        return view('admin.registrations.show', compact('registration'));
    }

    public function verifyPayment(Registration $registration): RedirectResponse
    {
        $registration->markVerified();

        $registration->loadMissing(['event', 'user', 'transaction']);

        Mail::to($registration->user->email)->queue(new PaymentVerified($registration));
        Mail::to($registration->user->email)->queue(new RegistrationApproved($registration));

        Email::create([
            'user_id' => $registration->user_id,
            'registration_id' => $registration->id,
            'type' => 'payment_verified',
            'recipient' => $registration->user->email,
            'subject' => 'Pembayaran Terverifikasi',
            'payload' => ['registration_id' => $registration->id],
            'sent_at' => now(),
        ]);

        Email::create([
            'user_id' => $registration->user_id,
            'registration_id' => $registration->id,
            'type' => 'registration_approved',
            'recipient' => $registration->user->email,
            'subject' => 'Pendaftaran Diterima',
            'payload' => ['registration_id' => $registration->id],
            'sent_at' => now(),
        ]);

        return back()->with('status', 'Pembayaran berhasil diverifikasi. Peserta menerima konfirmasi otomatis.');
    }

    public function rejectPayment(Registration $registration): RedirectResponse
    {
        $registration->transaction?->update([
            'status' => PaymentStatus::Rejected,
        ]);

        return back()->with('status', 'Pembayaran ditandai sebagai ditolak. Peserta akan diminta mengunggah ulang bukti.');
    }

    public function export(Request $request): StreamedResponse
    {
        $fileName = 'registrations-' . now()->format('Ymd-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($request) {
            $handle = fopen('php://output', 'wb');
            fputcsv($handle, ['Event', 'Nama Peserta', 'Email', 'Status Pendaftaran', 'Status Pembayaran', 'Jumlah', 'Tanggal Daftar']);

            Registration::query()
                ->with(['event', 'user', 'transaction'])
                ->when($request->string('payment_status'), function ($query, $status) {
                    $query->whereHas('transaction', fn ($transactionQuery) => $transactionQuery->where('status', $status));
                })
                ->chunk(200, function ($chunk) use ($handle) {
                    foreach ($chunk as $registration) {
                        $transaction = $registration->transaction;

                        fputcsv($handle, [
                            $registration->event->title,
                            $registration->user->name,
                            $registration->user->email,
                            $registration->status->label(),
                            $transaction?->status->label() ?? '-',
                            $transaction?->amount,
                            $registration->registered_at?->format('d-m-Y H:i'),
                        ]);
                    }
                });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function approveRefund(Refund $refund): RedirectResponse
    {
        $refund->update([
            'status' => RefundStatus::Approved,
            'processed_at' => now(),
        ]);

        $refund->transaction?->update([
            'status' => PaymentStatus::Refunded,
        ]);

        $refund->transaction?->registration?->update([
            'status' => RegistrationStatus::Refunded,
        ]);

        $refund->loadMissing('transaction.registration.event', 'transaction.registration.user');

        if ($refund->transaction?->registration?->user) {
            $email = $refund->transaction->registration->user->email;
            Mail::to($email)->queue(new \App\Mail\RefundApproved($refund));

            Email::create([
                'user_id' => $refund->transaction->registration->user_id,
                'registration_id' => $refund->transaction->registration->id,
                'type' => 'refund_approved',
                'recipient' => $email,
                'subject' => 'Refund Disetujui',
                'payload' => ['refund_id' => $refund->id],
                'sent_at' => now(),
            ]);
        }

        return back()->with('status', 'Refund peserta disetujui dan ditandai selesai.');
    }

    public function rejectRefund(Refund $refund): RedirectResponse
    {
        $refund->update([
            'status' => RefundStatus::Rejected,
            'processed_at' => now(),
        ]);

        $refund->loadMissing('transaction.registration.event', 'transaction.registration.user');

        $refund->transaction?->update([
            'status' => PaymentStatus::Verified,
        ]);

        if ($refund->transaction?->registration?->user) {
            $email = $refund->transaction->registration->user->email;
            Mail::to($email)->queue(new \App\Mail\RefundRejected($refund));

            Email::create([
                'user_id' => $refund->transaction->registration->user_id,
                'registration_id' => $refund->transaction->registration->id,
                'type' => 'refund_rejected',
                'recipient' => $email,
                'subject' => 'Refund Ditolak',
                'payload' => ['refund_id' => $refund->id],
                'sent_at' => now(),
            ]);
        }

        return back()->with('status', 'Refund ditolak dan peserta menerima notifikasi.');
    }
}
