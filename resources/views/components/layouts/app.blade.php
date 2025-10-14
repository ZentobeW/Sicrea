<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Sicrea') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white/90 backdrop-blur border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <a href="{{ route('events.index') }}" class="text-lg font-semibold text-slate-900">{{ config('app.name', 'Sicrea') }}</a>
                <nav class="hidden md:flex items-center gap-6 text-sm text-slate-600">
                    <a href="{{ route('events.index') }}#home" class="hover:text-indigo-600 transition">Home</a>
                    <a href="{{ route('events.index') }}#events" class="hover:text-indigo-600 transition">Events</a>
                    <a href="{{ route('events.index') }}#portfolio" class="hover:text-indigo-600 transition">Portfolio</a>
                    <a href="{{ route('events.index') }}#partnership" class="hover:text-indigo-600 transition">Partnership</a>
                    <a href="{{ route('events.index') }}#about" class="hover:text-indigo-600 transition">About Us</a>
                </nav>
                <div class="flex items-center gap-3 text-sm">
                    @auth
                        <a href="{{ route('registrations.index') }}" class="hidden md:inline-flex items-center rounded-full border border-slate-200 px-4 py-2 font-medium text-slate-700 hover:border-indigo-600 hover:text-indigo-600 transition">Riwayat Saya</a>
                        @can('access-admin')
                            <a href="{{ route('admin.events.index') }}" class="hidden md:inline-flex items-center rounded-full border border-slate-200 px-4 py-2 font-medium text-slate-700 hover:border-indigo-600 hover:text-indigo-600 transition">Dashboard Admin</a>
                        @endcan
                        @if (Route::has('logout'))
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 font-semibold text-white hover:bg-slate-700 transition">Keluar</button>
                            </form>
                        @endif
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="inline-flex items-center rounded-full border border-slate-200 px-4 py-2 font-semibold text-slate-700 hover:border-indigo-600 hover:text-indigo-600 transition">Sign In</a>
                        @endif
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 font-semibold text-white hover:bg-slate-700 transition">Register</a>
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

        <footer class="bg-slate-900 text-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid gap-6 md:grid-cols-3">
                <div class="rounded-2xl bg-slate-800/80 p-6">
                    <h3 class="text-lg font-semibold">Ringkasan Program</h3>
                    <p class="mt-3 text-sm text-slate-300 leading-relaxed">Ikuti rangkaian workshop kreatif, sesi mentoring, dan pameran karya yang dikurasi untuk memperkuat komunitas pelaku industri kreatif.</p>
                </div>
                <div class="rounded-2xl bg-slate-800/80 p-6">
                    <h3 class="text-lg font-semibold">Kontak Project Manager</h3>
                    <p class="mt-3 text-sm text-slate-300 leading-relaxed">Hubungi kami di <a href="mailto:hello@sicrea.id" class="underline decoration-slate-500 hover:text-white">hello@sicrea.id</a> atau WhatsApp <span class="font-semibold">+62 812-3456-7890</span>.</p>
                </div>
                <div class="rounded-2xl bg-slate-800/80 p-6">
                    <h3 class="text-lg font-semibold">Media Sosial &amp; Testimoni</h3>
                    <p class="mt-3 text-sm text-slate-300 leading-relaxed">Ikuti perjalanan kami melalui Instagram <span class="font-semibold">@sicrea.id</span> dan baca cerita sukses alumni yang merasakan dampak nyata.</p>
                </div>
            </div>
            <div class="border-t border-slate-800/60">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm text-slate-400">
                    &copy; {{ now()->year }} {{ config('app.name', 'Sicrea') }}. Semua hak dilindungi.
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
