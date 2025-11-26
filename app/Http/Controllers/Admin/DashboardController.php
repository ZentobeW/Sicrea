<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EventStatus;
use App\Enums\PaymentStatus;
use App\Enums\RefundStatus;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Transaction;
use App\Models\Refund;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $metrics = [
            'activeEvents' => Event::where('status', EventStatus::Published)->count(),
            'totalParticipants' => Registration::count(),
            'totalRevenue' => Transaction::where('status', PaymentStatus::Verified)->sum('amount'),
            'confirmedRegistrations' => Registration::whereHas('transaction', fn ($query) => $query->where('status', PaymentStatus::Verified))->count(),
        ];

        $awaitingVerification = Registration::with(['event', 'user', 'transaction'])
            ->whereHas('transaction', fn ($query) => $query->where('status', PaymentStatus::AwaitingVerification))
            ->orderByDesc('registered_at')
            ->take(5)
            ->get();

        $pendingRefunds = Refund::with(['transaction.registration.event', 'transaction.registration.user'])
            ->where('status', RefundStatus::Pending)
            ->orderByDesc('requested_at')
            ->take(5)
            ->get();

        $upcomingEvents = Event::where('status', EventStatus::Published)
            ->where('start_at', '>=', now())
            ->orderBy('start_at')
            ->take(10) 
            ->get();

        $quickActions = [
            [
                'label' => 'Tambah Event Baru',
                'description' => 'Susun jadwal workshop mendatang dan publikasikan dalam hitungan menit.',
                'route' => route('admin.events.create'),
            ],
            [
                'label' => 'Kelola Portofolio',
                'description' => 'Perbarui dokumentasi kegiatan untuk memperkuat cerita program.',
                'route' => route('admin.portfolios.index'),
            ],
            [
                'label' => 'Lihat Website',
                'description' => 'Tinjau tampilan publik setelah pembaruan konten dilakukan.',
                'route' => route('home'),
            ],
        ];

        return view('admin.dashboard.index', compact(
            'awaitingVerification', 
            'pendingRefunds', 
            'metrics', 
            'upcomingEvents', 
            'quickActions'
        ));
    }
}
