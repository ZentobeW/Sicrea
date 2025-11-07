@php
    use Illuminate\Support\Str;
@endphp

@push('styles')
    <style>
        @keyframes floatPulse {
            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.6s ease, transform 0.6s ease;
            transition-delay: var(--reveal-delay, 0ms);
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.85) 0%, rgba(255, 255, 255, 0.95) 100%);
            box-shadow: 0 30px 60px -28px rgba(199, 112, 88, 0.45);
            animation: floatPulse 5s ease-in-out infinite;
        }

        .hero-bubble {
            position: absolute;
            border-radius: 999px;
            filter: blur(60px);
            opacity: 0.7;
        }

        .hero-bubble--left {
            width: 240px;
            height: 240px;
            left: -60px;
            top: -80px;
            background: rgba(255, 196, 164, 0.65);
        }

        .hero-bubble--right {
            width: 280px;
            height: 280px;
            right: -80px;
            bottom: -100px;
            background: rgba(255, 176, 201, 0.5);
        }

        .partnership-nav a {
            transition: all 0.2s ease;
        }

        .partnership-nav a:hover,
        .partnership-nav a:focus {
            background: rgba(255, 255, 255, 0.4);
            color: #c35a63;
        }

        .benefit-card,
        .model-card,
        .portfolio-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .benefit-card:hover,
        .model-card:hover,
        .portfolio-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px -24px rgba(194, 90, 99, 0.55);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.2 });

            document.querySelectorAll('.reveal').forEach((element) => observer.observe(element));

            const navLinks = document.querySelectorAll('[data-scroll-target]');
            navLinks.forEach((link) => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();

                    const targetId = link.getAttribute('data-scroll-target');
                    const targetElement = document.getElementById(targetId);

                    if (!targetElement) {
                        return;
                    }

                    const headerOffset = 96;
                    const elementPosition = targetElement.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth',
                    });
                });
            });
        });
    </script>
@endpush

<x-layouts.app :title="'Kemitraan Sicrea'">
    <section id="hero" class="relative overflow-hidden bg-gradient-to-br from-[#FFE0D0] via-[#FFEDE2] to-[#FFF7F1]">
        <span class="hero-bubble hero-bubble--left"></span>
        <span class="hero-bubble hero-bubble--right"></span>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
            <div class="grid gap-12 lg:grid-cols-[1.1fr,0.9fr] items-center">
                <div class="space-y-8 reveal" style="--reveal-delay: 0ms;">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/70 px-5 py-2 text-xs font-semibold uppercase tracking-[0.4em] text-[#C65B74]">
                        Partnership
                    </div>
                    <div class="space-y-4">
                        <h1 class="text-4xl md:text-5xl font-semibold leading-tight text-[#2C1E1E]">
                            Mari Berkolaborasi Mengembangkan Ekosistem Kreatif
                        </h1>
                        <p class="text-base md:text-lg leading-relaxed text-[#5F4C4C] max-w-2xl">
                            Sicrea menghadirkan pendekatan menyeluruh untuk menghadirkan pengalaman kreatif yang relevan. Kami siap mendampingi brand, komunitas, dan institusi dari perencanaan hingga aktivasi multi kanal.
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="mailto:partnership@sicrea.id" class="inline-flex items-center rounded-full bg-[#FF8A64] px-7 py-3 text-sm font-semibold text-white shadow-lg shadow-[#FF8A64]/40 transition hover:bg-[#F9744B]">
                            Hubungi Kami
                        </a>
                        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 rounded-full bg-white/80 px-6 py-3 text-sm font-semibold text-[#C65B74] shadow-sm shadow-[#FFB6A0]/30 transition hover:bg-white">
                            Lihat Agenda Program
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="partnership-nav flex flex-wrap gap-3 pt-4">
                        <a href="#benefits" data-scroll-target="benefits" class="inline-flex items-center gap-2 rounded-full bg-white/60 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-[#A04E62]">
                            Benefit
                        </a>
                        <a href="#portfolio" data-scroll-target="portfolio" class="inline-flex items-center gap-2 rounded-full bg-white/60 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-[#A04E62]">
                            Portfolio
                        </a>
                        <a href="#models" data-scroll-target="models" class="inline-flex items-center gap-2 rounded-full bg-white/60 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-[#A04E62]">
                            Model Kolaborasi
                        </a>
                        <a href="#contact" data-scroll-target="contact" class="inline-flex items-center gap-2 rounded-full bg-white/60 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-[#A04E62]">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
                <div class="reveal lg:justify-self-end w-full max-w-xl" style="--reveal-delay: 120ms;">
                    <div class="hero-card relative rounded-[40px] border border-white/60 p-6 backdrop-blur">
                        <div class="aspect-[4/5] overflow-hidden rounded-[32px] bg-[#FCD9CA] flex items-center justify-center text-sm uppercase tracking-[0.35em] text-[#C65B74]/70">
                            Dokumentasi Kolaborasi
                        </div>
                        <div class="absolute -bottom-8 left-10 rounded-3xl bg-white px-5 py-4 shadow-xl shadow-[#FFB6A0]/40">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]/70">Highlight</p>
                            <p class="mt-1 text-sm font-medium text-[#2C1E1E]">Pendekatan end-to-end untuk setiap kemitraan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <dl class="mt-16 grid gap-6 sm:grid-cols-3">
                @foreach ($highlightStats as $index => $stat)
                    <div class="reveal rounded-3xl bg-white/80 p-6 shadow-sm shadow-[#FFB6A0]/30 backdrop-blur" style="--reveal-delay: {{ 140 + ($index * 120) }}ms;">
                        <dt class="text-sm font-medium text-[#A04E62]">{{ $stat['label'] }}</dt>
                        <dd class="mt-3 text-3xl font-semibold text-[#2C1E1E]">{{ $stat['value'] }}</dd>
                        <p class="mt-2 text-sm text-[#5F4C4C]">{{ $stat['description'] }}</p>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    <section id="benefits" class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 space-y-12">
            <div class="space-y-4 text-center reveal" style="--reveal-delay: 60ms;">
                <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF0E6] px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Mengapa Bermitra</span>
                <h2 class="text-3xl font-semibold text-[#2C1E1E]">Mengapa Bermitra dengan Kami?</h2>
                <p class="mx-auto max-w-2xl text-sm leading-relaxed text-[#5F4C4C]">Tim Sicrea membantu Anda menyiapkan program yang berdampak, mulai dari strategi kreatif, produksi konten, hingga analisis performa untuk kolaborasi berkelanjutan.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($partnershipBenefits as $index => $benefit)
                    <article class="benefit-card reveal h-full rounded-[28px] border border-[#FAD6C7] bg-[#FFFAF6] p-6" style="--reveal-delay: {{ 120 + ($index * 100) }}ms;">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl shadow-sm shadow-[#FAD6C7]/60">
                            <x-dynamic-component :component="'heroicon-o-' . $benefit['icon']" class="h-7 w-7 text-[#C65B74]" />
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-[#2C1E1E]">{{ $benefit['title'] }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-[#5F4C4C]">{{ $benefit['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="portfolio" class="bg-[#FFF7F2]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 space-y-12">
            <div class="text-center space-y-3 reveal" style="--reveal-delay: 80ms;">
                <span class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Portofolio</span>
                <h2 class="text-3xl font-semibold text-[#2C1E1E]">Portofolio Terbaik Kami</h2>
                <p class="mx-auto max-w-2xl text-sm leading-relaxed text-[#5F4C4C]">Lihat beberapa dokumentasi kolaborasi yang berhasil membantu partner memperluas audiens dan menghadirkan pengalaman baru.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @forelse ($featuredPortfolios as $index => $portfolio)
                    <article class="portfolio-card reveal group overflow-hidden rounded-[32px] border border-[#FAD6C7] bg-white shadow-sm shadow-[#FAD6C7]/40" style="--reveal-delay: {{ 120 + ($index * 120) }}ms;">
                        <div class="relative h-56 overflow-hidden">
                            @if ($portfolio->media_url)
                                <img src="{{ $portfolio->media_url }}" alt="{{ $portfolio->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" />
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-[#FFE9DC] text-xs uppercase tracking-[0.35em] text-[#C65B74]/70">
                                    Dokumentasi
                                </div>
                            @endif
                            <div class="absolute inset-x-5 bottom-5 rounded-full bg-white/90 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74] shadow-sm shadow-[#FAD6C7]/60">
                                {{ $portfolio->event?->title ?? 'Program Internal' }}
                            </div>
                        </div>
                        <div class="p-6 space-y-3">
                            <h3 class="text-lg font-semibold text-[#2C1E1E]">{{ $portfolio->title }}</h3>
                            <p class="text-sm leading-relaxed text-[#5F4C4C]">{{ Str::limit($portfolio->description, 110) }}</p>
                            @if ($portfolio->event)
                                <a href="{{ route('events.show', $portfolio->event->slug) }}" class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]">
                                    Lihat Event
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="reveal md:col-span-3 rounded-[32px] border border-dashed border-[#FAD6C7] bg-white/80 py-16" style="--reveal-delay: 120ms;">
                        <p class="text-sm text-[#5F4C4C]">Belum ada portofolio yang dapat ditampilkan saat ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center reveal" style="--reveal-delay: 160ms;">
                <a href="{{ route('portfolio.index') }}" class="inline-flex items-center rounded-full bg-[#FF8A64] px-7 py-3 text-sm font-semibold text-white shadow-md shadow-[#FF8A64]/30 transition hover:bg-[#F9744B]">
                    Jelajahi Semua Portofolio
                </a>
            </div>
        </div>
    </section>

    <section id="models" class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 space-y-12">
            <div class="space-y-4 text-center reveal" style="--reveal-delay: 60ms;">
                <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF0E6] px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Model Kolaborasi</span>
                <h2 class="text-3xl font-semibold text-[#2C1E1E]">Model Kolaborasi yang Dapat Dipilih</h2>
                <p class="mx-auto max-w-2xl text-sm leading-relaxed text-[#5F4C4C]">Pilih format kerjasama yang paling sesuai dengan objektif brand Anda atau diskusikan konsep khusus bersama tim kami.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($partnershipSupports as $index => $support)
                    <article class="model-card reveal h-full rounded-[28px] border border-dashed border-[#FAD6C7] bg-[#FFF7F2] p-6" style="--reveal-delay: {{ 120 + ($index * 100) }}ms;">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl shadow-sm shadow-[#FAD6C7]/60">
                            <x-dynamic-component :component="'heroicon-o-' . $support['icon']" class="h-7 w-7 text-[#C65B74]" />
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-[#2C1E1E]">{{ $support['title'] }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-[#5F4C4C]">{{ $support['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="contact" class="bg-gradient-to-r from-[#FFE1D2] via-[#FFD4B6] to-[#FFEDE1]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid gap-10 lg:grid-cols-[1.1fr,0.9fr] items-center">
                <div class="reveal space-y-4" style="--reveal-delay: 80ms;">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/70 px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Tertarik Kolaborasi?</span>
                    <h2 class="text-3xl font-semibold text-[#2C1E1E]">Tertarik untuk Berkolaborasi?</h2>
                    <p class="text-sm leading-relaxed text-[#5F4C4C] max-w-xl">Mari diskusikan kebutuhan Anda lebih lanjut. Tim kami akan membantu memetakan tujuan program, audiens, hingga format eksekusi yang paling sesuai.</p>
                    <div class="space-y-2 text-sm text-[#5F4C4C]">
                        <div class="flex items-start gap-3">
                            <x-heroicon-o-map-pin class="mt-1 h-5 w-5 text-[#C65B74]" />
                            <span>{{ $contactInfo['address'] }}</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <x-heroicon-o-phone class="mt-1 h-5 w-5 text-[#C65B74]" />
                            <span>{{ $contactInfo['phone'] }}</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <x-heroicon-o-envelope class="mt-1 h-5 w-5 text-[#C65B74]" />
                            <a href="mailto:{{ $contactInfo['email'] }}" class="underline decoration-[#C65B74]/50 hover:text-[#C65B74]">{{ $contactInfo['email'] }}</a>
                        </div>
                    </div>
                </div>
                <div class="reveal" style="--reveal-delay: 140ms;">
                    <div class="rounded-[32px] bg-white/80 p-8 shadow-xl shadow-[#FFB6A0]/40 backdrop-blur">
                        <h3 class="text-lg font-semibold text-[#2C1E1E]">Siap Mulai?</h3>
                        <p class="mt-3 text-sm leading-relaxed text-[#5F4C4C]">Kirimkan detail singkat mengenai kebutuhan kolaborasi Anda dan tim kami akan menghubungi dalam 1x24 jam kerja.</p>
                        <div class="mt-6 space-y-4">
                            <a href="mailto:{{ $contactInfo['email'] }}" class="flex items-center justify-between rounded-2xl border border-[#FAD6C7] bg-white px-5 py-3 text-sm font-semibold text-[#C65B74]">
                                Kirim Brief Melalui Email
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7l5 5-5 5M6 12h12" />
                                </svg>
                            </a>
                            <a href="https://wa.me/{{ $contactInfo['whatsapp'] }}" target="_blank" rel="noreferrer" class="flex items-center justify-between rounded-2xl bg-[#FF8A64] px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-[#FF8A64]/40 transition hover:bg-[#F9744B]">
                                Chat via WhatsApp
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16h6a3 3 0 003-3V8a3 3 0 00-3-3H9a3 3 0 00-3 3v5a3 3 0 003 3z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
