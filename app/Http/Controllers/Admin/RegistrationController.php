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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegistrationController extends Controller
{
    // ... method index, show, verifyPayment, rejectPayment tetap sama ...

    public function index(Request $request): View
    {
        $view = $request->input('view', '');
        $isRefundView = in_array($view, ['refund', 'refunds'], true);
        $eventId = $request->input('event_id') ? (int)$request->input('event_id') : null;
        $search = trim((string) $request->input('search', ''));
        
        $statusFilter = ! $isRefundView
            ? PaymentStatus::tryFrom((string) $request->input('payment_status', ''))
            : null;
        $refundStatusFilter = $isRefundView
            ? RefundStatus::tryFrom((string) $request->input('refund_status', ''))
            : null;

        $registrationBase = Registration::query()
            ->when($eventId, fn ($query) => $query->where('event_id', $eventId))
            ->when($search, function ($query, $keyword) {
                $like = '%' . $keyword . '%';
                $query->where(function ($builder) use ($like) {
                    $builder
                        ->whereHas('user', fn ($user) => $user
                            ->where('name', 'like', $like)
                            ->orWhere('email', 'like', $like)
                            ->orWhere('phone', 'like', $like)
                        )
                        ->orWhereHas('event', fn ($event) => $event->where('title', 'like', $like)->orWhere('venue_name', 'like', $like)->orWhere('tutor_name', 'like', $like));
                });
            })
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
            ->when($search, function ($query, $keyword) {
                $like = '%' . $keyword . '%';
                $query->whereHas('transaction.registration', function ($registration) use ($like) {
                    $registration
                        ->whereHas('user', fn ($user) => $user
                            ->where('name', 'like', $like)
                            ->orWhere('email', 'like', $like)
                            ->orWhere('phone', 'like', $like)
                        )
                        ->orWhereHas('event', fn ($event) => $event->where('title', 'like', $like)->orWhere('venue_name', 'like', $like)->orWhere('tutor_name', 'like', $like));
                });
            })
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

        $filters = [
            'event_id' => $eventId,
            'payment_status' => $statusFilter?->value,
            'refund_status' => $refundStatusFilter?->value,
            'view' => $isRefundView ? 'refunds' : null,
            'search' => $search,
        ];

        if ($request->ajax()) {
            return view('admin.registrations.partials.table', [
                'items' => $isRefundView ? ($refunds ?? collect()) : $registrations,
                'isRefundView' => $isRefundView,
                'filters' => $filters,
            ]);
        }

        return view('admin.registrations.index', [
            'registrations' => $registrations,
            'events' => $events,
            'registrationSummary' => $registrationSummary,
            'refundSummary' => $refundSummary,
            'isRefundView' => $isRefundView,
            'refunds' => $refunds,
            'filters' => $filters,
        ]);
    }

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

    public function verifyPayment(Request $request, Registration $registration): RedirectResponse
    {
        $registration->markVerified();

        $adminNote = $request->string('admin_note', '')->limit(500)->toString();
        if (filled($adminNote)) {
            $registration->update([
                'notes' => $adminNote,
            ]);
        }

        try {
            $registration->loadMissing(['event', 'user', 'transaction']);

            Mail::to($registration->user->email)->send(new PaymentVerified($registration));
            Mail::to($registration->user->email)->send(new RegistrationApproved($registration));

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
        } catch (\Exception $e) {
            Log::error("Email verifikasi gagal: " . $e->getMessage());
            return back()->with('status', 'Pembayaran diverifikasi, namun email gagal terkirim (Cek SMTP).');
        }

        return back()->with('status', 'Pembayaran berhasil diverifikasi. Peserta menerima konfirmasi otomatis.');
    }

    public function rejectPayment(Request $request, Registration $registration): RedirectResponse
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

        // Tangkap input view untuk filter refund jika diperlukan
        $isRefundView = in_array($request->string('view'), ['refund', 'refunds'], true);

        $eventIds = collect((array) $request->input('event_ids', []))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();

        if ($request->filled('event_id')) {
            $eventIds->push((int) $request->integer('event_id'));
            $eventIds = $eventIds->unique()->values();
        }

        // Ambil status pembayaran jika ada
        $paymentStatus = $request->filled('payment_status') 
            ? \App\Enums\PaymentStatus::tryFrom((string)$request->input('payment_status')) 
            : null;

        $fileName = sprintf('%s-%s.csv', $reportType, now()->format('Ymd-His'));
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($reportType, $eventIds, $paymentStatus, $isRefundView) {
            $handle = fopen('php://output', 'wb');

            // BOM untuk support Excel
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
                fputcsv($handle, [
                    'Event',
                    'Nama Peserta',
                    'Email',
                    'No. Telepon',
                    'Status Pendaftaran',
                    'Status Pembayaran',
                    'Tanggal Daftar'
                ], $delimiter);
            }

            // QUERY UTAMA
            Registration::query()
                ->with(['event', 'user', 'transaction.refund'])
                // Join ke Events untuk Sorting
                ->join('events', 'registrations.event_id', '=', 'events.id')
                ->select('registrations.*') // Penting: Agar ID Registration tidak tertimpa ID Event
                
                // Filter Event IDs
                ->when($eventIds->isNotEmpty(), fn ($query) => $query->whereIn('registrations.event_id', $eventIds))
                
                // Filter Payment Status
                ->when($paymentStatus, function ($query, $status) {
                    $query->whereHas('transaction', fn ($q) => $q->where('status', $status));
                })
                
                // Filter Refund View
                ->when($isRefundView, fn ($query) => $query->whereHas('transaction.refund'))
                
                // Sorting: Event Terdekat -> Pendaftar Terbaru
                ->orderBy('events.start_at', 'asc')
                ->orderBy('registrations.registered_at', 'desc')
                
                // Chunking untuk performa
                ->chunk(200, function ($chunk) use ($handle, $delimiter, $reportType) {
                    foreach ($chunk as $registration) {
                        $transaction = $registration->transaction;
                        $refund = $transaction?->refund;
                        $event = $registration->event;
                        $user = $registration->user;

                        // Ambil data dengan aman (gunakan optional atau null coalescing)
                        $eventName = $event?->title ?? 'Event Terhapus';
                        $userName = $user?->name ?? 'User Terhapus';
                        $userEmail = $user?->email ?? '-';
                        $userPhone = $user?->phone ?? '-';
                        
                        $paymentStatusLabel = $transaction?->status?->label() ?? 'Belum Ada Transaksi';
                        $amount = $transaction?->amount ?? 0;
                        
                        $paidAt = optional($transaction?->paid_at)->format('d-m-Y H:i') ?? '-';
                        $verifiedAt = optional($transaction?->verified_at)->format('d-m-Y H:i') ?? '-';
                        $refundLabel = $refund?->status?->label() ?? '-';
                        
                        $regStatusLabel = $registration->status->label();
                        $regDate = optional($registration->registered_at)->format('d-m-Y H:i') ?? '-';

                        if ($reportType === 'finance') {
                            fputcsv($handle, [
                                $eventName,
                                $userName,
                                $userEmail,
                                $paymentStatusLabel,
                                $amount,
                                $paidAt,
                                $verifiedAt,
                                $refundLabel,
                            ], $delimiter);
                        } else {
                            fputcsv($handle, [
                                $eventName,
                                $userName,
                                $userEmail,
                                $userPhone,
                                $regStatusLabel,
                                $paymentStatusLabel,
                                $regDate,
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

        try {
            $refund->loadMissing('transaction.registration.event', 'transaction.registration.user');

            if ($refund->transaction?->registration?->user) {
                $email = $refund->transaction->registration->user->email;
                Mail::to($email)->send(new \App\Mail\RefundApproved($refund));

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
        } catch (\Exception $e) {
            Log::error("Gagal kirim email refund disetujui: " . $e->getMessage());
            return back()->with('status', 'Refund disetujui, namun email notifikasi gagal terkirim.');
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

        try {
            if ($refund->transaction?->registration?->user) {
                $email = $refund->transaction->registration->user->email;
                Mail::to($email)->send(new \App\Mail\RefundRejected($refund));

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
        } catch (\Exception $e) {
            Log::error("Gagal kirim email refund ditolak: " . $e->getMessage());
            return back()->with('status', 'Refund ditolak, namun email notifikasi gagal terkirim.');
        }

        return back()->with('status', 'Refund ditolak dan peserta menerima notifikasi.');
    }
}