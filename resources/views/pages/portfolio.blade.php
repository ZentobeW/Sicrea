@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="'Portofolio Sicrea'">
    <section class="bg-white border-b border-slate-200/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid gap-10 lg:grid-cols-[1.1fr,0.9fr] items-center">
                <div class="space-y-6">
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-slate-600">Portfolio</span>
                    <h1 class="text-4xl md:text-5xl font-semibold text-slate-900 leading-tight">Dokumentasi Program &amp; Kisah Dampak</h1>
                    <p class="text-base md:text-lg text-slate-600 leading-relaxed">Telusuri hasil kolaborasi bersama komunitas dan brand. Setiap dokumentasi menyoroti proses, capaian, dan pengalaman peserta.</p>
                    <div class="flex flex-wrap items-center gap-4">
                        @can('access-admin')
                            <a href="{{ route('admin.portfolios.index') }}" class="inline-flex items-center rounded-full border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 hover:border-indigo-600 hover:text-indigo-600 transition">Kelola Portofolio</a>
                        @endcan
                        <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-700 transition">Cari Event Terkait</a>
                    </div>
                </div>
                <div class="rounded-3xl bg-slate-100 border border-slate-200 aspect-[4/3] flex items-center justify-center text-xs uppercase tracking-[0.4em] text-slate-400">Portfolio Visual</div>
            </div>
        </div>
    </section>

    <section class="bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-12">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <h2 class="text-3xl font-semibold text-slate-900">Sorotan Terbaru</h2>
                    <p class="text-slate-600 max-w-2xl">Konten ini dapat digunakan sebagai materi promosi atau inspirasi program berikutnya.</p>
                </div>
                <a href="{{ route('partnership.index') }}" class="inline-flex items-center rounded-full border border-slate-200 px-5 py-2 text-sm font-semibold text-slate-700 hover:border-indigo-600 hover:text-indigo-600 transition">Ajukan Kolaborasi</a>
            </div>

            <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($portfolios as $portfolio)
                    <article class="group h-full rounded-3xl border border-slate-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg overflow-hidden flex flex-col">
                        @if ($portfolio->media_url)
                            <img src="{{ $portfolio->media_url }}" alt="{{ $portfolio->title }}" class="h-48 w-full object-cover transition duration-300 group-hover:scale-105" />
                        @else
                            <div class="h-48 w-full bg-slate-100 flex items-center justify-center text-xs tracking-[0.3em] uppercase text-slate-400">Dokumentasi</div>
                        @endif
                        <div class="flex-1 p-6 space-y-3">
                            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">
                                <span>{{ $portfolio->created_at->translatedFormat('d M Y') }}</span>
                                @if ($portfolio->event)
                                    <span class="text-indigo-600">{{ $portfolio->event->start_at?->translatedFormat('M Y') }}</span>
                                @endif
                            </div>
                            <h3 class="text-xl font-semibold text-slate-900 group-hover:text-indigo-600 transition">{{ $portfolio->title }}</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ Str::limit($portfolio->description, 140) }}</p>
                        </div>
                        <div class="px-6 pb-6">
                            <div class="flex items-center justify-between rounded-2xl bg-slate-100/80 px-4 py-3 text-xs font-medium text-slate-500">
                                @if ($portfolio->event)
                                    <a href="{{ route('events.show', $portfolio->event->slug) }}" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-500">
                                        <span class="font-semibold uppercase tracking-[0.25em]">{{ $portfolio->event->title }}</span>
                                    </a>
                                @else
                                    <span>Mandiri / Inisiatif Internal</span>
                                @endif
                                <a href="mailto:hello@sicrea.id" class="inline-flex items-center rounded-full border border-slate-300 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.25em] text-slate-700 hover:border-indigo-600 hover:text-indigo-600 transition">Hubungi Kami</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-20 rounded-3xl border border-dashed border-slate-300 bg-white">
                        <p class="text-slate-500">Belum ada portofolio yang dapat ditampilkan saat ini.</p>
                    </div>
                @endforelse
            </div>

            @if ($portfolios->hasPages())
                <div class="pt-4">
                    {{ $portfolios->links() }}
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
