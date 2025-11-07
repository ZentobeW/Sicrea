<?php

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Enums\RegistrationStatus;
use App\Models\Event;
use App\Models\Portfolio;
use App\Models\Registration;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $upcomingEvents = Event::query()
            ->where('status', EventStatus::Published)
            ->orderBy('start_at')
            ->limit(3)
            ->get();

        $featuredPortfolios = Portfolio::query()
            ->with(['event:id,title'])
            ->latest('created_at')
            ->take(3)
            ->get();

        $stats = [
            'published_events' => Event::query()
                ->where('status', EventStatus::Published)
                ->count(),
            'confirmed_participants' => Registration::query()
                ->where('status', RegistrationStatus::Confirmed)
                ->count(),
        ];

        return view('pages.home', compact('upcomingEvents', 'featuredPortfolios', 'stats'));
    }

    public function portfolio(): View
    {
        $portfolios = Portfolio::query()
            ->with(['event:id,title,slug,start_at'])
            ->latest('created_at')
            ->paginate(9);

        return view('pages.portfolio', compact('portfolios'));
    }

    public function partnership(): View
    {
        $partnershipBenefits = [
            [
                'title' => 'Kurasi Konsep',
                'description' => 'Tim kami membantu merumuskan ide dan format aktivitas yang selaras dengan tujuan brand maupun komunitas.',
            ],
            [
                'title' => 'Produksi End-to-End',
                'description' => 'Mulai dari talent, materi kreatif, hingga kebutuhan teknis ditangani secara menyeluruh agar pengalaman peserta terjaga.',
            ],
            [
                'title' => 'Aktivasi Multi Kanal',
                'description' => 'Distribusi konten dan publikasi dilakukan lintas kanal untuk memperluas jangkauan audiens dan memaksimalkan engagement.',
            ],
        ];

        $partnershipSupports = [
            [
                'title' => 'Sponsor Event',
                'description' => 'Berkolaborasi pada rangkaian workshop pilihan dan tampil di hadapan komunitas kreatif.',
            ],
            [
                'title' => 'Venue Partnership',
                'description' => 'Sediakan ruang yang inspiratif untuk menghadirkan pengalaman offline yang berkesan.',
            ],
            [
                'title' => 'Corporate Workshop',
                'description' => 'Rancang sesi pengembangan talenta internal dengan materi yang dapat disesuaikan.',
            ],
        ];

        return view('pages.partnership', compact('partnershipBenefits', 'partnershipSupports'));
    }

    public function about(): View
    {
        $values = [
            [
                'title' => 'Kolaboratif',
                'description' => 'Mendengar kebutuhan peserta dan mitra agar solusi yang dihadirkan terasa relevan.',
            ],
            [
                'title' => 'Eksperiensial',
                'description' => 'Mengemas pembelajaran berbasis praktik sehingga peserta dapat langsung menerapkan insight.',
            ],
            [
                'title' => 'Berdampak',
                'description' => 'Mengukur keberhasilan dengan perubahan nyata pada individu maupun komunitas.',
            ],
        ];

        $teamMembers = [
            [
                'name' => 'Nama Founder',
                'role' => 'Creative Director',
            ],
            [
                'name' => 'Nama Co-Founder',
                'role' => 'Program Lead',
            ],
            [
                'name' => 'Nama Co-Founder',
                'role' => 'Operations Lead',
            ],
        ];

        $stats = [
            'published_events' => Event::query()
                ->where('status', EventStatus::Published)
                ->count(),
            'confirmed_participants' => Registration::query()
                ->where('status', RegistrationStatus::Confirmed)
                ->count(),
        ];

        return view('pages.about', compact('values', 'teamMembers', 'stats'));
    }
}
