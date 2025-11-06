@php
    $formatStat = static function (int $value): string {
        if ($value >= 1000) {
            return rtrim(number_format($value / 1000, 1), '.0') . 'K+';
        }

        return $value . ($value > 0 ? '+' : '');
    };
@endphp

@push('styles')
    <style>
        @keyframes floatPulse {
            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
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

        .floating-card {
            animation: floatPulse 6s ease-in-out infinite;
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
        });
    </script>
@endpush

<x-layouts.app :title="'Tentang Sicrea'">
    <section class="relative overflow-hidden bg-gradient-to-b from-[#FFF4EB] via-white to-white">
        <div class="absolute inset-x-0 -top-24 flex justify-center" aria-hidden="true">
            <div class="h-56 w-[480px] rounded-full bg-gradient-to-r from-[#FDC5B3]/60 to-[#F8E3D4]/40 blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-24">
            <div class="grid gap-16 lg:grid-cols-[1.15fr,0.85fr] items-center">
                <div class="reveal space-y-6" style="--reveal-delay: 60ms;">
                    <span class="inline-flex items-center rounded-full border border-amber-200 bg-white/70 px-5 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-amber-600">Tentang Kami</span>
                    <h1 class="text-4xl md:text-5xl font-semibold text-slate-900 leading-tight">Tentang Kreasi Hangat</h1>
                    <p class="text-base md:text-lg text-slate-600 leading-relaxed max-w-xl">Kami menghadirkan ruang belajar dan kolaborasi lintas disiplin yang hangat dan relevan bagi talenta kreatif Indonesia. Program kami dirancang humanis, terukur, dan berdampak pada komunitas.</p>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="flex items-center gap-4 rounded-3xl bg-white/80 p-5 shadow-sm ring-1 ring-white/60">
                            <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-[#FF8B64] to-[#FF5E7A] text-white text-base font-semibold">{{ $formatStat($stats['published_events']) }}</div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Program Rutin</p>
                                <p class="text-sm font-medium text-slate-700">Selama satu tahun terakhir</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 rounded-3xl bg-white/80 p-5 shadow-sm ring-1 ring-white/60">
                            <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-[#7F9CF5] to-[#6C63FF] text-white text-base font-semibold">{{ $formatStat($stats['confirmed_participants']) }}</div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Alumni Aktif</p>
                                <p class="text-sm font-medium text-slate-700">Berkolaborasi dalam jaringan kami</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-full bg-gradient-to-r from-[#FF8B64] to-[#FF5E7A] px-7 py-3 text-sm font-semibold text-white shadow-md shadow-amber-200/60 transition hover:shadow-lg hover:shadow-amber-200/80">Jelajahi Program</a>
                        <a href="{{ route('partnership.index') }}" class="inline-flex items-center rounded-full border border-amber-200/80 px-7 py-3 text-sm font-semibold text-amber-600 transition hover:border-amber-400 hover:text-amber-700">Kolaborasi dengan Kami</a>
                    </div>
                </div>

                <div class="reveal" style="--reveal-delay: 160ms;">
                    <div class="relative">
                        <div class="aspect-[4/3] rounded-[32px] bg-gradient-to-br from-[#FFE4D6] via-[#FFF1E5] to-white p-4 shadow-xl">
                            <div class="flex h-full w-full items-center justify-center rounded-[24px] border border-dashed border-amber-200 bg-white/60 text-xs uppercase tracking-[0.35em] text-amber-400">Galeri Kreasi Hangat</div>
                        </div>
                        <div class="floating-card absolute -bottom-8 left-8 w-56 rounded-3xl bg-white/95 p-6 shadow-lg ring-1 ring-amber-100">
                            <p class="text-xs uppercase tracking-[0.35em] text-amber-400">Cerita Kami</p>
                            <p class="mt-3 text-sm font-semibold text-slate-800 leading-relaxed">Menghubungkan kreator, mentor, dan brand untuk pengalaman belajar yang lebih hangat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid gap-10 lg:grid-cols-[1.05fr,1fr] items-start">
                <div class="reveal space-y-6" style="--reveal-delay: 80ms;">
                    <span class="text-xs font-semibold uppercase tracking-[0.35em] text-amber-500">Visi &amp; Misi</span>
                    <h2 class="text-3xl font-semibold text-slate-900 leading-snug">Mewujudkan pengalaman belajar kreatif yang hangat, relevan, dan inklusif.</h2>
                    <p class="text-base text-slate-600 leading-relaxed">Setiap program Kreasi Hangat dikurasi untuk menjawab kebutuhan praktis para kreator dan mitra. Kami percaya proses kreatif terbaik lahir dari rasa kebersamaan, dukungan komunitas, dan pendampingan berkelanjutan.</p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="reveal rounded-3xl bg-[#FFF6EF] p-8 shadow-sm ring-1 ring-white" style="--reveal-delay: 140ms;">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-amber-400">Visi Kami</p>
                        <p class="mt-4 text-base text-slate-700 leading-relaxed">Menjadi ruang aman bagi talenta kreatif untuk bertumbuh bersama, saling berbagi praktik terbaik, dan menghasilkan karya yang berdampak.</p>
                    </div>
                    <div class="reveal rounded-3xl bg-[#EEF2FF] p-8 shadow-sm ring-1 ring-white" style="--reveal-delay: 200ms;">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-indigo-400">Misi Kami</p>
                        <p class="mt-4 text-base text-slate-700 leading-relaxed">Menghadirkan workshop tematik, mentoring, dan kemitraan strategis yang memberdayakan komunitas serta membuka peluang baru.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#FFF9F4]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 space-y-12">
            <div class="reveal text-center space-y-4" style="--reveal-delay: 100ms;">
                <span class="text-xs font-semibold uppercase tracking-[0.4em] text-amber-500">Nilai-Nilai Kami</span>
                <h2 class="text-3xl font-semibold text-slate-900">Budaya kolaboratif yang kami rayakan setiap hari</h2>
                <p class="text-base text-slate-600 leading-relaxed max-w-2xl mx-auto">Nilai ini menjadi dasar pengambilan keputusan kami dalam merancang pengalaman belajar yang relevan, empatik, dan berdampak untuk seluruh ekosistem.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($values as $index => $value)
                    <div class="reveal rounded-[28px] bg-white/90 p-8 shadow-md shadow-amber-100/50 ring-1 ring-white/80 transition hover:-translate-y-1 hover:shadow-lg" style="--reveal-delay: {{ 140 + ($index * 80) }}ms;">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#FF8B64] to-[#FF5E7A] text-white text-sm font-semibold">{{ $index + 1 }}</div>
                        <h3 class="mt-5 text-lg font-semibold text-slate-900">{{ $value['title'] }}</h3>
                        <p class="mt-3 text-sm text-slate-600 leading-relaxed">{{ $value['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 space-y-10">
            <div class="reveal text-center space-y-4" style="--reveal-delay: 100ms;">
                <span class="text-xs font-semibold uppercase tracking-[0.35em] text-indigo-400">Tim Instruktur Kami</span>
                <h2 class="text-3xl font-semibold text-slate-900">Berkenalan dengan wajah di balik Kreasi Hangat</h2>
                <p class="text-base text-slate-600 leading-relaxed max-w-2xl mx-auto">Mereka adalah praktisi dengan pengalaman industri dan hati yang tulus untuk berbagi. Setiap sesi didampingi secara personal dan hangat.</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($teamMembers as $index => $member)
                    <div class="reveal space-y-5 rounded-[28px] bg-[#F7F8FF] p-8 text-center shadow-sm ring-1 ring-white" style="--reveal-delay: {{ 140 + ($index * 80) }}ms;">
                        <div class="mx-auto flex h-28 w-28 items-center justify-center rounded-full bg-gradient-to-br from-[#7F9CF5] to-[#6C63FF] text-xs uppercase tracking-[0.4em] text-white">Foto</div>
                        <div class="space-y-2">
                            <p class="text-base font-semibold text-slate-900">{{ $member['name'] }}</p>
                            <p class="text-xs uppercase tracking-[0.3em] text-indigo-400">{{ $member['role'] }}</p>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed">Memimpin sesi dengan pendekatan yang membumi, mendorong peserta bereksperimen dan berjejaring.</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-[#FF8B64] via-[#FF5E7A] to-[#7F9CF5]"></div>
        <div class="relative">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="reveal grid gap-10 lg:grid-cols-[1.1fr,0.9fr] items-center text-white" style="--reveal-delay: 120ms;">
                    <div class="space-y-6">
                        <span class="inline-flex items-center rounded-full bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.35em]">Hubungi Kami</span>
                        <h2 class="text-3xl font-semibold leading-snug">Mari rancang kolaborasi hangat bersama tim Kreasi Hangat</h2>
                        <p class="text-base leading-relaxed text-white/80">Tim kami siap mendengarkan kebutuhan komunitas maupun brand Anda. Sampaikan rencana program, kami bantu wujudkan dengan pendekatan yang terkurasi.</p>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="rounded-3xl bg-white/10 p-6 shadow-lg">
                            <p class="text-sm uppercase tracking-[0.3em] text-white/80">Studio</p>
                            <p class="mt-3 text-base font-semibold">Kreasi Hangat</p>
                            <p class="mt-2 text-sm text-white/80 leading-relaxed">Jl. Bahagia No. 12, Bandung<br>Jawa Barat, Indonesia</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-6 shadow-lg">
                            <p class="text-sm uppercase tracking-[0.3em] text-white/80">Kontak</p>
                            <p class="mt-3 text-base font-semibold">hello@kreasihangat.id</p>
                            <p class="mt-2 text-sm text-white/80">+62 812-1234-5678</p>
                        </div>
                        <div class="sm:col-span-2 rounded-3xl bg-white/10 p-6 shadow-lg">
                            <p class="text-sm uppercase tracking-[0.3em] text-white/80">Sosial Media</p>
                            <p class="mt-3 text-base font-semibold">Instagram &bull; TikTok &bull; YouTube</p>
                            <p class="mt-2 text-sm text-white/80">Ikuti perjalanan kami dalam menghangatkan industri kreatif.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
