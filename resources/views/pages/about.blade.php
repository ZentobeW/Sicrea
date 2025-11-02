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
    <section class="bg-white border-b border-slate-200/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid gap-12 lg:grid-cols-[1.2fr,0.9fr] items-center reveal" style="--reveal-delay: 0ms;">
                <div class="space-y-6">
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-slate-600">About Us</span>
                    <h1 class="text-4xl md:text-5xl font-semibold text-slate-900 leading-tight">Merancang Ekosistem Kreatif yang Inklusif</h1>
                    <p class="text-base md:text-lg text-slate-600 leading-relaxed">Sicrea adalah studio kreatif yang memfasilitasi kolaborasi lintas disiplin. Kami menghubungkan praktisi, komunitas, dan brand untuk menciptakan program yang relevan dan berdampak.</p>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white/60 p-4 shadow-sm">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-slate-900 text-white text-base font-semibold">{{ $formatStat($stats['published_events']) }}</div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Program Tahunan</p>
                                <p class="text-sm font-medium text-slate-700">Kolaborasi kurasi mentor ahli</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white/60 p-4 shadow-sm">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-slate-900 text-white text-base font-semibold">{{ $formatStat($stats['confirmed_participants']) }}</div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Alumni Aktif</p>
                                <p class="text-sm font-medium text-slate-700">Terlibat di ekosistem kreatif</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-700 transition">Lihat Agenda</a>
                        <a href="{{ route('partnership.index') }}" class="inline-flex items-center rounded-full border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 hover:border-indigo-600 hover:text-indigo-600 transition">Kemitraan</a>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/3] rounded-3xl bg-slate-200 flex items-center justify-center text-xs uppercase tracking-[0.4em] text-slate-400">Foto Studio</div>
                    <div class="floating-card absolute -bottom-8 -right-6 w-48 rounded-3xl border border-white bg-white/90 p-5 shadow-xl backdrop-blur">
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Highlight</p>
                        <p class="mt-2 text-sm font-semibold text-slate-800">Kolaborasi lintas kota dan komunitas kreatif Indonesia.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 space-y-12">
            <div class="reveal text-center max-w-3xl mx-auto space-y-4" style="--reveal-delay: 120ms;">
                <span class="text-xs font-semibold uppercase tracking-[0.4em] text-slate-500">Visi Misi</span>
                <h2 class="text-3xl font-semibold text-slate-900">Menyalakan ekosistem kreatif yang berkelanjutan</h2>
                <p class="text-base text-slate-600 leading-relaxed">Kami memfasilitasi proses belajar yang relevan, membangun jejaring kolaborasi, dan menyediakan akses terhadap sumber daya sehingga setiap talenta dapat bertumbuh.</p>
            </div>

            <div class="reveal space-y-8" style="--reveal-delay: 200ms;">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <span class="text-xs font-semibold uppercase tracking-[0.4em] text-slate-500">Core Value</span>
                    <p class="text-sm text-slate-500">Nilai yang kami pegang dalam merancang setiap program.</p>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($values as $value)
                        <div class="rounded-3xl border border-slate-200 bg-white/70 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                            <h3 class="text-lg font-semibold text-slate-900">{{ $value['title'] }}</h3>
                            <p class="mt-3 text-sm text-slate-600 leading-relaxed">{{ $value['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 space-y-8">
            <div class="reveal flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between" style="--reveal-delay: 120ms;">
                <span class="text-xs font-semibold uppercase tracking-[0.4em] text-slate-500">Struktur Tim</span>
                <p class="text-sm text-slate-500">Tim inti yang mengawal perjalanan program Sicrea.</p>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($teamMembers as $index => $member)
                    <div class="reveal space-y-3 text-center" style="--reveal-delay: {{ 160 + ($index * 80) }}ms;">
                        <div class="aspect-[3/4] rounded-3xl bg-slate-200 flex items-center justify-center text-xs uppercase tracking-[0.4em] text-slate-400">Foto {{ $member['name'] }}</div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ $member['name'] }}</p>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-500">{{ $member['role'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
