<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Enums\RefundStatus;
use App\Enums\RegistrationStatus;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Refund;
use App\Models\Registration;
use App\Models\Transaction;
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
            ->get(['id', 'title', 'start_at', 'venue_name', 'venue_address', 'tutor_name']);

        $selectedEventId = $request->filled('event_id') ? $request->integer('event_id') : $events->first()?->id;
        $reportType = $request->string('report')->toString() ?: 'participants';
        $reportType = in_array($reportType, ['participants', 'finance'], true) ? $reportType : 'participants';

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
            $transactionBase = fn () => Transaction::query()->whereHas('registration', fn ($query) => $query->where('event_id', $selectedEventId));

            $participantMetrics = [
                'total' => $registrationBase()->count(),
                'confirmed' => $registrationBase()->where('status', RegistrationStatus::Confirmed)->count(),
                'pending' => $registrationBase()->whereHas('transaction', function ($query) {
                    $query->whereIn('status', [
                        PaymentStatus::Pending,
                        PaymentStatus::AwaitingVerification,
                    ]);
                })->count(),
                'refund_requests' => $transactionBase()->whereHas('refund', fn ($query) => $query->where('status', '!=', RefundStatus::Rejected->value))->count(),
            ];

            $financialMetrics = [
                'target' => $transactionBase()->sum('amount'),
                'received' => $transactionBase()->where('status', PaymentStatus::Verified)->sum('amount'),
                'pending' => $transactionBase()->whereIn('status', [
                    PaymentStatus::Pending,
                    PaymentStatus::AwaitingVerification,
                ])->sum('amount'),
                'refunded' => Refund::query()
                    ->where('status', RefundStatus::Approved)
                    ->whereHas('transaction.registration', fn ($query) => $query->where('event_id', $selectedEventId))
                    ->with('transaction:id,amount,registration_id')
                    ->get()
                    ->sum(fn ($refund) => $refund->transaction?->amount ?? 0),
            ];

            $recentRegistrations = $registrationBase()
                ->with(['user:id,name,email', 'transaction.refund'])
                ->latest('registered_at')
                ->take(6)
                ->get();

            $registrationIds = $registrationBase()->pluck('id')->all();

            $paymentBreakdown = collect(PaymentStatus::cases())->map(function (PaymentStatus $status) use ($registrationIds) {
                $transactionQuery = Transaction::query()
                    ->whereIn('registration_id', $registrationIds)
                    ->where('status', $status);

                $count = (clone $transactionQuery)->count();
                $sum = (clone $transactionQuery)->sum('amount');

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
            'reportType' => $reportType,
            'participantMetrics' => $participantMetrics,
            'financialMetrics' => $financialMetrics,
            'recentRegistrations' => $recentRegistrations,
            'paymentBreakdown' => $paymentBreakdown,
        ]);
    }
}
