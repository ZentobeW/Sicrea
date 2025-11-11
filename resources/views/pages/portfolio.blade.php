@php
    use Illuminate\Pagination\AbstractPaginator;
    use Illuminate\Support\Str;

    $portfolioCollection = $portfolios instanceof AbstractPaginator ? $portfolios->getCollection() : collect($portfolios);
    $totalPortfolios = method_exists($portfolios, 'total') ? $portfolios->total() : $portfolioCollection->count();
    $categoryCount = $portfolioCollection->pluck('event_id')->filter()->unique()->count();
@endphp

<x-layouts.app :title="'Portofolio Sicrea'">
    <section class="relative overflow-hidden bg-gradient-to-br from-[#FFE3D3] via-[#FFF1EA] to-white">
        <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-[#FFD4B6]/60 blur-3xl"></div>
        <div class="absolute -left-16 bottom-0 h-64 w-64 rounded-full bg-[#FFB6A0]/40 blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid gap-12 lg:grid-cols-[1.1fr,0.9fr] items-center">
                <div class="space-y-8">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/80 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74] shadow-sm shadow-[#C65B74]/10">Portofolio</span>
                    <div class="space-y-5">
                        <h1 class="text-4xl md:text-5xl font-semibold leading-tight text-[#2C1E1E]">Portofolio Kegiatan</h1>
                        <p class="text-base md:text-lg leading-relaxed text-[#5F4C4C] max-w-2xl">Dokumentasi berbagai workshop dan event kreatif yang telah kami selenggarakan bersama komunitas dan mitra. Temukan inspirasi baru dari karya peserta dan kolaborator Kreasi Hangat.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-full bg-[#FF8A64] px-6 py-3 text-sm font-semibold text-white shadow-md shadow-[#FF8A64]/30 transition hover:bg-[#F9744B]">Cari Event Terkait</a>
                        <a href="{{ route('partnership.index') }}" class="inline-flex items-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-[#C65B74] shadow-sm shadow-[#FFB6A0]/40 transition hover:text-[#A2475D]">Ajukan Kolaborasi</a>
                        @can('access-admin')
                            <a href="{{ route('admin.portfolios.index') }}" class="inline-flex items-center rounded-full border border-[#FAD6C7] px-6 py-3 text-sm font-semibold text-[#C65B74] hover:border-[#C65B74] transition">Kelola Portofolio</a>
                        @endcan
                    </div>
                    <dl class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-3xl bg-white/80 p-5 text-center shadow-sm shadow-[#FAD6C7]/40 backdrop-blur">
                            <dt class="text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]/70">Dokumentasi</dt>
                            <dd class="mt-2 text-2xl font-semibold text-[#2C1E1E]">{{ $totalPortfolios }}</dd>
                        </div>
                        <div class="rounded-3xl bg-white/80 p-5 text-center shadow-sm shadow-[#FAD6C7]/40 backdrop-blur">
                            <dt class="text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]/70">Kategori</dt>
                            <dd class="mt-2 text-2xl font-semibold text-[#2C1E1E]">{{ $categoryCount ?: '10+' }}</dd>
                        </div>
                        <div class="rounded-3xl bg-white/80 p-5 text-center shadow-sm shadow-[#FAD6C7]/40 backdrop-blur">
                            <dt class="text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]/70">Kolaborator</dt>
                            <dd class="mt-2 text-2xl font-semibold text-[#2C1E1E]">{{ $portfolioCollection->isNotEmpty() ? '15+' : '—' }}</dd>
                        </div>
                    </dl>
                </div>
                <div class="relative">
                    <div class="rounded-[44px] border border-white/70 bg-white/80 p-6 shadow-xl shadow-[#E8BDB0]/40 backdrop-blur">
                        <div class="aspect-[4/3] overflow-hidden rounded-[36px] bg-[#FFE9DC] flex items-center justify-center text-sm uppercase tracking-[0.35em] text-[#C65B74]/70">Galeri Portofolio</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#FFF7F2]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-12">
            <div class="text-center space-y-4">
                <h2 class="text-3xl font-semibold text-[#2C1E1E]">Dokumentasi Terbaru</h2>
                <p class="text-base text-[#5F4C4C] max-w-2xl mx-auto">Setiap portofolio mengabadikan proses kreatif, suasana kelas, dan hasil karya peserta. Klik salah satu dokumentasi untuk terhubung dengan event terkait.</p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($portfolios as $portfolio)
                    @php($photoCount = $portfolio->images->count())
                    <article class="group flex h-full flex-col overflow-hidden rounded-[36px] border border-[#FAD6C7] bg-white shadow-sm shadow-[#FAD6C7]/40 transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative h-56 overflow-hidden">
                            @if ($portfolio->cover_image_url)
                                <img src="{{ $portfolio->cover_image_url }}" alt="{{ $portfolio->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-[#FFE3D3] text-xs uppercase tracking-[0.35em] text-[#C65B74]/70">Dokumentasi</div>
                            @endif
                            <div class="absolute inset-x-5 bottom-5 flex items-center justify-between rounded-full bg-white/95 px-5 py-2 text-[11px] font-semibold uppercase tracking-[0.28em] text-[#C65B74] shadow-md shadow-[#FAD6C7]/60">
                                <span>{{ $portfolio->created_at->translatedFormat('d M Y') }}</span>
                                <span>{{ $photoCount }} foto</span>
                            </div>
                        </div>
                        <div class="flex flex-1 flex-col gap-4 p-6">
                            <div class="space-y-2">
                                <h3 class="text-xl font-semibold text-[#2C1E1E] group-hover:text-[#C65B74] transition">{{ $portfolio->title }}</h3>
                                <p class="text-sm leading-relaxed text-[#5F4C4C]">{{ Str::limit($portfolio->description, 150) }}</p>
                                @if ($portfolio->event)
                                    <p class="text-xs text-[#A04E62]">{{ $portfolio->event->venue_name }} • {{ $portfolio->event->tutor_name }}</p>
                                    <p class="text-[11px] text-[#A04E62]">{{ $portfolio->event->venue_address }}</p>
                                @endif
                            </div>
                            <div class="mt-auto flex items-center justify-between rounded-2xl bg-[#FFF0E6] px-5 py-3 text-xs font-semibold uppercase tracking-[0.28em] text-[#C65B74]">
                                @if ($portfolio->event)
                                    <a href="{{ route('events.show', $portfolio->event) }}" class="inline-flex items-center gap-2 text-[#C65B74] hover:text-[#A2475D]">
                                        <span>
                                            {{ $portfolio->event->title }}
                                            <span class="block text-[11px] font-normal text-[#A04E62]">{{ $portfolio->event->venue_name }}</span>
                                        </span>
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @else
                                    <span>Program Internal</span>
                                @endif
                                <a href="mailto:hello@sicrea.id" class="inline-flex items-center rounded-full border border-[#C65B74]/20 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.28em] text-[#C65B74] hover:border-[#C65B74]">Hubungi Kami</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center rounded-[36px] border border-dashed border-[#FAD6C7] bg-white/80 py-16">
                        <p class="text-[#5F4C4C]">Belum ada portofolio yang dapat ditampilkan saat ini.</p>
                    </div>
                @endforelse
            </div>

            @if ($portfolios->hasPages())
                <div class="pt-6">
                    {{ $portfolios->links() }}
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
