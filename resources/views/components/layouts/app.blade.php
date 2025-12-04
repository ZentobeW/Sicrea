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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cousine:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body @class([
    'bg-slate-50 text-slate-900 min-h-screen' => ! $isAdmin,
    'min-h-screen bg-[#FFEDE3] text-[#4B2A22]' => $isAdmin,
])>
    @if ($isAdmin)
        {{ $slot }}
    @else
        <div class="min-h-screen flex flex-col">
            
            <header class="bg-gradient-to-r from-[#FCF5E6]/90 to-[#FFBE8E]/50 backdrop-blur border-b border-[#F7C8B8]/60 sticky top-0 z-50">

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between relative">  

                    <a href="{{ route('home') }}" class="h-full py-2 flex items-center">
                        <img src="{{ asset('images/Logo KH.svg') }}" 
                            alt="Logo Sicrea" 
                            class="h-20 w-auto object-contain hover:scale-105 transition-transform duration-300">
                    </a>

                    <nav class="hidden md:flex items-center gap-6 text-sm font-bold font-['Courier_New']">
                        <a href="{{ route('home') }}" 
                        class="px-4 py-2 rounded-full transition duration-300 text-[#822021] {{ request()->routeIs('home') ? 'bg-[#822021] text-white' : 'hover:bg-[#822021]/15'}}">
                        Home
                        </a>

                        <a href="{{ route('events.index') }}" 
                        class="px-4 py-2 rounded-full transition duration-300 text-[#822021] {{ request()->routeIs('events.*') ? 'bg-[#822021] text-white' : 'hover:bg-[#822021]/15'}}">
                        Events
                        </a>

                        <a href="{{ route('portfolio.index') }}" 
                        class="px-4 py-2 rounded-full transition duration-300 text-[#822021] {{ request()->routeIs('portfolio.index') ? 'bg-[#822021] text-white' : 'hover:bg-[#822021]/15'}}">
                        Portfolio
                        </a>

                        <a href="{{ route('partnership.index') }}" 
                        class="px-4 py-2 rounded-full transition duration-300 text-[#822021] {{ request()->routeIs('partnership.index') ? 'bg-[#822021] text-white' : 'hover:bg-[#822021]/15'}}">
                        Partnership
                        </a>

                        <a href="{{ route('about.index') }}" 
                        class="px-4 py-2 rounded-full transition duration-300 text-[#822021] {{ request()->routeIs('about.index') ? 'bg-[#822021] text-white' : 'hover:bg-[#822021]/15'}}">
                        About Us
                        </a>
                    </nav>

                    <div class="flex items-center gap-3 text-sm">
                        @auth
                            <a href="{{ route('profile.show') }}" class="hidden md:inline-flex items-center rounded-full border border-[#FFBE8E] px-4 py-2 font-bold font-['Courier_New'] text-[#822021] bg-[#FAF8F1] hover:bg-white transition">Profile</a>
                            @can('access-admin')
                                <a href="{{ route('admin.dashboard') }}" class="hidden md:inline-flex items-center rounded-full border border-[#FFBE8E] px-4 py-2 font-bold font-['Courier_New'] text-[#822021] bg-[#FAF8F1] hover:bg-white transition">Dashboard</a>
                            @endcan
                            <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                                @csrf
                                <button class="inline-flex items-center rounded-full bg-[#822021] px-4 py-2 font-bold font-['Courier_New'] text-white hover:bg-[#5c261d] transition">Logout</button>
                            </form>
                        @else
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="hidden md:inline-flex items-center rounded-full border border-[#FFBE8E] px-4 py-2 font-bold font-['Courier_New'] text-[#822021] bg-[#FAF8F1] hover:bg-white transition">Login</a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="hidden md:inline-flex items-center rounded-full bg-[#822021] px-4 py-2 font-bold font-['Courier_New'] text-white hover:bg-[#5c261d] transition">Register</a>
                            @endif
                        @endauth
                        
                        <!-- Mobile menu button -->
                        <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg text-[#822021] hover:bg-[#822021]/10 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div id="mobile-menu" class="md:hidden hidden bg-gradient-to-r from-[#FCF5E6] to-[#FFBE8E]/70 border-t border-[#F7C8B8]/60">
                    <div class="px-4 py-3 space-y-2">
                        <a href="{{ route('home') }}" 
                        class="block px-4 py-2 rounded-lg transition duration-300 text-[#822021] font-bold font-['Courier_New'] {{ request()->routeIs('home') ? 'bg-[#822021] text-white' : 'hover:bg-[#822021]/15'}}">
                        Home
                        </a>

                        <a href="{{ route('events.index') }}" 
                        class="block px-4 py-2 rounded-lg transition duration-300 text-[#822021] font-bold font-['Courier_New'] {{ request()->routeIs('events.*') ? 'bg-[#822021] text-white' : 'hover:bg-[#822021]/15'}}">
                        Events
                        </a>

                        <a href="{{ route('portfolio.index') }}" 
                        class="block px-4 py-2 rounded-lg transition duration-300 text-[#822021] font-bold font-['Courier_New'] {{ request()->routeIs('portfolio.index') ? 'bg-[#822021] text-white' : 'hover:bg-[#822021]/15'}}">
                        Portfolio
                        </a>

                        <a href="{{ route('partnership.index') }}" 
                        class="block px-4 py-2 rounded-lg transition duration-300 text-[#822021] font-bold font-['Courier_New'] {{ request()->routeIs('partnership.index') ? 'bg-[#822021] text-white' : 'hover:bg-[#822021]/15'}}">
                        Partnership
                        </a>

                        <a href="{{ route('about.index') }}" 
                        class="block px-4 py-2 rounded-lg transition duration-300 text-[#822021] font-bold font-['Courier_New'] {{ request()->routeIs('about.index') ? 'bg-[#822021] text-white' : 'hover:bg-[#822021]/15'}}">
                        About Us
                        </a>

                        @auth
                            <div class="border-t border-[#F7C8B8]/60 pt-2 mt-2 space-y-3">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 rounded-lg border border-[#FFBE8E] text-[#822021] bg-[#FAF8F1] font-bold font-['Courier_New'] hover:bg-white transition text-center">Profile</a>
                                @can('access-admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg border border-[#FFBE8E] text-[#822021] bg-[#FAF8F1] font-bold font-['Courier_New'] hover:bg-white transition text-center">Dashboard</a>
                                @endcan
                                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                    @csrf
                                    <button class="w-full text-center px-4 py-2 rounded-lg bg-[#822021] text-white font-bold font-['Courier_New'] hover:bg-[#5c261d] transition">Logout</button>
                                </form>
                            </div>
                        @else
                            <div class="border-t border-[#F7C8B8]/60 pt-2 mt-2 space-y-2">
                                @if (Route::has('login'))
                                    <a href="{{ route('login') }}" class="block px-4 py-2 rounded-lg border border-[#FFBE8E] text-[#822021] bg-[#FAF8F1] font-bold font-['Courier_New'] hover:bg-white transition text-center">Login</a>
                                @endif
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="block px-4 py-2 rounded-lg bg-[#822021] text-white font-bold font-['Courier_New'] hover:bg-[#5c261d] transition text-center">Register</a>
                                @endif
                            </div>
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

            <footer class="bg-[#822021] text-[#FAF8F1]">

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24 items-start">
                        
                        <div class="flex flex-col">
                            <img src="{{ asset('images/Logo KH.svg') }}" 
                                alt="Logo" 
                                class="h-24 w-auto object-contain self-start brightness-0 invert"> 
                            <p class="text-sm leading-relaxed text-[#FAF8F1] max-w-sm font-['Cousine']">
                                Menemanimu meromantisasikan proses belajar melalui hal-hal sederhana yang bermakna ✨
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-12 items-start pt-1">
                            
                            <div class="space-y-3">
                                <h3 class="text-lg text-[#FAF8F1] font-bold font-['Courier_New'] tracking-wider">Contact Us</h3>
                                
                                <ul class="space-y-2 text-sm text-[#FAF8F1] font-['Cousine']">                                   
                                    <li class="flex items-center gap-3">
                                        <svg class="h-4 w-4 flex-shrink-0 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.9 464-464 0-11.2-7.7-20.9-18.6-23.4z"/>
                                        </svg>
                                        <a href="https://wa.me/6285871497367" target="_blank" class="hover:text-white transition">+62 858-7149-7367</a>
                                    </li>
                                    
                                    <li class="flex items-center gap-3">
                                        <svg class="h-4 w-4 flex-shrink-0 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"/>
                                        </svg>
                                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=kreasihangat@gmail.com" target="_blank" class="decoration-[#F7C8B8] hover:text-white transition">
                                            kreasihangat@gmail.com
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="space-y-3">
                                <h3 class="text-lg text-[#FAF8F1] font-bold font-['Courier_New'] tracking-wider">Follow Us</h3>
                                
                                <div class="flex gap-3 text-white">

                                    <a href="https://instagram.com/kreasihangat" target="_blank" class="h-9 w-9 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition border border-white/10 group">
                                        <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                        </svg>
                                    </a>

                                    <a href="https://www.tiktok.com/@kreasi.hangat" target="_blank" class="h-9 w-9 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition border border-white/10 group">
                                        <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                        </svg>
                                    </a>

                                    <a href="#" class="h-9 w-9 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition border border-white/10 group">
                                        <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </a>
                                    
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="border-t border-white/10 mt-4 pt-6 w-full">
                        <div class="text-center text-sm text-[#FAF8F1] font-bold font-['Courier_New']">
                            &copy; 2025 Kreasi Hangat. All rights reserved. Made with 🩷
                        </div>
                    </div>

                </div>
            </footer>
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
    </script>
</body>
</html>
