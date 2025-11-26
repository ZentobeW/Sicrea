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
        $view = $request->input('view', '');
        $isRefundView = in_array($view, ['refund', 'refunds'], true);
        $eventId = $request->input('event_id') ? (int)$request->input('event_id') : null;
        
        $statusFilter = ! $isRefundView
            ? PaymentStatus::tryFrom((string) $request->input('payment_status', ''))
            : null;
        $refundStatusFilter = $isRefundView
            ? RefundStatus::tryFrom((string) $request->input('refund_status', ''))
            : null;

        $registrationBase = Registration::query()
            ->when($eventId, fn ($query) => $query->where('event_id', $eventId))
            ->when($statusFilter, fn ($query) => $query->whereHas('transaction', fn ($transaction) => $transaction->where('status', $statusFilter)))
            ->when($isRefundView, fn ($query) => $query->whereHas('transaction.refund'));

        $registrations = (clone $registrationBase)
            ->with([
                'event:id,title,start_at,venue_name,venue_address,tutor_name',
                'user:id,name,email,phone',
                'transaction' => fn ($transaction) => $transaction->with('refund'),
            ])
            ->orderByDesc('registered_at')
            ->paginate(12)
            ->withQueryString();

        $transactionBase = Transaction::query()
            ->when($statusFilter, fn ($query) => $query->where('status', $statusFilter))
            ->whereHas('registration', function ($query) use ($eventId, $isRefundView) {
                $query
                    ->when($eventId, fn ($registration) => $registration->where('event_id', $eventId))
                    ->when($isRefundView, fn ($registration) => $registration->whereHas('transaction.refund'));
            });

        $registrationSummary = [
            'total' => (clone $registrationBase)->count(),
            'awaiting' => (clone $transactionBase)->whereIn('status', [
                PaymentStatus::Pending,
                PaymentStatus::AwaitingVerification,
            ])->count(),
            'verified' => (clone $transactionBase)->where('status', PaymentStatus::Verified)->count(),
            'amount' => (clone $transactionBase)->sum('amount'),
            'pendingRefunds' => Refund::query()
                ->where('status', RefundStatus::Pending)
                ->when($eventId, fn ($query) => $query->whereHas('transaction.registration', fn ($registration) => $registration->where('event_id', $eventId)))
                ->when($statusFilter, fn ($query) => $query->whereHas('transaction', fn ($transaction) => $transaction->where('status', $statusFilter)))
                ->count(),
        ];

        $refundBase = Refund::query()
            ->with('transaction.registration')
            ->when($eventId, fn ($query) => $query->whereHas('transaction.registration', fn ($registration) => $registration->where('event_id', $eventId)))
            ->when($refundStatusFilter, fn ($query) => $query->where('status', $refundStatusFilter));

        $refunds = null;
        if ($isRefundView) {
            $refunds = (clone $refundBase)
                ->with(['transaction.registration.event', 'transaction.registration.user'])
                ->orderByDesc('requested_at')
                ->paginate(12)
                ->withQueryString();
        }

        $refundSummary = [
            'total' => (clone $refundBase)->count(),
            'pending' => (clone $refundBase)->where('status', RefundStatus::Pending)->count(),
            'approved' => (clone $refundBase)->whereIn('status', [RefundStatus::Approved, RefundStatus::Completed])->count(),
            'amount' => (clone $refundBase)->with('transaction')->get()->sum(fn ($refund) => optional($refund->transaction)->amount ?? 0),
        ];

        $events = \App\Models\Event::orderBy('title')->get();

        return view('admin.registrations.index', [
            'registrations' => $registrations,
            'events' => $events,
            'registrationSummary' => $registrationSummary,
            'refundSummary' => $refundSummary,
            'isRefundView' => $isRefundView,
            'refunds' => $refunds,
        ]);
    }

    // Method lain tetap sama (show, verifyPayment, rejectPayment, export, approveRefund, rejectRefund)
    public function show(Registration $registration): View
    {
        $registration->load([
            'event',
            'user',
            'transaction.refund',
            'emails' => fn ($q) => $q->orderByDesc('sent_at')->orderByDesc('id'),
        ]);

        return view('admin.registrations.show', compact('registration'));
    }

    public function verifyPayment(Registration $registration): RedirectResponse
    {
        $registration->markVerified();

        $adminNote = $request->string('admin_note', '')->limit(500)->toString();
        if (filled($adminNote)) {
            $registration->update([
                'notes' => $adminNote,
            ]);
        }

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
        $adminNote = $request->string('admin_note', '')->limit(500)->toString();

        if (! filled($adminNote)) {
            return back()->withErrors(['admin_note' => 'Catatan penolakan wajib diisi.'])->onlyInput('admin_note');
        }

        $registration->transaction?->update([
            'status' => PaymentStatus::Rejected,
        ]);

        $registration->update([
            'notes' => $adminNote,
        ]);

        return back()->with('status', 'Pembayaran ditandai sebagai ditolak. Peserta akan diminta mengunggah ulang bukti.');
    }

    public function export(Request $request): StreamedResponse
    {
        $reportType = $request->string('report')->toString();
        $reportType = in_array($reportType, ['finance', 'participants'], true) ? $reportType : 'participants';

        $eventIds = collect((array) $request->input('event_ids', []))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();

        if ($request->filled('event_id')) {
            $eventIds->push((int) $request->integer('event_id'));
            $eventIds = $eventIds->unique()->values();
        }

        $fileName = sprintf('%s-%s.csv', $reportType, now()->format('Ymd-His'));
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($request, $reportType, $eventIds) {
            $handle = fopen('php://output', 'wb');

            // Ensure Excel on Windows recognizes UTF-8
            fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            $delimiter = ';';

            if ($reportType === 'finance') {
                fputcsv($handle, [
                    'Event',
                    'Nama Peserta',
                    'Email',
                    'Status Pembayaran',
                    'Jumlah',
                    'Dibayar Pada',
                    'Terverifikasi Pada',
                    'Status Refund',
                ], $delimiter);
            } else {
                fputcsv($handle, ['Event', 'Nama Peserta', 'Email', 'No. Telepon', 'Status Pendaftaran', 'Status Pembayaran', 'Tanggal Daftar'], $delimiter);
            }

            $status = \App\Enums\PaymentStatus::tryFrom((string) $request->string('payment_status'));

            Registration::query()
                ->with(['event', 'user', 'transaction.refund'])
                ->when($eventIds->isNotEmpty(), fn ($query) => $query->whereIn('event_id', $eventIds))
                ->when($status, function ($query, $status) {
                    $query->whereHas('transaction', fn ($transactionQuery) => $transactionQuery->where('status', $status));
                })
                ->when(in_array($request->string('view'), ['refund', 'refunds'], true), fn ($query) => $query->whereHas('transaction.refund'))
                ->orderByDesc('registered_at')
                ->chunk(200, function ($chunk) use ($handle, $delimiter, $reportType) {
                    foreach ($chunk as $registration) {
                        $transaction = $registration->transaction;
                        $refund = $transaction?->refund;

                        if ($reportType === 'finance') {
                            fputcsv($handle, [
                                $registration->event->title,
                                $registration->user->name,
                                $registration->user->email,
                                $transaction?->status->label() ?? '-',
                                $transaction?->amount ?? 0,
                                optional($transaction?->paid_at)?->format('d-m-Y H:i'),
                                optional($transaction?->verified_at)?->format('d-m-Y H:i'),
                                $refund?->status?->label() ?? '-',
                            ], $delimiter);
                        } else {
                            fputcsv($handle, [
                                $registration->event->title,
                                $registration->user->name,
                                $registration->user->email,
                                $registration->user->phone,
                                $registration->status->label(),
                                $transaction?->status->label() ?? '-',
                                $registration->registered_at?->format('d-m-Y H:i'),
                            ], $delimiter);
                        }
                    }
                });

            fclose($handle);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }

    public function approveRefund(Request $request, Refund $refund): RedirectResponse
    {
        $adminNote = $request->string('admin_note', '')->limit(500)->toString();

        $refund->update([
            'status' => RefundStatus::Approved,
            'processed_at' => now(),
            'admin_note' => $adminNote,
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

    public function rejectRefund(Request $request, Refund $refund): RedirectResponse
    {
        $adminNote = $request->string('admin_note', '')->limit(500)->toString();

        $refund->update([
            'status' => RefundStatus::Rejected,
            'processed_at' => now(),
            'admin_note' => $adminNote,
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