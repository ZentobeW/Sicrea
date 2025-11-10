@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="'Semua Event & Workshop'">
    <section class="relative overflow-hidden bg-gradient-to-b from-[#FDE8D5] via-[#FFF4EC] to-white">
        <div class="absolute -top-16 -right-10 h-60 w-60 rounded-full bg-white/40 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-10 h-72 w-72 rounded-full bg-[#F7D6E0]/40 blur-3xl"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid gap-12 lg:grid-cols-[1.1fr,0.9fr] items-center">
                <div class="space-y-6">
                    <span class="inline-flex items-center rounded-full bg-white/70 px-4 py-1 text-[11px] font-semibold uppercase tracking-[0.45em] text-slate-500">Events</span>
                    <h1 class="text-4xl md:text-5xl font-semibold text-[#5A3D31] leading-tight">
                        Semua Event &amp; Workshop
                    </h1>
                    <p class="text-base md:text-lg text-slate-600 leading-relaxed max-w-xl">
                        Temukan workshop dengan sentuhan hangat khas Kreasi Hangat. Pilih jadwal yang sesuai, kenali fasilitator, dan daftarkan dirimu untuk pengalaman belajar yang penuh inspirasi.
                    </p>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('home') }}" class="inline-flex items-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-[#B05A62] shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            Kembali ke Beranda
                        </a>
                        <a href="{{ route('partnership.index') }}" class="inline-flex items-center rounded-full bg-[#B05A62] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#9A4750]">
                            Ajukan Kolaborasi
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/3] rounded-[36px] bg-gradient-to-br from-white/70 via-[#FCE3E5] to-[#FAD5B7] shadow-inner flex items-center justify-center">
                        <div class="text-center space-y-2">
                            <p class="text-xs font-semibold uppercase tracking-[0.5em] text-[#B05A62]/70">Kreasi Hangat</p>
                            <p class="text-2xl font-semibold text-[#5A3D31]">Agenda Kreatif</p>
                        </div>
                    </div>
                    <div class="absolute -bottom-8 -right-6 hidden lg:block h-36 w-36 rounded-3xl border-4 border-white bg-[#FCE3E5]/80"></div>
                </div>
            </div>

            <form method="GET" action="{{ route('events.index') }}" class="mt-14">
                <label for="q" class="sr-only">Cari event</label>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:rounded-full sm:bg-white sm:shadow-lg sm:p-2">
                    <div class="flex-1">
                        <input id="q" type="search" name="q" value="{{ request('q') }}" placeholder="Cari event, tutor, atau venue yang kamu minati"
                            class="w-full rounded-full border border-transparent bg-white px-6 py-3 text-sm text-slate-600 shadow-sm focus:border-[#B05A62] focus:ring-2 focus:ring-[#F7D6E0]" />
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-[#B05A62] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#9A4750]">
                        Cari Event
                    </button>
                </div>
            </form>
        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="space-y-2">
                    <h2 class="text-3xl font-semibold text-[#5A3D31]">Jadwal Terbaru</h2>
                    <p class="text-slate-600 max-w-2xl">Gunakan filter dan pencarian untuk menemukan workshop yang paling sesuai dengan kebutuhanmu.</p>
                    @if ($events->total() > 0)
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Menampilkan {{ $events->firstItem() }}-{{ $events->lastItem() }} dari {{ $events->total() }} event.</p>
                    @else
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Belum ada event yang siap diikuti.</p>
                    @endif
                </div>
            </div>

            <div class="mt-12 grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($events as $event)
                    @php
                        $highlight = Str::of($event->title)->before(' ')->title();
                    @endphp
                    <article class="group relative rounded-[32px] border border-[#F4D5C7] bg-white shadow-[0_30px_60px_-40px_rgba(176,90,98,0.45)] transition hover:-translate-y-1">
                        <div class="rounded-t-[32px] bg-gradient-to-br from-[#FCE3E5] via-[#FAD5B7] to-white px-6 py-5">
                            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-[0.35em] text-[#B05A62]/70">
                                <span>{{ $event->start_at->translatedFormat('d M Y') }}</span>
                                <span>{{ $highlight }}</span>
                            </div>
                            <h3 class="mt-3 text-2xl font-semibold text-[#5A3D31] group-hover:text-[#B05A62] transition">{{ $event->title }}</h3>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">{{ Str::limit(strip_tags($event->description), 130) }}</p>
                        </div>
                        <div class="px-6 py-6 space-y-6">
                            <div class="flex items-start gap-3 text-sm text-slate-500">
                                <svg class="h-4 w-4 text-[#B05A62]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11.25a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 0c4.556 0 8.25 3.694 8.25 8.25 0 0-3.694 2.25-8.25 2.25s-8.25-2.25-8.25-2.25c0-4.556 3.694-8.25 8.25-8.25Z" />
                                </svg>
                                <div>
                                    <p class="font-semibold text-[#5A3D31]">{{ $event->venue_name }}</p>
                                    <p class="text-xs text-slate-500">{{ $event->venue_address }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-slate-500">
                                <x-heroicon-o-user-group class="h-4 w-4 text-[#B05A62]" />
                                <span>Pemateri: {{ $event->tutor_name }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-[#FFF4EC] px-4 py-3">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.3em] text-[#B05A62]/70">Harga</p>
                                    <p class="text-lg font-semibold text-[#5A3D31]">@if ($event->price > 0) Rp{{ number_format($event->price, 0, ',', '.') }} @else Gratis @endif</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs uppercase tracking-[0.3em] text-[#B05A62]/70">Kuota</p>
                                    <p class="text-sm font-semibold text-[#5A3D31]">{{ $event->remainingSlots() ?? 'Tidak terbatas' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 rounded-full bg-[#B05A62] px-5 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-white transition hover:bg-[#9A4750]">
                                    Lihat Detail
                                </a>
                                <span class="text-xs font-medium uppercase tracking-[0.35em] text-slate-400">{{ $event->start_at->translatedFormat('H.i') }} WIB</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-[32px] border border-dashed border-[#F4D5C7] bg-[#FFF4EC] py-20 text-center">
                        <p class="text-slate-500">Belum ada event yang tersedia saat ini. Nantikan pengumuman berikutnya!</p>
                    </div>
                @endforelse
            </div>

            @if ($events->hasPages())
                <div class="mt-12">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
