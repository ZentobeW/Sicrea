@php use Illuminate\Support\Str; @endphp
<x-layouts.app :title="'Kreasi Hangat'">
    <section id="home" class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid gap-12 lg:grid-cols-[1fr,1.1fr] items-center">
                <div class="space-y-6">
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-4 py-1 text-sm font-medium text-slate-600">Kreasi Hangat</span>
                    <h1 class="text-4xl md:text-5xl font-semibold leading-tight text-slate-900">Rangkaian Workshop dan Event Kreatif untuk Komunitasmu</h1>
                    <p class="text-base md:text-lg text-slate-600 leading-relaxed">Bangun jejaring, tingkatkan skill, dan temukan peluang kolaborasi melalui event yang dikurasi secara personal oleh tim Sicrea.</p>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="#events" class="inline-flex items-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 hover:bg-slate-700 transition">Lihat Event Mendatang</a>
                        <a href="#portfolio" class="inline-flex items-center text-sm font-semibold text-slate-700 hover:text-indigo-600 transition">Jelajahi Portofolio</a>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/3] rounded-3xl bg-slate-200 flex items-center justify-center text-slate-400 text-xs tracking-[0.3em] uppercase">Hero Image</div>
                    <div class="hidden lg:block absolute -bottom-6 -left-6 w-40 h-40 rounded-3xl border-4 border-white bg-slate-100"></div>
                </div>
            </div>
        </div>
    </section>

    <section id="events" class="bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="space-y-3 mb-10">
                <span class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">Event Mendatang</span>
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                    <div>
                        <h2 class="text-3xl font-semibold text-slate-900">Agenda Kreatif Bulan Ini</h2>
                        <p class="mt-2 text-slate-600">Pilih aktivitas yang paling sesuai dengan kebutuhan tim dan komunitasmu.</p>
                    </div>
                    @if ($events->total() > 0)
                        <p class="text-sm text-slate-500">Menampilkan {{ $events->firstItem() }}-{{ $events->lastItem() }} dari {{ $events->total() }} event.</p>
                    @endif
                </div>
            </div>

            <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
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

    <section id="portfolio" class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid gap-12 lg:grid-cols-[1fr,1.1fr] items-start">
                <div class="space-y-4">
                    <span class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">Portfolio</span>
                    <h2 class="text-3xl font-semibold text-slate-900">Tampilkan Dampak Kegiatan</h2>
                    <p class="text-base text-slate-600 leading-relaxed">Lihat dokumentasi program dan kisah sukses alumni yang memperlihatkan bagaimana Sicrea membantu komunitas kreatif berkembang.</p>
                    <a href="#" class="inline-flex items-center text-sm font-semibold text-slate-900 hover:text-indigo-600 transition">Lihat Selengkapnya</a>
                </div>
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="rounded-3xl bg-slate-100 aspect-[4/3]"></div>
                    <div class="rounded-3xl bg-slate-200 aspect-[4/3]"></div>
                    <div class="rounded-3xl bg-slate-200 aspect-[4/3]"></div>
                    <div class="rounded-3xl bg-slate-100 aspect-[4/3]"></div>
                </div>
            </div>
        </div>
    </section>

    <section id="partnership" class="bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid gap-12 lg:grid-cols-2 items-center">
                <div class="space-y-4">
                    <span class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">Partnership</span>
                    <h2 class="text-3xl font-semibold text-slate-900">Kolaborasi dengan Brand &amp; Komunitas</h2>
                    <p class="text-base text-slate-600 leading-relaxed">Kami membuka peluang kerjasama untuk menghadirkan program kolaboratif yang berdampak. Hubungi kami untuk eksplorasi ide bersama.</p>
                    <a href="mailto:hello@sicrea.id" class="inline-flex items-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-700 transition">Ajukan Kerjasama</a>
                </div>
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="rounded-3xl bg-white border border-slate-100 p-6 space-y-3">
                        <h3 class="text-lg font-semibold text-slate-900">Program Komunitas</h3>
                        <p class="text-sm text-slate-600">Rancang sesi berbagi inspirasi, kelas kreatif, atau mini showcase bersama jejaring komunitasmu.</p>
                    </div>
                    <div class="rounded-3xl bg-white border border-slate-100 p-6 space-y-3">
                        <h3 class="text-lg font-semibold text-slate-900">Brand Activation</h3>
                        <p class="text-sm text-slate-600">Bangun engagement dengan audiens kreatif melalui aktivasi brand yang otentik.</p>
                    </div>
                    <div class="rounded-3xl bg-white border border-slate-100 p-6 space-y-3">
                        <h3 class="text-lg font-semibold text-slate-900">Program Internal</h3>
                        <p class="text-sm text-slate-600">Kembangkan talenta internal perusahaan lewat workshop yang dirancang khusus.</p>
                    </div>
                    <div class="rounded-3xl bg-white border border-slate-100 p-6 space-y-3">
                        <h3 class="text-lg font-semibold text-slate-900">Paket Custom</h3>
                        <p class="text-sm text-slate-600">Sesuaikan pengalaman sesuai kebutuhan bisnis maupun komunitas kamu.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid gap-12 lg:grid-cols-[1.1fr,1fr] items-center">
                <div class="space-y-4">
                    <span class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">About Us</span>
                    <h2 class="text-3xl font-semibold text-slate-900">Cerita di Balik Sicrea</h2>
                    <p class="text-base text-slate-600 leading-relaxed">Kami adalah studio kreatif yang berfokus membangun pengalaman belajar dan kolaborasi untuk pegiat industri kreatif. Dengan kurasi kegiatan yang relevan dan dukungan mentor ahli, Sicrea membantu komunitas berkembang secara berkelanjutan.</p>
                    <div class="flex flex-wrap items-center gap-4 text-sm text-slate-600">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-900 text-white font-semibold">10+</span>
                            <span>Program tahunan</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-900 text-white font-semibold">500+</span>
                            <span>Alumni komunitas</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-3xl bg-slate-100 aspect-[4/3]"></div>
            </div>
        </div>
    </section>
</x-layouts.app>
