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
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid gap-12 lg:grid-cols-[1fr,1.1fr] items-center">
                <div class="space-y-6">
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-4 py-1 text-sm font-medium text-slate-600">Kreasi Hangat</span>
                    <h1 class="text-4xl md:text-5xl font-semibold leading-tight text-slate-900">Rangkaian Workshop dan Event Kreatif untuk Komunitasmu</h1>
                    <p class="text-base md:text-lg text-slate-600 leading-relaxed">Bangun jejaring, tingkatkan skill, dan temukan peluang kolaborasi melalui event yang dikurasi secara personal oleh tim Sicrea.</p>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 hover:bg-slate-700 transition">Lihat Event Mendatang</a>
                        <a href="{{ route('portfolio.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-700 hover:text-indigo-600 transition">Jelajahi Portofolio</a>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/3] rounded-3xl bg-slate-200 flex items-center justify-center text-slate-400 text-xs tracking-[0.3em] uppercase">Hero Image</div>
                    <div class="hidden lg:block absolute -bottom-6 -left-6 w-40 h-40 rounded-3xl border-4 border-white bg-slate-100"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-12">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <span class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Event Mendatang</span>
                    <h2 class="text-3xl font-semibold text-slate-900">Agenda Kreatif Bulan Ini</h2>
                    <p class="text-slate-600 max-w-2xl">Pilih aktivitas yang paling sesuai dengan kebutuhan tim dan komunitasmu.</p>
                </div>
                <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-full border border-slate-200 px-5 py-2 text-sm font-semibold text-slate-700 hover:border-indigo-600 hover:text-indigo-600 transition">Lihat Semua Event</a>
            </div>

            <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($upcomingEvents as $event)
                    <article class="group rounded-3xl bg-white border border-slate-100/80 shadow-sm hover:shadow-lg transition overflow-hidden">
                        <div class="p-6 space-y-6">
                            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">
                                <span>{{ $event->start_at->translatedFormat('d M Y • H:i') }}</span>
                                <span class="text-slate-900">Rp{{ number_format($event->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="space-y-3">
                                <h3 class="text-xl font-semibold text-slate-900 group-hover:text-indigo-600 transition">{{ $event->title }}</h3>
                                <p class="text-sm text-slate-600 leading-relaxed">{{ Str::limit(strip_tags($event->description), 130) }}</p>
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
                    <div class="col-span-full text-center py-16 rounded-3xl border border-dashed border-slate-300 bg-white">
                        <p class="text-slate-500">Belum ada event yang tersedia saat ini. Nantikan pengumuman berikutnya!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid gap-10 lg:grid-cols-[1.1fr,0.9fr] items-center">
            <div class="space-y-5">
                <span class="inline-flex items-center rounded-full bg-slate-100 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-slate-600">Tentang Sicrea</span>
                <h2 class="text-3xl md:text-4xl font-semibold text-slate-900 leading-tight">Merancang pengalaman belajar dan kolaborasi yang berdampak</h2>
                <p class="text-base text-slate-600 leading-relaxed">Sicrea hadir sebagai studio kreatif yang menghubungkan mentor ahli dengan komunitas dan brand. Kami merancang workshop, program inkubasi, dan showcase yang mendorong kolaborasi lintas disiplin.</p>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white/60 p-4 shadow-sm">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-slate-900 text-white text-base font-semibold">{{ $formatStat($stats['published_events']) }}</div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Program Tahunan</p>
                            <p class="text-sm font-medium text-slate-700">Dirancang bersama praktisi</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white/60 p-4 shadow-sm">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-slate-900 text-white text-base font-semibold">{{ $formatStat($stats['confirmed_participants']) }}</div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Alumni Komunitas</p>
                            <p class="text-sm font-medium text-slate-700">Aktif berjejaring &amp; berkarya</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('about.index') }}" class="inline-flex items-center rounded-full border border-slate-200 px-5 py-2 text-sm font-semibold text-slate-700 hover:border-indigo-600 hover:text-indigo-600 transition">Pelajari Lebih Lanjut</a>
            </div>
            <div class="relative">
                <div class="aspect-[4/3] rounded-3xl bg-slate-200 flex items-center justify-center text-xs uppercase tracking-[0.4em] text-slate-400">Foto Studio</div>
                <div class="absolute -bottom-8 -right-6 hidden lg:block w-48 rounded-3xl border border-white bg-white/90 p-5 shadow-xl backdrop-blur">
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Highlight</p>
                    <p class="mt-2 text-sm font-semibold text-slate-800">Kolaborasi lintas kota dan komunitas kreatif Indonesia.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-12">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <span class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Portfolio</span>
                    <h2 class="text-3xl font-semibold text-slate-900">Tampilkan Dampak Kegiatan</h2>
                    <p class="text-slate-600 max-w-2xl">Lihat dokumentasi program dan kisah sukses alumni yang memperlihatkan bagaimana Sicrea membantu komunitas kreatif berkembang.</p>
                </div>
                <a href="{{ route('portfolio.index') }}" class="inline-flex items-center rounded-full border border-slate-200 px-5 py-2 text-sm font-semibold text-slate-700 hover:border-indigo-600 hover:text-indigo-600 transition">Lihat Semua Portofolio</a>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @forelse ($featuredPortfolios as $portfolio)
                    <article class="group relative overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">
                        @if ($portfolio->media_url)
                            <img src="{{ $portfolio->media_url }}" alt="{{ $portfolio->title }}" class="h-48 w-full object-cover transition duration-300 group-hover:scale-105" />
                        @else
                            <div class="h-48 w-full bg-slate-100 flex items-center justify-center text-xs tracking-[0.3em] uppercase text-slate-400">Dokumentasi</div>
                        @endif
                        <div class="p-5 space-y-2">
                            <h3 class="text-lg font-semibold text-slate-900 group-hover:text-indigo-600 transition">{{ $portfolio->title }}</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ Str::limit($portfolio->description, 110) }}</p>
                            @if ($portfolio->event)
                                <a href="{{ route('events.show', $portfolio->event->slug) }}" class="inline-flex items-center text-xs font-semibold uppercase tracking-[0.25em] text-indigo-600">{{ $portfolio->event->title }}</a>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-3 text-center py-12 rounded-3xl border border-dashed border-slate-200 bg-white">
                        <p class="text-slate-500">Belum ada dokumentasi portofolio yang dapat ditampilkan saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid gap-12 lg:grid-cols-2 items-center">
            <div class="space-y-5">
                <span class="inline-flex items-center rounded-full bg-slate-100 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-slate-600">Kemitraan</span>
                <h2 class="text-3xl md:text-4xl font-semibold text-slate-900 leading-tight">Siap berkolaborasi dengan brand dan komunitas</h2>
                <p class="text-base text-slate-600 leading-relaxed">Jelajahi peluang kemitraan yang menghadirkan nilai tambah untuk audiensmu. Mulai dari sponsor hingga program tailor-made, tim Sicrea siap membantu.</p>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('partnership.index') }}" class="inline-flex items-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-700 transition">Detail Kemitraan</a>
                    <a href="mailto:hello@sicrea.id" class="inline-flex items-center text-sm font-semibold text-slate-700 hover:text-indigo-600 transition">Hubungi Kami</a>
                </div>
            </div>
            <div class="rounded-3xl bg-slate-100 border border-slate-200 aspect-[4/3] flex items-center justify-center text-xs uppercase tracking-[0.4em] text-slate-400">Partnership Visual</div>
        </div>
    </section>
</x-layouts.app>
