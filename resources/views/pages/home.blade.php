@php
    use Illuminate\Support\Str;

    $formatStat = static function (int $value): string {
        if ($value >= 1000) {
            return rtrim(number_format($value / 1000, 1), '.0') . 'K+';
        }

        return $value . ($value > 0 ? '+' : '');
    };
@endphp

<x-layouts.app :title="'Kreasi Hangat'">
    <section class="relative overflow-hidden bg-gradient-to-br from-[#FFE3D3] via-[#FFF1EA] to-white">
        <div class="absolute -left-20 -top-24 h-60 w-60 rounded-full bg-[#FFB6A0]/60 blur-3xl"></div>
        <div class="absolute -right-24 bottom-0 h-72 w-72 rounded-full bg-[#FFD3B6]/50 blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20">
            <div class="grid gap-10 lg:grid-cols-[1.1fr,0.9fr] items-center">
                <div class="space-y-8">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/70 px-4 py-2 text-sm font-semibold text-[#C65B74] shadow-sm shadow-[#C65B74]/10">
                        <span class="h-2 w-2 rounded-full bg-[#FF8A64]"></span>
                        Kreasi Hangat
                    </span>
                    <div class="space-y-4">
                        <h1 class="text-4xl md:text-5xl font-semibold leading-tight text-[#2C1E1E]">
                            Wujudkan Kreativitas Anda Bersama Kami
                        </h1>
                        <p class="text-base md:text-lg leading-relaxed text-[#5F4C4C] max-w-xl">
                            Temukan workshop, kolaborasi, dan pengalaman belajar yang hangat dalam satu platform. Kami hadir membantu komunitas kreatif berkembang dengan mentor terbaik.
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-full bg-[#FF8A64] px-7 py-3 text-sm font-semibold text-white shadow-md shadow-[#FF8A64]/30 transition hover:bg-[#F9744B]">
                            Lihat Katalog Event
                        </a>
                        <a href="{{ route('portfolio.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#C65B74] hover:text-[#A2475D]">
                            <span>Lihat Portofolio</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <dl class="grid gap-6 sm:grid-cols-3">
                        <div class="rounded-3xl bg-white/80 p-6 shadow-sm shadow-[#FFB6A0]/20 backdrop-blur">
                            <dt class="text-sm font-medium text-[#A04E62]">Event Aktif</dt>
                            <dd class="mt-2 text-3xl font-semibold text-[#2C1E1E]">{{ $formatStat($stats['published_events']) }}</dd>
                        </div>
                        <div class="rounded-3xl bg-white/80 p-6 shadow-sm shadow-[#FFB6A0]/20 backdrop-blur">
                            <dt class="text-sm font-medium text-[#A04E62]">Peserta Terdaftar</dt>
                            <dd class="mt-2 text-3xl font-semibold text-[#2C1E1E]">{{ $formatStat($stats['confirmed_participants']) }}</dd>
                        </div>
                        <div class="rounded-3xl bg-white/80 p-6 shadow-sm shadow-[#FFB6A0]/20 backdrop-blur">
                            <dt class="text-sm font-medium text-[#A04E62]">Kolaborator</dt>
                            <dd class="mt-2 text-3xl font-semibold text-[#2C1E1E]">{{ $formatStat($stats['partners'] ?? 15) }}</dd>
                        </div>
                    </dl>
                </div>
                <div class="relative">
                    <div class="relative rounded-[48px] border border-white/60 bg-white/80 p-6 shadow-xl shadow-[#E8BDB0]/40 backdrop-blur">
                        <div class="aspect-[4/5] overflow-hidden rounded-[36px] bg-[#FCD9CA] flex items-center justify-center text-sm uppercase tracking-[0.35em] text-[#C65B74]/70">
                            Foto Workshop
                        </div>
                        <div class="absolute -bottom-8 left-8 rounded-3xl bg-white px-5 py-4 shadow-lg shadow-[#FFB6A0]/40">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]/70">Highlight</p>
                            <p class="mt-1 text-sm font-medium text-[#2C1E1E]">Lebih dari 150 sesi kreatif setiap tahun.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#FFF7F2]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-10">
            <div class="text-center space-y-3">
                <span class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74] shadow-sm shadow-[#FFB6A0]/30">Event Mendatang</span>
                <h2 class="text-3xl font-semibold text-[#2C1E1E]">Temukan Pengalaman Kreatif Favoritmu</h2>
                <p class="text-base text-[#5F4C4C] max-w-2xl mx-auto">Pilih workshop yang sesuai minatmu dan daftar langsung secara online. Kami menghadirkan mentor terpercaya dengan kurikulum terkurasi.</p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($upcomingEvents as $event)
                    <article class="group relative h-full rounded-[32px] border border-[#FAD6C7] bg-white/90 p-6 shadow-sm shadow-[#FAD6C7]/40 transition hover:-translate-y-1 hover:shadow-xl flex flex-col">
                        <div class="rounded-[28px] bg-gradient-to-br from-[#FFD4B6] via-[#FFE9DC] to-white p-5">
                            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]/80">
                                <span>{{ $event->start_at->translatedFormat('d M Y • H:i') }}</span>
                                <span class="text-[#2C1E1E]">Rp{{ number_format($event->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="mt-4 space-y-3">
                                <h3 class="text-xl font-semibold text-[#2C1E1E] group-hover:text-[#C65B74] transition">{{ $event->title }}</h3>
                                <p class="text-sm leading-relaxed text-[#5F4C4C]">{{ Str::limit(strip_tags($event->description), 130) }}</p>
                            </div>
                            <div class="mt-5 flex items-center gap-2 text-sm text-[#A04E62]">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c.828 0 1.5-.672 1.5-1.5S12.828 8 12 8s-1.5.672-1.5 1.5S11.172 11 12 11z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 10.5c0 7.5-8.25 11.25-8.25 11.25S3.75 18 3.75 10.5a8.25 8.25 0 1116.5 0z" />
                                </svg>
                                <span>{{ $event->venue_address }}</span>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-between rounded-2xl bg-[#FFF0E6] px-5 py-3 text-xs font-semibold uppercase tracking-[0.28em] text-[#A04E62]">
                            <span>Kuota tersisa: {{ $event->available_slots ?? 'Tidak terbatas' }}</span>
                            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center rounded-full bg-[#FF8A64] px-4 py-2 text-white transition hover:bg-[#F9744B]">Lihat Detail</a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-16 rounded-[32px] border border-dashed border-[#FAD6C7] bg-white/80">
                        <p class="text-[#5F4C4C]">Belum ada event yang tersedia saat ini. Nantikan pengumuman berikutnya!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-10">
            <div class="text-center space-y-3">
                <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF0E6] px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Portofolio</span>
                <h2 class="text-3xl font-semibold text-[#2C1E1E]">Portofolio Kegiatan</h2>
                <p class="text-base text-[#5F4C4C] max-w-2xl mx-auto">Dokumentasi berbagai workshop dan program kreatif yang pernah kami selenggarakan bersama komunitas dan mitra.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @forelse ($featuredPortfolios as $portfolio)
                    <article class="group overflow-hidden rounded-[32px] border border-[#FAD6C7] bg-white shadow-sm shadow-[#FAD6C7]/40">
                        <div class="relative h-52 overflow-hidden">
                            @if ($portfolio->media_url)
                                <img src="{{ $portfolio->media_url }}" alt="{{ $portfolio->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" />
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-[#FFE9DC] text-xs uppercase tracking-[0.35em] text-[#C65B74]/70">Dokumentasi</div>
                            @endif
                            <div class="absolute inset-x-4 bottom-4 rounded-full bg-white/90 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74] shadow-sm shadow-[#FAD6C7]/60">{{ $portfolio->event?->title ?? 'Program Internal' }}</div>
                        </div>
                        <div class="p-6 space-y-3">
                            <h3 class="text-lg font-semibold text-[#2C1E1E] group-hover:text-[#C65B74] transition">{{ $portfolio->title }}</h3>
                            <p class="text-sm leading-relaxed text-[#5F4C4C]">{{ Str::limit($portfolio->description, 110) }}</p>
                            @if ($portfolio->event)
                                <a href="{{ route('events.show', $portfolio->event) }}" class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]">
                                    Lihat Event
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-3 text-center py-14 rounded-[32px] border border-dashed border-[#FAD6C7] bg-white/80">
                        <p class="text-[#5F4C4C]">Belum ada dokumentasi portofolio yang dapat ditampilkan saat ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center">
                <a href="{{ route('portfolio.index') }}" class="inline-flex items-center rounded-full bg-[#FF8A64] px-7 py-3 text-sm font-semibold text-white shadow-md shadow-[#FF8A64]/30 transition hover:bg-[#F9744B]">
                    Jelajahi Semua Portofolio
                </a>
            </div>
        </div>
    </section>

    <section class="bg-gradient-to-r from-[#FFE1D2] via-[#FFD4B6] to-[#FFEDE1]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <div class="mx-auto max-w-3xl space-y-4">
                <h2 class="text-3xl font-semibold text-[#2C1E1E]">Siap Memulai Perjalanan Kreatif Anda?</h2>
                <p class="text-base text-[#5F4C4C]">Daftarkan tim atau komunitasmu pada program terbaik dari Kreasi Hangat dan rasakan pengalaman belajar yang hangat, kolaboratif, dan relevan.</p>
                <div class="flex flex-wrap justify-center gap-4 pt-2">
                    <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-full bg-white px-7 py-3 text-sm font-semibold text-[#C65B74] shadow-lg shadow-[#FFB6A0]/40 transition hover:text-[#A2475D]">
                        Lihat Event
                    </a>
                    <a href="{{ route('partnership.index') }}" class="inline-flex items-center rounded-full bg-[#FF8A64] px-7 py-3 text-sm font-semibold text-white shadow-md shadow-[#FF8A64]/30 transition hover:bg-[#F9744B]">
                        Ajukan Kolaborasi
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
