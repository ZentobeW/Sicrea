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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .5rem 1rem; /* Sedikit diperbesar agar enak dilihat */
            border-radius: 9999px;
            color: #822021; /* Warna text default header */
            font-weight: 500;
            transition: all .3s ease; /* Transisi halus */
            text-decoration: none;
        }

        /* Logic saat Hover: Background berubah, Text berubah, Opacity 80%, Zoom Out (Scale down) */
        .nav-link:hover {
            background-color: #822021;
            color: #FCF5E6;
            opacity: 0.8; 
            transform: scale(0.90); /* Efek Zoom Out */
        }

        /* Logic saat Active (Halaman sedang dibuka) */
        .nav-link.active {
            background-color: #822021;
            color: #FCF5E6;
            opacity: 1;
            transform: scale(1); /* Tetap ukuran normal */
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

        /* --- Back to Top Button Styles --- */
        .back-to-top {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #FFDEF8; /* Default BG */
            border: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); /* Shadow halus */
            cursor: pointer;
            transition-duration: 0.3s;
            overflow: hidden;
            border: #822021 2px solid;
            
            /* Positioning (Agar melayang di pojok kanan bawah) */
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
            
            /* Hidden by default (Javascript akan mengaturnya) */
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
        }

        /* Class tambahan saat tombol muncul */
        .back-to-top.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .svgIcon {
            width: 12px;
            transition-duration: 0.3s;
        }

        .svgIcon path {
            fill: #822021; /* Default Icon Color */
        }

        /* Hover State */
        .back-to-top:hover {
            width: 140px;
            border-radius: 50px;
            transition-duration: 0.3s;
            background-color: #FFDEF8; /* Hover BG */
            align-items: center;
        }

        .back-to-top:hover .svgIcon {
            transition-duration: 0.3s;
            transform: translateY(-200%);
        }
        
        /* Ubah warna icon saat hover agar kontras */
        .back-to-top:hover .svgIcon path {
            fill: #822021; 
        }

        .back-to-top::before {
            position: absolute;
            bottom: -20px;
            content: "Back to Top";
            color: #822021; /* Hover Text Color */
            font-size: 0px;
            font-family: var(--font-body);
        }

        .back-to-top:hover::before {
            font-size: 13px;
            opacity: 1;
            bottom: unset;
            transition-duration: 0.3s;
        }

        /* --- WhatsApp Floating Button Styles --- */
        .whatsapp-btn {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 45px;
            height: 45px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition-duration: 0.3s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
            background-color: #00d757; /* Warna Khas WA */
            text-decoration: none; /* Hilangkan garis bawah link */
            
            /* Positioning (Ditaruh di atas tombol Back to Top) */
            position: fixed;
            bottom: 90px; /* 30px (margin) + 50px (tinggi btn top) + 10px (jarak) */
            right: 32px; /* Disesuaikan agar lurus dengan back-to-top */
            z-index: 998;
        }

        .sign {
            width: 100%;
            transition-duration: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sign svg {
            width: 25px;
        }

        .sign svg path {
            fill: white;
        }

        .text-wa {
            position: absolute;
            right: 0%;
            width: 0%;
            opacity: 0;
            color: white;
            font-size: 1.2em;
            font-weight: 600;
            transition-duration: 0.3s;
        }

        /* Hover Effect */
        .whatsapp-btn:hover {
            width: 150px;
            border-radius: 40px;
            transition-duration: 0.3s;
        }

        .whatsapp-btn:hover .sign {
            width: 30%;
            transition-duration: 0.3s;
            padding-left: 10px;
        }

        .whatsapp-btn:hover .text-wa {
            opacity: 1;
            width: 70%;
            transition-duration: 0.3s;
            padding-right: 10px;
        }

        .whatsapp-btn:active {
            transform: translate(2px, 2px);
        }

        /* --- Animated Social Media Icons Styles --- */
        ul.example-2 {
            list-style: none;
            display: flex;
            justify-content: flex-start; /* Rata kiri sesuai layout footer */
            align-items: center;
            padding: 0;
            margin-top: 10px; /* Jarak dari text username */
        }
        
        .example-2 .icon-content {
            margin: 0 10px 0 0; /* Margin kanan saja agar rapi rata kiri */
            position: relative;
        }
        
        .example-2 .icon-content .tooltip {
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            color: #fff;
            padding: 6px 10px;
            border-radius: 5px;
            opacity: 0;
            visibility: hidden;
            font-size: 14px;
            transition: all 0.3s ease;
            white-space: nowrap;
            pointer-events: none;
        }
        
        .example-2 .icon-content:hover .tooltip {
            opacity: 1;
            visibility: visible;
            top: -45px;
        }
        
        .example-2 .icon-content a {
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #FCF5E6; /* Warna Default: Krem (Tema Website) */
            color: #822021; /* Warna Icon Default: Merah (Tema Website) */
            transition: all 0.3s ease-in-out;
            text-decoration: none;
        }
        
        .example-2 .icon-content a:hover {
            box-shadow: 3px 2px 45px 0px rgba(0, 0, 0, 0.12);
        }
        
        .example-2 .icon-content a svg {
            position: relative;
            z-index: 1;
            width: 24px;
            height: 24px;
        }
        
        .example-2 .icon-content a:hover {
            color: white; /* Warna icon saat hover jadi putih */
        }
        
        .example-2 .icon-content a .filled {
            position: absolute;
            top: auto;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 0;
            background-color: #000;
            transition: all 0.3s ease-in-out;
        }
        
        .example-2 .icon-content a:hover .filled {
            height: 100%;
        }

        /* --- Specific Hover Colors --- */
        
        /* Instagram (Gradient) */
        .example-2 .icon-content a[data-social="instagram"] .filled,
        .example-2 .icon-content a[data-social="instagram"] ~ .tooltip {
            background: linear-gradient(
                45deg,
                #405de6,
                #5b51db,
                #b33ab4,
                #c135b4,
                #e1306c,
                #fd1f1f
            );
        }

        /* TikTok (Black) */
        .example-2 .icon-content a[data-social="tiktok"] .filled,
        .example-2 .icon-content a[data-social="tiktok"] ~ .tooltip {
            background-color: #000000; 
        }

        #toast-container {
            z-index: 9999; /* Pastikan di atas segalanya */
        }

    </style>
</head>
<body @class([
    'bg-slate-50 text-slate-900 min-h-screen' => ! $isAdmin,
    'min-h-screen bg-[#FFEDE3] text-[#4B2A22]' => $isAdmin,
])>
    {{-- [START] NOTIFICATION TOAST CONTAINER --}}
    <div id="toast-container" class="fixed top-24 right-5 z-[9999] w-full max-w-sm space-y-4 pointer-events-none px-4 sm:px-0">
        
        {{-- 1. SUCCESS MESSAGE --}}
        @if (session('status') || session('success'))
            <div role="alert" class="toast-message pointer-events-auto bg-green-100 border-l-4 border-green-500 text-green-900 p-4 rounded-lg flex items-center shadow-lg transform transition-all duration-500 ease-out opacity-0 translate-x-full">
                <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" class="h-6 w-6 flex-shrink-0 mr-3 text-green-600" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 16h-1v-4h1m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                </svg>
                <div>
                    <p class="text-sm font-bold">Berhasil!</p>
                    <p class="text-xs font-semibold">{{ session('status') ?? session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- 2. INFO MESSAGE --}}
        @if (session('info'))
            <div role="alert" class="toast-message pointer-events-auto bg-blue-100 border-l-4 border-blue-500 text-blue-900 p-4 rounded-lg flex items-center shadow-lg transform transition-all duration-500 ease-out opacity-0 translate-x-full">
                <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" class="h-6 w-6 flex-shrink-0 mr-3 text-blue-600" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 16h-1v-4h1m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                </svg>
                <div>
                    <p class="text-sm font-bold">Informasi</p>
                    <p class="text-xs font-semibold">{{ session('info') }}</p>
                </div>
            </div>
        @endif

        {{-- 3. WARNING MESSAGE --}}
        @if (session('warning'))
            <div role="alert" class="toast-message pointer-events-auto bg-yellow-100 border-l-4 border-yellow-500 text-yellow-900 p-4 rounded-lg flex items-center shadow-lg transform transition-all duration-500 ease-out opacity-0 translate-x-full">
                <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" class="h-6 w-6 flex-shrink-0 mr-3 text-yellow-600" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 16h-1v-4h1m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                </svg>
                <div>
                    <p class="text-sm font-bold">Perhatian</p>
                    <p class="text-xs font-semibold">{{ session('warning') }}</p>
                </div>
            </div>
        @endif

        {{-- 4. ERROR MESSAGE --}}
        @if ($errors->any() || session('error'))
            <div role="alert" class="toast-message pointer-events-auto bg-red-100 border-l-4 border-red-500 text-red-900 p-4 rounded-lg flex items-center shadow-lg transform transition-all duration-500 ease-out opacity-0 translate-x-full">
                <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" class="h-6 w-6 flex-shrink-0 mr-3 text-red-600" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 16h-1v-4h1m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                </svg>
                <div>
                    <p class="text-sm font-bold">Terjadi Kesalahan</p>
                    <p class="text-xs font-semibold">
                        {{ session('error') ?? 'Mohon periksa kembali input Anda.' }}
                    </p>
                </div>
            </div>
        @endif
    </div>
    {{-- [END] NOTIFICATION TOAST CONTAINER --}}


    @if ($isAdmin)
        {{ $slot }}
    @else
        <div class="min-h-screen flex flex-col">
            <header class="bg-[#FCF5E6] border-b border-[#F7C8B8]/60 sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    
                    <a href="{{ route('home') }}" class="text-lg font-semibold text-[#822021]">
                        {{ config('app.name', 'Sicrea') }}
                    </a>

                    <nav class="hidden md:flex items-center gap-4 text-sm">
                        <a href="{{ route('home') }}" 
                           class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                           Home
                        </a>
                        
                        <a href="{{ route('events.index') }}" 
                           class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
                           Events
                        </a>

                        <a href="{{ route('portfolio.index') }}" 
                           class="nav-link {{ request()->routeIs('portfolio.*') ? 'active' : '' }}">
                           Portfolio
                        </a>

                        <a href="{{ route('partnership.index') }}" 
                           class="nav-link {{ request()->routeIs('partnership.*') ? 'active' : '' }}">
                           Partnership
                        </a>

                        <a href="{{ route('about.index') }}" 
                           class="nav-link {{ request()->routeIs('about.*') ? 'active' : '' }}">
                           About Us
                        </a>
                    </nav>

                    <div class="flex items-center gap-3 text-sm">
                        @auth
                            <a href="{{ route('profile.show') }}" class="hidden md:inline-flex items-center rounded-full px-4 py-2 font-medium btn-primary transition transform hover:scale-95">
                                Profil Saya
                            </a>

                            @can('access-admin')
                                <a href="{{ route('admin.dashboard') }}" class="hidden md:inline-flex items-center rounded-full px-4 py-2 font-medium btn-primary transition transform hover:scale-95">
                                    Admin
                                </a>
                            @endcan

                            @if (Route::has('logout'))
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="inline-flex items-center rounded-full px-4 py-2 font-semibold btn-primary hover:opacity-80 transition transform hover:scale-95">
                                        Keluar
                                    </button>
                                </form>
                            @endif
                        @else
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="inline-flex items-center rounded-full border border-[#822021] px-4 py-2 font-semibold text-[#822021] bg-transparent hover:bg-[#822021] hover:text-[#FCF5E6] transition duration-300">
                                    Login
                                </a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center rounded-full bg-[#822021] px-4 py-2 font-semibold text-[#FCF5E6] hover:opacity-90 transition">
                                    Registrasi
                                </a>
                            @endif
                        @endauth
                        
                        <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg text-[#822021] hover:bg-[#822021]/10 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div id="mobile-menu" class="md:hidden hidden bg-[#FCF5E6] border-t border-[#F7C8B8]/60 shadow-lg">
                    <div class="px-4 py-3 space-y-2">
                        <a href="{{ route('home') }}" 
                        class="block px-4 py-2 rounded-lg transition duration-300 text-[#822021] font-bold {{ request()->routeIs('home') ? 'bg-[#822021] text-[#FCF5E6]' : 'hover:bg-[#822021]/10'}}">
                        Home
                        </a>
                        </div>
                </div>
            </header>

            <main class="flex-1">
                <!-- @if (session('status'))
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
                @endif -->

                {{ $slot }}
            </main>

            <footer class="bg-[#822021] text-[#FCF5E6] border-t border-[#FCF5E6]/20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid gap-8 md:grid-cols-3">
                    
                    <div class="space-y-3">
                        <h3 class="text-xl font-semibold font-['Poppins']">{{ config('app.name', 'Sicrea') }}</h3>
                        <p class="text-sm leading-relaxed opacity-90">
                            Platform online untuk pendaftaran workshop, event, dan kegiatan kreatif. Wujudkan potensi kreatif Anda bersama kami.
                        </p>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-xl font-semibold font-['Poppins']">Kontak Kami</h3>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-center gap-3">
                                <x-heroicon-o-phone class="h-5 w-5 flex-shrink-0" />
                                <a href="https://wa.me/6285871497367" target="_blank" class="hover:underline hover:text-white transition decoration-[#FCF5E6]">
                                    +62 858-7149-7367
                                </a>
                            </li>

                            <li class="flex items-center gap-3">
                                <x-heroicon-o-envelope class="h-5 w-5 flex-shrink-0" />
                                <a href="mailto:kreasihangat@gmail.com" class="hover:underline hover:text-white transition decoration-[#FCF5E6]">
                                    kreasihangat@gmail.com
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-xl font-semibold font-['Poppins']">Ikuti Kami</h3>
                            <p class="text-sm opacity-90 mb-2">@kreasihangat</p>
                            
                            <ul class="example-2">
                                <li class="icon-content">
                                    <a data-social="instagram" aria-label="Instagram" href="https://instagram.com/kreasihangat" target="_blank">
                                        <div class="filled"></div>
                                        <svg xml:space="preserve" viewBox="0 0 16 16" class="bi bi-instagram" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"></path>
                                        </svg>
                                    </a>
                                    <div class="tooltip">Instagram</div>
                                </li>

                                <li class="icon-content">
                                    <a data-social="tiktok" aria-label="TikTok" href="https://tiktok.com/@kreasi.hangat" target="_blank">
                                        <div class="filled"></div>
                                        <svg xml:space="preserve" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"></path>
                                        </svg>
                                    </a>
                                    <div class="tooltip">TikTok</div>
                                </li>
                            </ul>
                        </div>

                        <p class="text-xs font-light tracking-wide opacity-80 pt-2 border-t border-[#FCF5E6]/20">
                            Dapatkan update terbaru tentang workshop dan event kami!
                        </p>
                    </div>
                </div>

                <div class="border-t border-[#FCF5E6]/10">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm opacity-80">
                        &copy; {{ now()->year }} {{ config('app.name', 'Kreasi Hangat') }} Kreasi Hangat. All rights reserved. Made with 💖
                    </div>
                </div>
            </footer>
            <a href="https://wa.me/6285871497367" target="_blank" class="whatsapp-btn">
                <div class="sign">
                    <svg class="socialSvg whatsappSvg" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"></path>
                    </svg>
                </div>
                <div class="text-wa">Whatsapp</div>
            </a>
            <button class="back-to-top" onclick="scrollToTop()">
                <svg class="svgIcon" viewBox="0 0 384 512">
                    <path d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z"></path>
                </svg>
            </button>
        </div>
    @endif



    @stack('scripts')
    
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
        // --- Back to Top Logic ---
        const backToTopButton = document.querySelector('.back-to-top');

        window.addEventListener('scroll', () => {
            // Jika scroll lebih dari 300px, munculkan tombol
            if (window.scrollY > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth' // Efek scroll halus
            });
        }

        // [START] SMOOTH TOAST NOTIFICATION SCRIPT
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast-message');
            
            if (toasts.length > 0) {
                // 1. ANIMASI MASUK (Slide In)
                // Gunakan sedikit delay agar browser merender state awal (hidden) dulu
                setTimeout(() => {
                    toasts.forEach(toast => {
                        // Hapus class yang menyembunyikan elemen
                        toast.classList.remove('opacity-0', 'translate-x-full');
                    });
                }, 100);

                // 2. ANIMASI KELUAR (Slide Out + Collapse)
                // Tunggu 5 detik (5000ms) sebelum mulai menghilang
                setTimeout(() => {
                    toasts.forEach(toast => {
                        // a. Slide ke kanan & Fade Out
                        toast.classList.add('opacity-0', 'translate-x-full');
                        
                        // b. Collapse Height (Agar elemen bawahnya naik smooth, tidak lompat)
                        // Kita set max-height, margin, dan padding menjadi 0
                        toast.style.maxHeight = toast.scrollHeight + 'px'; // Set tinggi asli dulu
                        toast.style.overflow = 'hidden'; // Hindari konten tumpah saat mengecil
                        
                        // Trigger reflow (memaksa browser membaca tinggi asli sebelum di-nol-kan)
                        void toast.offsetWidth; 

                        // Mulai menyusutkan elemen
                        toast.style.maxHeight = '0';
                        toast.style.marginTop = '0';
                        toast.style.marginBottom = '0';
                        toast.style.paddingTop = '0';
                        toast.style.paddingBottom = '0';
                        toast.style.border = 'none';
                        
                        // c. Hapus dari DOM setelah animasi CSS selesai (500ms sesuai duration-500)
                        setTimeout(() => {
                            toast.remove();
                        }, 500);
                    });
                }, 5000); // Durasi tampil notifikasi (5 Detik)
            }
        });
        // [END] SMOOTH TOAST NOTIFICATION SCRIPT
    </script>
</body>
</html>
