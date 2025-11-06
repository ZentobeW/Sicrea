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

        .partnership-visual {
            border-radius: 1.5rem;
            background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%);
            border: 1px solid rgba(148, 163, 184, 0.35);
            animation: floatPulse 5s ease-in-out infinite;
        }

        .partnership-benefit::before,
        .partnership-support::before {
            content: '';
            display: block;
            width: 100%;
            aspect-ratio: 4 / 3;
            border-radius: 1rem;
            background: #e2e8f0;
            margin-bottom: 1.25rem;
        }

        .partnership-support::before {
            aspect-ratio: 16 / 9;
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

<x-layouts.app :title="'Kemitraan Sicrea'">
    <section class="bg-white border-b border-slate-200/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid gap-12 lg:grid-cols-[1.1fr,0.9fr] items-center">
                <div class="space-y-6 reveal" style="--reveal-delay: 0ms;">
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-slate-600">Partnership</span>
                    <h1 class="text-4xl md:text-5xl font-semibold text-slate-900 leading-tight">Bangun Kolaborasi yang Relevan &amp; Berdampak</h1>
                    <p class="text-base md:text-lg text-slate-600 leading-relaxed">Kami membantu brand dan komunitas merancang pengalaman yang bermakna. Dari kurasi konsep hingga produksi end-to-end, semua disiapkan untuk audiensmu.</p>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="mailto:hello@sicrea.id" class="inline-flex items-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 hover:bg-slate-700 transition">Hubungi Project Manager</a>
                        <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-full border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 hover:border-indigo-600 hover:text-indigo-600 transition">Lihat Agenda Program</a>
                    </div>
                </div>
                <div class="reveal lg:justify-self-end w-full max-w-xl" style="--reveal-delay: 140ms;">
                    <div class="partnership-visual aspect-[4/3] flex items-center justify-center text-slate-400 text-sm font-semibold tracking-[0.4em] uppercase">Image Placeholder</div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 space-y-16">
            <div class="space-y-3 reveal" style="--reveal-delay: 80ms;">
                <span class="text-xs font-semibold uppercase tracking-[0.4em] text-slate-500">Benefit</span>
                <h2 class="text-3xl font-semibold text-slate-900">Mengapa Bermitra dengan Sicrea?</h2>
                <p class="text-sm text-slate-500 max-w-2xl">Tim kami siap mendampingi dari tahap riset hingga aktivasi multi kanal sehingga pengalaman audiens terasa konsisten.</p>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($partnershipBenefits as $index => $benefit)
                    <div class="reveal partnership-benefit rounded-3xl border border-slate-200 bg-white p-6" style="--reveal-delay: {{ 120 + ($index * 80) }}ms;">
                        <h3 class="text-lg font-semibold text-slate-900">{{ $benefit['title'] }}</h3>
                        <p class="mt-3 text-sm text-slate-600 leading-relaxed">{{ $benefit['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 space-y-12">
            <div class="space-y-2 reveal" style="--reveal-delay: 80ms;">
                <h2 class="text-3xl font-semibold text-slate-900">Format Kolaborasi Populer</h2>
                <p class="text-sm text-slate-500 max-w-2xl">Pilih format yang paling sesuai dengan objektifmu atau diskusikan opsi khusus dengan tim kami.</p>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($partnershipSupports as $index => $support)
                    <div class="reveal partnership-support rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-6" style="--reveal-delay: {{ 140 + ($index * 80) }}ms;">
                        <h3 class="text-lg font-semibold text-slate-900">{{ $support['title'] }}</h3>
                        <p class="mt-3 text-sm text-slate-600 leading-relaxed">{{ $support['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
