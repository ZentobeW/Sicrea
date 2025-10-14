@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="'Event Sicrea'">
    <section class="bg-white border-b border-slate-200/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid gap-10 lg:grid-cols-[1.1fr,0.9fr] items-center">
                <div class="space-y-6">
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-slate-600">Events</span>
                    <h1 class="text-4xl md:text-5xl font-semibold text-slate-900 leading-tight">Agenda Workshop &amp; Aktivasi Kreatif</h1>
                    <p class="text-base md:text-lg text-slate-600 leading-relaxed">Temukan rangkaian kegiatan yang dikurasi untuk komunitas dan tim kreatifmu. Setiap program dirancang untuk menghadirkan pengalaman belajar yang aplikatif.</p>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('home') }}" class="inline-flex items-center rounded-full border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 hover:border-indigo-600 hover:text-indigo-600 transition">Kembali ke Beranda</a>
                        <a href="{{ route('partnership.index') }}" class="inline-flex items-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-700 transition">Ajukan Kolaborasi</a>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/3] rounded-3xl bg-slate-200 flex items-center justify-center text-xs uppercase tracking-[0.4em] text-slate-400">Event Visual</div>
                    <div class="absolute -bottom-6 -right-6 hidden lg:block w-40 h-40 rounded-3xl border-4 border-white bg-slate-100"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="space-y-3">
                    <h2 class="text-3xl font-semibold text-slate-900">Jadwal Terbaru</h2>
                    <p class="text-slate-600 max-w-2xl">Gunakan pencarian untuk menemukan workshop yang paling relevan dengan kebutuhan tim dan komunitasmu.</p>
                    @if ($events->total() > 0)
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Menampilkan {{ $events->firstItem() }}-{{ $events->lastItem() }} dari {{ $events->total() }} event.</p>
                    @else
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Belum ada event yang siap didaftarkan.</p>
                    @endif
                </div>
                <form method="GET" action="{{ route('events.index') }}" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <label for="q" class="sr-only">Cari event</label>
                    <input id="q" type="search" name="q" value="{{ request('q') }}" placeholder="Cari event atau lokasi"
                        class="flex-1 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm text-slate-600 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" />
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-2 text-sm font-semibold text-white hover:bg-slate-700 transition">
                        Cari
                    </button>
                </form>
            </div>

            <div class="mt-12 grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($events as $event)
                    <article class="group rounded-3xl bg-white border border-slate-100/80 shadow-sm hover:shadow-lg transition overflow-hidden">
                        <div class="p-6 space-y-6">
                            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">
                                <span>{{ $event->start_at->translatedFormat('d M Y • H:i') }}</span>
                                <span class="text-slate-900">Rp{{ number_format($event->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="space-y-3">
                                <h3 class="text-xl font-semibold text-slate-900 group-hover:text-indigo-600 transition">{{ $event->title }}</h3>
                                <p class="text-sm text-slate-600 leading-relaxed">{{ Str::limit(strip_tags($event->description), 140) }}</p>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <svg class="h-4 w-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c.828 0 1.5-.672 1.5-1.5S12.828 8 12 8s-1.5.672-1.5 1.5S11.172 11 12 11z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 10.5c0 7.5-8.25 11.25-8.25 11.25S3.75 18 3.75 10.5a8.25 8.25 0 1116.5 0z" />
                                </svg>
                                <span>{{ $event->location }}</span>
                            </div>
                        </div>
                        <div class="px-6 pb-6">
                            <div class="flex items-center justify-between rounded-2xl bg-slate-100/80 px-4 py-3 text-xs font-medium text-slate-500">
                                <span>Kuota tersisa: {{ $event->available_slots ?? 'Tidak terbatas' }}</span>
                                <a href="{{ route('events.show', $event->slug) }}" class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.2em] text-white hover:bg-slate-700 transition">Detail</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-20 rounded-3xl border border-dashed border-slate-300 bg-white">
                        <p class="text-slate-500">Belum ada event yang tersedia saat ini. Nantikan pengumuman berikutnya!</p>
                    </div>
                @endforelse
            </div>

            @if ($events->hasPages())
                <div class="mt-10">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
