<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Enums\RefundStatus;
use App\Enums\RegistrationStatus;
use App\Http\Controllers\Controller;
use App\Mail\PaymentVerified;
use App\Mail\RegistrationApproved;
use App\Models\RefundRequest;
use App\Models\Registration;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $registrations = Registration::query()
            ->with(['event', 'user'])
            ->when($request->string('payment_status'), fn ($query, $status) => $query->where('payment_status', $status))
            ->when($request->integer('event_id'), fn ($query, $eventId) => $query->where('event_id', $eventId))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $events = \App\Models\Event::orderBy('title')->get();

        $summary = [
            'total' => Registration::count(),
            'pendingPayment' => Registration::whereIn('payment_status', [
                PaymentStatus::Pending,
                PaymentStatus::AwaitingVerification,
            ])->count(),
            'verifiedPayment' => Registration::where('payment_status', PaymentStatus::Verified)->count(),
            'refundRequests' => RefundRequest::where('status', RefundStatus::Pending)->count(),
        ];

        return view('admin.registrations.index', compact('registrations', 'events', 'summary'));
    }

    public function show(Registration $registration): View
    {
        $registration->load(['event', 'user', 'refundRequest']);

        return view('admin.registrations.show', compact('registration'));
    }

    public function verifyPayment(Registration $registration): RedirectResponse
    {
        $registration->markVerified();

        $registration->loadMissing(['event', 'user']);

        Mail::to($registration->user->email)->queue(new PaymentVerified($registration));
        Mail::to($registration->user->email)->queue(new RegistrationApproved($registration));

        return back()->with('status', 'Pembayaran berhasil diverifikasi. Peserta menerima konfirmasi otomatis.');
    }

    public function rejectPayment(Registration $registration): RedirectResponse
    {
        $registration->update([
            'payment_status' => PaymentStatus::Rejected,
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
                ->with(['event', 'user'])
                ->when($request->string('payment_status'), fn ($query, $status) => $query->where('payment_status', $status))
                ->chunk(200, function ($chunk) use ($handle) {
                    foreach ($chunk as $registration) {
                        fputcsv($handle, [
                            $registration->event->title,
                            $registration->user->name,
                            $registration->user->email,
                            $registration->status->label(),
                            $registration->payment_status->label(),
                            $registration->amount,
                            $registration->registered_at?->format('d-m-Y H:i'),
                        ]);
                    }
                });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function approveRefund(RefundRequest $refund): RedirectResponse
    {
        $refund->update([
            'status' => RefundStatus::Approved,
            'processed_at' => now(),
        ]);

        $refund->registration->update([
            'status' => RegistrationStatus::Refunded,
            'payment_status' => PaymentStatus::Refunded,
        ]);

        $refund->loadMissing('registration.event', 'registration.user');

        Mail::to($refund->registration->user->email)->queue(new \App\Mail\RefundApproved($refund));

        return back()->with('status', 'Refund peserta disetujui dan ditandai selesai.');
    }

    public function rejectRefund(RefundRequest $refund): RedirectResponse
    {
        $refund->update([
            'status' => RefundStatus::Rejected,
            'processed_at' => now(),
        ]);

        $refund->loadMissing('registration.event', 'registration.user');

        $refund->registration->update([
            'payment_status' => PaymentStatus::Verified,
        ]);

        Mail::to($refund->registration->user->email)->queue(new \App\Mail\RefundRejected($refund));

        return back()->with('status', 'Refund ditolak dan peserta menerima notifikasi.');
    }
}
