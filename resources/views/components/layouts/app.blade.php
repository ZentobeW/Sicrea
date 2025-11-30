@props([
    'title' => config('app.name', 'Sicrea'),
    'isAdmin' => false,
])

@php
    use Illuminate\Support\Facades\Route;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <!-- Fonts: Poppins (title), Open Sans (body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        :root{
            --primary: #822021; /* button & footer background */
            --on-primary: #FCF5E6; /* button text & header text */
            --header-bg: #FCF5E6; /* main header background */
            --footer-bg: #822021; /* main footer background */
            --font-title: 'Poppins', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue';
            --font-subtitle: 'Poppins', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue';
            --font-body: 'Open Sans', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto;
        }

        .btn-primary{
            background-color: var(--primary) !important;
            color: var(--on-primary) !important;
            font-family: var(--font-body) !important;
        }

        .btn-primary:hover{
            filter: brightness(.9);
        }

        header.app-header{
            background-color: var(--header-bg) !important;
            font-family: var(--font-body);
        }

        /* Title (judul) - Poppins */
        .site-title{
            font-family: var(--font-title);
        }

        /* Subtitles (sub judul) - Courier New */
        h2, h3, h4, .subtitle{
            font-family: var(--font-subtitle);
        }

        /* Body (isi) - Open Sans */
        body{
            font-family: var(--font-body);
        }

        footer.app-footer{
            background-color: var(--footer-bg) !important;
            color: var(--on-primary) !important;
        }
        /* Navigation link styles */
        .nav-link{
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .375rem .75rem;
            border-radius: 9999px;
            color: #9A5A46;
            transition: background-color .22s ease, color .18s ease, transform .12s ease;
            -webkit-tap-highlight-color: transparent;
        }

        .nav-link:hover{
            background-color: rgba(130,32,33,.7); /* --primary at 70% */
            color: var(--on-primary);
            transform: translateY(-2px);
        }

        .nav-link.active{
            background-color: var(--primary);
            color: var(--on-primary);
        }

        /* Apply same styles to mobile menu anchors inside header if present */
        header .mobile-menu a,
        header .mobile-nav a,
        header .mobile-links a{
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .375rem .75rem;
            border-radius: 9999px;
            color: #9A5A46;
            transition: background-color .22s ease, color .18s ease, transform .12s ease;
            -webkit-tap-highlight-color: transparent;
        }

        header .mobile-menu a:hover,
        header .mobile-nav a:hover,
        header .mobile-links a:hover{
            background-color: rgba(130,32,33,.7);
            color: var(--on-primary);
            transform: translateY(-2px);
        }

        header .mobile-menu a.active,
        header .mobile-nav a.active,
        header .mobile-links a.active{
            background-color: var(--primary);
            color: var(--on-primary);
        }
        /* Footer social buttons */
        .footer-social{ display:flex; gap:.75rem; align-items:center; }
        .footer-social a.social-btn{ display:inline-flex; align-items:center; gap:.5rem; text-decoration:none; color:var(--on-primary); }
        .footer-social .social-icon{ height:2.5rem; width:2.5rem; display:inline-flex; align-items:center; justify-content:center; border-radius:9999px; background: rgba(255,255,255,0.06); transition: background-color .18s ease, transform .12s ease; }
        .footer-social a.social-btn:hover .social-icon{ background: rgba(130,32,33,0.7); color:var(--on-primary); transform: translateY(-2px); }
    </style>
</head>
<body @class([
    'bg-slate-50 text-slate-900 min-h-screen' => ! $isAdmin,
    'min-h-screen bg-[#FFEDE3] text-[#4B2A22]' => $isAdmin,
])>
    @if ($isAdmin)
        {{ $slot }}
    @else
        <div class="min-h-screen flex flex-col">
            <header class="app-header backdrop-blur border-b border-[#F7C8B8]/60">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    <a href="{{ route('home') }}" class="text-lg font-bold text-[#7C3A2D]">{{ config('app.name', 'Sicrea') }}</a>
                    <nav class="hidden md:flex items-center gap-6 text-sm text-[#9A5A46]">
                        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                        <a href="{{ route('events.index') }}" class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}">Events</a>
                        <a href="{{ route('portfolio.index') }}" class="nav-link {{ request()->routeIs('portfolio.*') ? 'active' : '' }}">Portfolio</a>
                        <a href="{{ route('partnership.index') }}" class="nav-link {{ request()->routeIs('partnership.*') ? 'active' : '' }}">Partnership</a>
                        <a href="{{ route('about.index') }}" class="nav-link {{ request()->routeIs('about.*') ? 'active' : '' }}">About Us</a>
                    </nav>

                    <div class="flex items-center gap-3 text-sm">
                        @auth
                            <a href="{{ route('profile.show') }}" class="hidden md:inline-flex items-center rounded-full px-4 py-2 font-medium btn-primary">Profil Saya</a>

                            @can('access-admin')
                                <a href="{{ route('admin.dashboard') }}" class="hidden md:inline-flex items-center rounded-full px-4 py-2 font-medium btn-primary">Dashboard Admin</a>
                            @endcan

                            @if (Route::has('logout'))
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="inline-flex items-center rounded-full px-4 py-2 font-semibold btn-primary hover:brightness-90 transition">
                                        Keluar
                                    </button>
                                </form>
                            @endif
                        @else
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="inline-flex items-center rounded-full px-4 py-2 font-semibold btn-primary">
                                    Login
                                </a>
                            @endif

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center rounded-full px-4 py-2 font-semibold btn-primary">
                                    Registrasi
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </header>

            <main class="flex-1">
                @if (session('status'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                        <div class="mb-6 rounded-xl bg-green-100 border border-green-200 text-green-800 px-4 py-3">
                            {{ session('status') }}
                        </div>
                    </div>
                @endif

                @if ($errors->any() && !request()->routeIs('register'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                        <div class="mb-6 rounded-xl bg-red-100 border border-red-200 text-red-800 px-4 py-3">
                            <ul class="list-disc list-inside text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>

            <footer class="app-footer">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid gap-8 md:grid-cols-3">
                    <div class="space-y-3">
                        <h3 class="text-xl font-semibold">{{ config('app.name', 'Sicrea') }}</h3>
                        <p class="text-sm leading-relaxed" style="color: var(--on-primary);">
                            Platform online untuk pendaftaran workshop, event, dan kegiatan kreatif. Wujudkan potensi kreatif Anda bersama kami.
                        </p>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-xl font-semibold">Kontak Kami</h3>
                        <ul class="space-y-2 text-sm" style="color: var(--on-primary);">
                            <li class="flex items-center gap-2">
                                <x-heroicon-o-map-pin class="h-5 w-5" />
                                <span>Jl. Kreasi No. 123, Jakarta</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <x-heroicon-o-phone class="h-5 w-5" />
                                <a href="https://wa.me/6285871497367" target="_blank" class="underline decoration-[#F7C8B8] hover:text-white">
                                    +62 858 7149 7367
                                </a>
                            </li>
                            <li class="flex items-center gap-2">
                                <x-heroicon-o-envelope class="h-5 w-5" />
                                <a href="mailto:kreasihangat@gmail.com" class="underline decoration-[#F7C8B8] hover:text-white">
                                    kreasihangat@gmail.com
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-xl font-semibold">Ikuti Kami</h3>

                        <div class="footer-social">
                            <a href="https://www.instagram.com/kreasihangat" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="Instagram @kreasihangat">
                                <span class="social-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5" aria-hidden="true">
                                        <path d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm10 2c1.654 0 3 1.346 3 3v10c0 1.654-1.346 3-3 3H7c-1.654 0-3-1.346-3-3V7c0-1.654 1.346-3 3-3h10z" />
                                        <path d="M12 8.5a3.5 3.5 0 100 7 3.5 3.5 0 000-7zm0 2a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM17.5 7a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                    </svg>
                                </span>
                                <span class="text-sm" style="color:var(--on-primary);">@kreasihangat</span>
                            </a>

                            <a href="https://www.tiktok.com/@kreasi.hangat" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="TikTok @kreasihangat">
                                <span class="social-icon" aria-hidden="true" >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5" aria-hidden="true">
                                        <path d="M21.5 6.5a5.5 5.5 0 01-5.5-5.5v7.05a3.5 3.5 0 01-3.5-3.5v8.45a5.5 5.5 0 11-2.5-4.5v-1.5a7 7 0 007 7 7 7 0 007-7V6.5h-2.5z" />
                                    </svg>
                                </span>
                                <span class="text-sm" style="color:var(--on-primary);">@kreasihangat</span>
                            </a>
                        </div>
                        <p class="text-sm" style="color: var(--on-primary);">Dapatkan update terbaru tentang workshop dan event kami!</p>
                    </div>
                </div>

                <div class="border-t border-white/10">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm" style="color: var(--on-primary);">
                        &copy; {{ now()->year }} {{ config('app.name', 'Kreasi Hangat') }}. All rights reserved. Made with 💖
                    </div>
                </div>
            </footer>
        </div>
    @endif

    @stack('scripts')
</body>
</html>
