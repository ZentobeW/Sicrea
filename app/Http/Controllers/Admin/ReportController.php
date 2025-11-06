<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Enums\RefundStatus;
use App\Enums\RegistrationStatus;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\RefundRequest;
use App\Models\Registration;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $events = Event::query()
            ->withCount([
                'registrations as total_registrations_count',
                'registrations as confirmed_registrations_count' => fn ($query) => $query->where('status', RegistrationStatus::Confirmed),
            ])
            ->orderByDesc('start_at')
            ->orderBy('title')
            ->get(['id', 'title', 'start_at']);

        $selectedEventId = $request->filled('event_id') ? $request->integer('event_id') : $events->first()?->id;
        $tab = $request->string('tab')->toString() ?: 'participants';
        $tab = in_array($tab, ['participants', 'finance'], true) ? $tab : 'participants';

        $selectedEvent = $events->firstWhere('id', $selectedEventId);

        $participantMetrics = [
            'total' => 0,
            'confirmed' => 0,
            'pending' => 0,
            'refund_requests' => 0,
        ];
        $financialMetrics = [
            'target' => 0,
            'received' => 0,
            'pending' => 0,
            'refunded' => 0,
        ];
        $recentRegistrations = collect();
        $paymentBreakdown = collect();

        if ($selectedEventId) {
            $registrationBase = fn () => Registration::query()->where('event_id', $selectedEventId);

            $participantMetrics = [
                'total' => $registrationBase()->count(),
                'confirmed' => $registrationBase()->where('status', RegistrationStatus::Confirmed)->count(),
                'pending' => $registrationBase()->where('payment_status', PaymentStatus::Pending)->count(),
                'refund_requests' => $registrationBase()->whereHas('refundRequest', fn ($query) => $query->where('status', '!=', RefundStatus::Rejected->value))->count(),
            ];

            $financialMetrics = [
                'target' => $registrationBase()->sum('amount'),
                'received' => $registrationBase()->where('payment_status', PaymentStatus::Verified)->sum('amount'),
                'pending' => $registrationBase()->where('payment_status', PaymentStatus::Pending)->sum('amount'),
                'refunded' => RefundRequest::query()
                    ->where('status', RefundStatus::Approved)
                    ->whereHas('registration', fn ($query) => $query->where('event_id', $selectedEventId))
                    ->with('registration:id,amount,event_id')
                    ->get()
                    ->sum(fn ($refund) => $refund->registration?->amount ?? 0),
            ];

            $recentRegistrations = $registrationBase()
                ->with(['user:id,name,email', 'refundRequest'])
                ->latest('registered_at')
                ->take(6)
                ->get();

            $paymentBreakdown = collect(PaymentStatus::cases())->map(function (PaymentStatus $status) use ($registrationBase) {
                $count = $registrationBase()->where('payment_status', $status)->count();
                $sum = $registrationBase()->where('payment_status', $status)->sum('amount');

                return [
                    'status' => $status,
                    'count' => $count,
                    'sum' => $sum,
                ];
            })->filter(fn (array $entry) => $entry['count'] > 0 || $entry['sum'] > 0);
        }

        return view('admin.reports.index', [
            'events' => $events,
            'selectedEvent' => $selectedEvent,
            'selectedEventId' => $selectedEventId,
            'tab' => $tab,
            'participantMetrics' => $participantMetrics,
            'financialMetrics' => $financialMetrics,
            'recentRegistrations' => $recentRegistrations,
            'paymentBreakdown' => $paymentBreakdown,
        ]);
    }
}
