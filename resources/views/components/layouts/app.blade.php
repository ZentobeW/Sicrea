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
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <a href="{{ route('events.index') }}" class="text-lg font-semibold text-indigo-600">{{ config('app.name', 'Sicrea') }}</a>
                <nav class="flex items-center gap-3 text-sm">
                    <a href="{{ route('events.index') }}" class="hover:text-indigo-600">Event</a>
                    @auth
                        <a href="{{ route('registrations.index') }}" class="hover:text-indigo-600">Riwayat Saya</a>
                        @can('access-admin')
                            <a href="{{ route('admin.events.index') }}" class="hover:text-indigo-600">Dashboard Admin</a>
                        @endcan
                        @if (Route::has('logout'))
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="text-sm text-slate-600 hover:text-red-500">Keluar</button>
                            </form>
                        @endif
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="text-sm text-indigo-600">Masuk</a>
                        @endif
                    @endauth
                </nav>
            </div>
        </header>

        <main class="flex-1 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if (session('status'))
                    <div class="mb-6 rounded-md bg-green-100 border border-green-300 text-green-800 px-4 py-3">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-md bg-red-100 border border-red-300 text-red-800 px-4 py-3">
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>

        <footer class="bg-white border-t">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm text-slate-500">
                &copy; {{ now()->year }} {{ config('app.name', 'Sicrea') }}. Semua hak dilindungi.
            </div>
        </footer>
    </div>
</body>
</html>
