<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EventStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $metrics = [
            'activeEvents' => Event::where('status', EventStatus::Published)->count(),
            'totalParticipants' => Registration::count(),
            'totalRevenue' => Registration::where('payment_status', PaymentStatus::Verified)->sum('amount'),
            'confirmedRegistrations' => Registration::where('payment_status', PaymentStatus::Verified)->count(),
        ];

        $recentRegistrations = Registration::with(['event', 'user'])
            ->orderByDesc('registered_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $upcomingEvents = Event::where('status', EventStatus::Published)
            ->where('start_at', '>=', now())
            ->orderBy('start_at')
            ->take(4)
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

        return view('admin.dashboard.index', compact('metrics', 'recentRegistrations', 'upcomingEvents', 'quickActions'));
    }
}
