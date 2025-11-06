@props([
    'title' => config('app.name', 'Sicrea'),
    'isAdmin' => false,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
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
            <header class="bg-gradient-to-r from-[#FFEFE1]/90 via-[#FFE2CE]/90 to-[#FFD5C4]/90 backdrop-blur border-b border-[#F7C8B8]/60">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    <a href="{{ route('home') }}" class="text-lg font-semibold text-[#7C3A2D]">{{ config('app.name', 'Sicrea') }}</a>
                    <nav class="hidden md:flex items-center gap-6 text-sm text-[#9A5A46]">
                        <a href="{{ route('home') }}" class="hover:text-[#7C3A2D] transition">Home</a>
                        <a href="{{ route('events.index') }}" class="hover:text-[#7C3A2D] transition">Events</a>
                        <a href="{{ route('portfolio.index') }}" class="hover:text-[#7C3A2D] transition">Portfolio</a>
                        <a href="{{ route('partnership.index') }}" class="hover:text-[#7C3A2D] transition">Partnership</a>
                        <a href="{{ route('about.index') }}" class="hover:text-[#7C3A2D] transition">About Us</a>
                    </nav>
                    <div class="flex items-center gap-3 text-sm">
                        @auth
                            <a href="{{ route('profile.show') }}" class="hidden md:inline-flex items-center rounded-full border border-[#F7C8B8] px-4 py-2 font-medium text-[#7C3A2D] bg-white/70 hover:bg-white transition">Profil Saya</a>
                            <a href="{{ route('registrations.index') }}" class="hidden md:inline-flex items-center rounded-full border border-[#F7C8B8] px-4 py-2 font-medium text-[#7C3A2D] bg-white/70 hover:bg-white transition">Riwayat Saya</a>
                            @can('access-admin')
                                <a href="{{ route('admin.dashboard') }}" class="hidden md:inline-flex items-center rounded-full border border-[#F7C8B8] px-4 py-2 font-medium text-[#7C3A2D] bg-white/70 hover:bg-white transition">Dashboard Admin</a>
                            @endcan
                            @if (Route::has('logout'))
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="inline-flex items-center rounded-full bg-[#7C3A2D] px-4 py-2 font-semibold text-white hover:bg-[#5c261d] transition">Keluar</button>
                                </form>
                            @endif
                        @else
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="inline-flex items-center rounded-full border border-[#F7C8B8] px-4 py-2 font-semibold text-[#7C3A2D] bg-white/70 hover:bg-white transition">Login</a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center rounded-full bg-[#7C3A2D] px-4 py-2 font-semibold text-white hover:bg-[#5c261d] transition">Registrasi</a>
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

                @if ($errors->any())
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

            <footer class="bg-[#5E1F1A] text-[#FFEDE0]">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid gap-8 md:grid-cols-3">
                    <div class="space-y-3">
                        <h3 class="text-xl font-semibold">{{ config('app.name', 'Sicrea') }}</h3>
                        <p class="text-sm leading-relaxed text-[#F7C8B8]">Platform online untuk pendaftaran workshop, pengelolaan event, dan showcase portofolio kreatif komunitas.</p>
                    </div>
                    <div class="space-y-3">
                        <h3 class="text-xl font-semibold">Kontak Kami</h3>
                        <ul class="space-y-2 text-sm text-[#F7C8B8]">
                            <li>📍 Jl. Kreasi No. 123, Jakarta</li>
                            <li>📞 021-2345-6789</li>
                            <li>✉️ <a href="mailto:info@kreasihangat.com" class="underline decoration-[#F7C8B8] hover:text-white">info@kreasihangat.com</a></li>
                        </ul>
                    </div>
                    <div class="space-y-3">
                        <h3 class="text-xl font-semibold">Ikuti Kami</h3>
                        <p class="text-sm text-[#F7C8B8]">@kreasihangat</p>
                        <div class="flex gap-3 text-[#FFEDE0]">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10">IG</span>
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10">FB</span>
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10">YT</span>
                        </div>
                    </div>
                </div>
                <div class="border-t border-white/10">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm text-[#F7C8B8]">
                        &copy; {{ now()->year }} {{ config('app.name', 'Sicrea') }}. Made with <span class="text-[#FF9AA2]">❤</span>
                    </div>
                </div>
            </footer>
        </div>
    @endif
    @stack('scripts')
</body>
</html>
