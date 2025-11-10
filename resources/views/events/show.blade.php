@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="$event->title">
    <section class="relative overflow-hidden bg-gradient-to-b from-[#FDE8D5] via-[#FFF4EC] to-white">
        <div class="absolute -top-20 right-0 h-72 w-72 rounded-full bg-white/40 blur-3xl"></div>
        <div class="absolute -bottom-24 left-6 h-80 w-80 rounded-full bg-[#F7D6E0]/40 blur-3xl"></div>

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-10">
            <div class="flex items-center gap-3 text-sm text-[#B05A62]">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                <a href="{{ route('events.index') }}" class="font-medium hover:underline">Kembali ke Events</a>
            </div>

            <div class="grid gap-10 lg:grid-cols-[1.6fr,1fr] items-start">
                <div class="relative rounded-[40px] bg-white/70 p-10 shadow-[0_40px_80px_-60px_rgba(176,90,98,0.7)] backdrop-blur">
                    <div class="inline-flex items-center gap-3 rounded-full bg-[#FFF4EC] px-5 py-2 text-xs font-semibold uppercase tracking-[0.4em] text-[#B05A62]/80">
                        <span>{{ Str::of($event->title)->before(' ')->title() }}</span>
                        <span>{{ $event->start_at->translatedFormat('d M Y') }}</span>
                    </div>
                    <h1 class="mt-6 text-4xl font-semibold text-[#5A3D31]">{{ $event->title }}</h1>
                    <p class="mt-3 text-base text-slate-600 max-w-2xl leading-relaxed">
                        {{ Str::limit(strip_tags($event->description), 200) }}
                    </p>
                    <dl class="mt-8 grid gap-6 md:grid-cols-2">
                        <div class="rounded-2xl bg-[#FFF4EC] px-5 py-4">
                            <dt class="text-xs uppercase tracking-[0.3em] text-[#B05A62]/70">Tanggal &amp; Waktu</dt>
                            <dd class="mt-2 text-sm font-semibold text-[#5A3D31]">
                                {{ $event->start_at->translatedFormat('l, d F Y • H.i') }} WIB<br>
                                {{ $event->end_at->translatedFormat('l, d F Y • H.i') }} WIB
                            </dd>
                        </div>
                        <div class="rounded-2xl bg-[#FFF4EC] px-5 py-4">
                            <dt class="text-xs uppercase tracking-[0.3em] text-[#B05A62]/70">Venue</dt>
                            <dd class="mt-2 text-sm font-semibold text-[#5A3D31]">
                                {{ $event->venue_name }}<br>
                                <span class="text-xs font-normal text-slate-500">{{ $event->venue_address }}</span>
                            </dd>
                        </div>
                        <div class="rounded-2xl bg-[#FFF4EC] px-5 py-4">
                            <dt class="text-xs uppercase tracking-[0.3em] text-[#B05A62]/70">Kuota Tersisa</dt>
                            <dd class="mt-2 text-sm font-semibold text-[#5A3D31]">{{ $event->remainingSlots() ?? 'Tidak terbatas' }}</dd>
                        </div>
                        <div class="rounded-2xl bg-[#FFF4EC] px-5 py-4">
                            <dt class="text-xs uppercase tracking-[0.3em] text-[#B05A62]/70">Total Pendaftar</dt>
                            <dd class="mt-2 text-sm font-semibold text-[#5A3D31]">{{ $event->registrations_count }} Peserta</dd>
                        </div>
                    </dl>
                </div>

                <aside class="space-y-6">
                    <div class="rounded-[32px] bg-white px-6 py-8 shadow-[0_30px_60px_-45px_rgba(176,90,98,0.55)] border border-[#F4D5C7]">
                        <p class="text-xs uppercase tracking-[0.35em] text-[#B05A62]/70">Investasi</p>
                        <p class="mt-3 text-3xl font-semibold text-[#5A3D31]">
                            @if ($event->price > 0)
                                Rp{{ number_format($event->price, 0, ',', '.') }}
                            @else
                                Gratis
                            @endif
                        </p>
                        <p class="mt-2 text-sm text-slate-500">Termasuk materi dan akses rekaman sesi (jika tersedia).</p>
                        <div class="mt-6 space-y-3">
                            @auth
                                <a href="{{ route('events.register', $event) }}" class="inline-flex w-full items-center justify-center rounded-full bg-[#B05A62] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#9A4750]">
                                    Daftar Sekarang
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex w-full items-center justify-center rounded-full bg-[#B05A62] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#9A4750]">
                                    Login untuk Daftar
                                </a>
                            @endauth
                            <a href="mailto:halo@kreasihangat.com" class="inline-flex w-full items-center justify-center rounded-full border border-[#B05A62]/30 px-6 py-3 text-sm font-semibold text-[#B05A62] transition hover:border-[#B05A62]">
                                Tanya Tim Kami
                            </a>
                        </div>
                    </div>

                    <div class="rounded-[28px] bg-white px-6 py-6 border border-[#F4D5C7]/70">
                        <h2 class="text-lg font-semibold text-[#5A3D31]">Instruktur</h2>
                        <div class="mt-4 flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#FAD5B7] text-lg font-semibold text-[#B05A62]">
                                {{ Str::substr($event->tutor_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[#5A3D31]">{{ $event->tutor_name }}</p>
                                <p class="text-xs text-slate-500">Fasilitator utama program ini</p>
                                @if ($event->creator)
                                    <p class="mt-1 text-[11px] text-slate-400">Dikelola oleh {{ $event->creator->name }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($event->portfolios?->count())
                        <div class="rounded-[28px] bg-white px-6 py-6 border border-[#F4D5C7]/70 space-y-4">
                            <h2 class="text-lg font-semibold text-[#5A3D31]">Portofolio Terkait</h2>
                            <div class="space-y-3">
                                @foreach ($event->portfolios as $portfolio)
                                    <div class="rounded-2xl bg-[#FFF4EC] px-4 py-3">
                                        <p class="text-sm font-semibold text-[#5A3D31]">{{ $portfolio->title }}</p>
                                        @if ($portfolio->description)
                                            <p class="mt-1 text-xs text-slate-500">{{ Str::limit($portfolio->description, 90) }}</p>
                                        @endif
                                        @if ($portfolio->media_url)
                                            <a href="{{ $portfolio->media_url }}" target="_blank" class="mt-2 inline-flex text-xs font-semibold text-[#B05A62] hover:underline">Lihat dokumentasi</a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid gap-12 lg:grid-cols-[1.6fr,1fr]">
            <article class="space-y-6">
                <h2 class="text-2xl font-semibold text-[#5A3D31]">Tentang Workshop</h2>
                <div class="prose max-w-none text-slate-700 prose-p:leading-relaxed">
                    {!! nl2br(e($event->description)) !!}
                </div>
            </article>
            <div class="space-y-8">
                <div class="rounded-[28px] bg-[#FFF4EC] px-6 py-5">
                    <h3 class="text-lg font-semibold text-[#5A3D31]">Catatan Khusus</h3>
                    <p class="mt-2 text-sm text-slate-600">Pastikan hadir 15 menit sebelum sesi dimulai. Perlengkapan lengkap akan diinformasikan melalui email setelah pembayaran terkonfirmasi.</p>
                </div>
                <div class="rounded-[28px] bg-[#FFF4EC] px-6 py-5">
                    <h3 class="text-lg font-semibold text-[#5A3D31]">Butuh Bantuan?</h3>
                    <p class="mt-2 text-sm text-slate-600">Hubungi kami melalui WhatsApp di <span class="font-semibold text-[#B05A62]">+62 812-3456-7890</span> atau email ke <span class="font-semibold text-[#B05A62]">halo@kreasihangat.com</span>.</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
