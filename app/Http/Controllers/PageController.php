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
            ->with(['event:id,title,slug'])
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
                'icon' => '💡',
            ],
            [
                'title' => 'Produksi End-to-End',
                'description' => 'Mulai dari talent, materi kreatif, hingga kebutuhan teknis ditangani menyeluruh agar pengalaman peserta terjaga.',
                'icon' => '🎬',
            ],
            [
                'title' => 'Aktivasi Multi Kanal',
                'description' => 'Distribusi konten lintas kanal memperluas jangkauan audiens dan memaksimalkan engagement.',
                'icon' => '📣',
            ],
            [
                'title' => 'Laporan & Insight',
                'description' => 'Analisis performa program membantu mitra memetakan dampak dan peluang kolaborasi berikutnya.',
                'icon' => '📊',
            ],
        ];

        $partnershipSupports = [
            [
                'title' => 'Sponsor Event',
                'description' => 'Berkolaborasi pada rangkaian workshop pilihan dan tampil di hadapan komunitas kreatif.',
                'icon' => '🎟️',
            ],
            [
                'title' => 'Venue Partnership',
                'description' => 'Sediakan ruang yang inspiratif untuk menghadirkan pengalaman offline yang berkesan.',
                'icon' => '🏢',
            ],
            [
                'title' => 'Corporate Workshop',
                'description' => 'Rancang sesi pengembangan talenta internal dengan materi yang dapat disesuaikan.',
                'icon' => '🧑‍🤝‍🧑',
            ],
            [
                'title' => 'Content Collaboration',
                'description' => 'Produksi konten edukatif atau promosi bersama untuk memperkuat citra brand secara digital.',
                'icon' => '🎥',
            ],
        ];

        $highlightStats = [
            [
                'value' => '40+',
                'label' => 'Brand Partners',
                'description' => 'Kolaborasi aktif dengan pelaku industri kreatif dan lifestyle.',
            ],
            [
                'value' => '120+',
                'label' => 'Event Terselenggara',
                'description' => 'Program hybrid dan offline sepanjang dua tahun terakhir.',
            ],
            [
                'value' => '8.5K',
                'label' => 'Peserta Terjangkau',
                'description' => 'Jangkauan audiens komunitas dan publik yang mengikuti program kami.',
            ],
        ];

        $featuredPortfolios = Portfolio::query()
            ->with(['event:id,title,slug'])
            ->latest('created_at')
            ->take(3)
            ->get();

        $contactInfo = [
            'email' => 'partnership@sicrea.id',
            'phone' => '+62 812-3456-7890',
            'address' => 'Jl. Kreasi No. 123, Jakarta Selatan',
            'whatsapp' => '6281234567890',
        ];

        return view('pages.partnership', compact(
            'partnershipBenefits',
            'partnershipSupports',
            'highlightStats',
            'featuredPortfolios',
            'contactInfo'
        ));
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
