<x-layouts.app :title="$event->title">
    <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
        <article class="bg-white rounded-xl shadow-sm border border-slate-100 p-8">
            <div class="flex items-center justify-between text-sm text-slate-500 mb-4">
                <span>{{ $event->start_at->translatedFormat('d M Y H:i') }} - {{ $event->end_at->translatedFormat('d M Y H:i') }}</span>
                <span class="font-semibold text-indigo-600">Rp{{ number_format($event->price, 0, ',', '.') }}</span>
            </div>

            <h1 class="text-3xl font-semibold text-slate-900 mb-4">{{ $event->title }}</h1>
            <div class="prose max-w-none text-slate-700">
                {!! nl2br(e($event->description)) !!}
            </div>
        </article>

        <aside class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 space-y-4">
                <h2 class="text-lg font-semibold text-slate-800">Informasi Event</h2>
                <div class="text-sm text-slate-600 space-y-2">
                    <div>
                        <span class="font-medium text-slate-700 block">Lokasi</span>
                        <p>{{ $event->location }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-slate-700 block">Kuota Tersisa</span>
                        <p>{{ $event->available_slots ?? 'Tidak terbatas' }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-slate-700 block">Total Pendaftar</span>
                        <p>{{ $event->registrations_count }} peserta</p>
                    </div>
                </div>
                @auth
                    <a href="{{ route('events.register', $event) }}"
                        class="inline-flex items-center justify-center w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Daftar Sekarang</a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center justify-center w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Masuk untuk mendaftar</a>
                @endauth
            </div>

            @if ($event->portfolios?->count())
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Portofolio</h3>
                    <ul class="space-y-3 text-sm text-slate-600">
                        @foreach ($event->portfolios as $portfolio)
                            <li class="border border-slate-100 rounded-lg px-4 py-3">
                                <p class="font-medium text-slate-700">{{ $portfolio->title }}</p>
                                <p class="mt-1">{{ $portfolio->description }}</p>
                                @if ($portfolio->media_url)
                                    <a href="{{ $portfolio->media_url }}" target="_blank" class="mt-2 inline-block text-indigo-600 text-xs">Lihat dokumentasi</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </aside>
    </div>
</x-layouts.app>
