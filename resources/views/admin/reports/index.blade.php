@php
    $tabOptions = [
        ['key' => 'participants', 'label' => 'Laporan Peserta'],
        ['key' => 'finance', 'label' => 'Laporan Keuangan'],
    ];

    $queryFor = function (?int $eventId, ?string $tabValue = null) use ($tab) {
        return array_filter([
            'event_id' => $eventId,
            'tab' => $tabValue ?? $tab,
        ], fn ($value) => filled($value));
    };

    $formatCurrency = fn ($value) => 'Rp ' . number_format($value ?? 0, 0, ',', '.');
@endphp

<x-layouts.admin
    title="Laporan & Analitik"
    subtitle="Unduh daftar peserta dan keuangan untuk event Anda. Pilih event di sebelah kiri lalu sesuaikan jenis laporan."
>
    <div class="grid gap-8 lg:grid-cols-[280px_minmax(0,1fr)]">
        <aside class="space-y-6">
            <div class="rounded-[32px] border border-[#FFD1BE] bg-white/90 p-6 shadow-lg shadow-[#FFBFA8]/30">
                <div class="flex items-center justify-between text-[#6B3021]">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#C06245]">Pilih Event</p>
                        <h2 class="mt-2 text-lg font-semibold">Daftar Workshop</h2>
                    </div>
                    <span class="rounded-full bg-[#FFE3D2] px-3 py-1 text-xs font-semibold text-[#A3563F]">{{ $events->count() }} Event</span>
                </div>

                <div class="mt-4 flex items-center justify-between text-xs">
                    <a
                        href="{{ route('admin.reports.index', $queryFor(null)) }}"
                        class="inline-flex items-center gap-2 rounded-full bg-[#FFEDE5] px-3 py-1 font-semibold text-[#A3563F] transition hover:bg-[#ffdcd0]"
                    >
                        Pilih Semua
                    </a>
                    <span class="text-[#C06245]">{{ now()->translatedFormat('d M Y') }}</span>
                </div>

                <div class="mt-6 space-y-3">
                    @forelse ($events as $event)
                        <a
                            href="{{ route('admin.reports.index', $queryFor($event->id)) }}"
                            class="group block rounded-3xl border px-4 py-4 transition @class([
                                'border-transparent bg-[#FFF5EF] shadow-inner shadow-[#FFBFA8]/30 text-[#5C2518]' => $selectedEventId === $event->id,
                                'border-[#FFE3D2] bg-white/80 text-[#874532] hover:border-[#FFBFA8] hover:bg-[#FFF1EA]' => $selectedEventId !== $event->id,
                            ])"
                        >
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="text-sm font-semibold leading-snug">{{ $event->title }}</h3>
                                    <p class="mt-1 text-xs text-[#A3563F]">{{ optional($event->start_at)->translatedFormat('d M Y') ?? 'Jadwal belum ditetapkan' }}</p>
                                    <p class="text-[11px] text-[#C06245]">{{ $event->venue_name }}</p>
                                </div>
                                <span class="rounded-full bg-[#FFE3D2] px-2.5 py-1 text-[11px] font-semibold text-[#A3563F]">{{ $event->confirmed_registrations_count }}/{{ $event->total_registrations_count }}</span>
                            </div>
                        </a>
                    @empty
                        <p class="rounded-3xl border border-dashed border-[#FFD1BE] bg-[#FFF5EF] p-6 text-sm text-[#A3563F]">
                            Belum ada event yang dapat dilaporkan.
                        </p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-[28px] border border-[#FFE3D2] bg-[#FFF5EF] p-5 text-sm text-[#874532] shadow-inner">
                <p class="font-semibold">Tips cepat</p>
                <p class="mt-2">Gunakan laporan peserta untuk membuat daftar hadir, dan laporan keuangan untuk rekonsiliasi pembayaran.</p>
            </div>
        </aside>

        <section class="space-y-6">
            <div class="rounded-[36px] border border-[#FFD1BE] bg-white/95 p-8 shadow-lg shadow-[#FFBFA8]/40">
                <div class="flex flex-col gap-4 text-[#5C2518] lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.4em] text-[#C06245]">{{ $selectedEvent?->title ?? 'Belum ada event dipilih' }}</p>
                        <h2 class="mt-2 text-2xl font-semibold">
                            @if ($selectedEvent)
                                {{ $selectedEvent->title }}
                            @else
                                Pilih event di sebelah kiri untuk mulai membuat laporan
                            @endif
                        </h2>
                        <p class="mt-2 text-sm text-[#874532]">
                            @if ($selectedEvent)
                                Jadwal: {{ optional($selectedEvent->start_at)->translatedFormat('d M Y H:i') ?? 'Belum dijadwalkan' }}
                                <br>Venue: {{ $selectedEvent->venue_name }}
                                <br><span class="text-xs">{{ $selectedEvent->venue_address }}</span>
                                <br>Pemateri: {{ $selectedEvent->tutor_name }}
                            @else
                                Anda dapat beralih antar tab untuk fokus pada peserta atau keuangan.
                            @endif
                        </p>
                    </div>
                    @if ($selectedEvent)
                        <div class="flex flex-wrap items-center gap-3">
                            <a
                                href="{{ route('admin.registrations.export', array_filter(['event_id' => $selectedEventId], fn ($value) => filled($value))) }}"
                                class="inline-flex items-center gap-2 rounded-full bg-[#FFE3D2] px-4 py-2 text-sm font-semibold text-[#A3563F] shadow"
                            >
                                ⇩ Unduh CSV
                            </a>
                            <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF5EF] px-4 py-2 text-xs font-semibold text-[#C06245]">
                                {{ $participantMetrics['confirmed'] }} peserta terkonfirmasi
                            </span>
                        </div>
                    @endif
                </div>

                <div class="mt-6 flex flex-wrap gap-3 rounded-[26px] bg-[#FFF1EA] p-2">
                    @foreach ($tabOptions as $option)
                        <a
                            href="{{ route('admin.reports.index', $queryFor($selectedEventId, $option['key'])) }}"
                            @class([
                                'inline-flex flex-1 items-center justify-center gap-2 rounded-[22px] px-4 py-3 text-sm font-semibold transition',
                                'bg-white text-[#5C2518] shadow-md shadow-[#FFBFA8]/40' => $tab === $option['key'],
                                'text-[#A3563F] hover:bg-white/70' => $tab !== $option['key'],
                            ])
                        >
                            {{ $option['label'] }}
                        </a>
                    @endforeach
                </div>

                @if ($selectedEvent)
                    @if ($tab === 'participants')
                        <div class="mt-8 space-y-8">
                            <div class="grid gap-4 text-[#5C2518] sm:grid-cols-2 xl:grid-cols-4">
                                <div class="rounded-3xl bg-[#FFF5EF] p-6 shadow-sm">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-[#C06245]">Total Registrasi</p>
                                    <p class="mt-3 text-3xl font-semibold">{{ $participantMetrics['total'] }}</p>
                                </div>
                                <div class="rounded-3xl bg-[#FFEDE5] p-6 shadow-sm">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-[#C06245]">Terverifikasi</p>
                                    <p class="mt-3 text-3xl font-semibold">{{ $participantMetrics['confirmed'] }}</p>
                                    <p class="mt-1 text-xs text-[#A3563F]">Peserta siap hadir.</p>
                                </div>
                                <div class="rounded-3xl bg-[#FFF5EF] p-6 shadow-sm">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-[#C06245]">Pending Pembayaran</p>
                                    <p class="mt-3 text-3xl font-semibold">{{ $participantMetrics['pending'] }}</p>
                                </div>
                                <div class="rounded-3xl bg-[#FFEDE5] p-6 shadow-sm">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-[#C06245]">Permintaan Refund</p>
                                    <p class="mt-3 text-3xl font-semibold">{{ $participantMetrics['refund_requests'] }}</p>
                                </div>
                            </div>

                            <div class="rounded-[30px] border border-[#FFE3D2] bg-[#FFF8F4] p-6 shadow-inner">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-[#5C2518]">Registrasi Terbaru</h3>
                                        <p class="text-sm text-[#A3563F]">Gunakan data berikut sebagai dasar follow up peserta.</p>
                                    </div>
                                    <a href="{{ route('admin.registrations.index', array_filter(['event_id' => $selectedEventId], fn ($value) => filled($value))) }}" class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-xs font-semibold text-[#A3563F] shadow">
                                        Lihat Semua
                                    </a>
                                </div>

                                <div class="mt-5 space-y-3">
                                    @forelse ($recentRegistrations as $registration)
                                        <div class="flex flex-col gap-3 rounded-3xl border border-[#FFE3D2] bg-white/90 p-4 text-sm text-[#5C2518] shadow-sm sm:flex-row sm:items-center sm:justify-between">
                                            <div>
                                                <p class="font-semibold">{{ $registration->user->name }}</p>
                                                <p class="text-xs text-[#A3563F]">{{ $registration->user->email }}</p>
                                            </div>
                                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                                <span class="inline-flex items-center gap-2 rounded-full bg-[#FFEDE5] px-3 py-1 font-semibold text-[#A3563F]">
                                                    {{ $registration->status->label() }}
                                                </span>
                                                <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF5EF] px-3 py-1 font-semibold text-[#C06245]">
                                                    {{ $registration->payment_status->label() }}
                                                </span>
                                                <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF1EA] px-3 py-1 font-semibold text-[#874532]">
                                                    {{ optional($registration->registered_at)->translatedFormat('d M Y H:i') }}
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="rounded-3xl border border-dashed border-[#FFD1BE] bg-white p-8 text-center text-[#A3563F]">
                                            Belum ada peserta yang mendaftar untuk event ini.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mt-8 space-y-8 text-[#5C2518]">
                            <div class="rounded-[32px] bg-gradient-to-br from-[#FFE6D8] via-[#FFEDE5] to-[#FFE3D2] p-8 shadow-lg shadow-[#FFBFA8]/40">
                                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#C06245]">Ringkasan Keuangan Event</p>
                                        <h3 class="mt-2 text-2xl font-semibold">{{ $selectedEvent->title }}</h3>
                                        <p class="mt-2 text-sm text-[#874532]">
                                            Tanggal {{ optional($selectedEvent->start_at)->translatedFormat('d M Y H:i') ?? 'Belum dijadwalkan' }}
                                            · Venue {{ $selectedEvent->venue_name }}
                                        </p>
                                    </div>

                                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                                        <div class="rounded-2xl bg-white/90 p-4 text-center shadow-sm">
                                            <p class="text-[11px] font-semibold uppercase tracking-wide text-[#C06245]">Target</p>
                                            <p class="mt-2 text-xl font-semibold">{{ $formatCurrency($financialMetrics['target']) }}</p>
                                        </div>
                                        <div class="rounded-2xl bg-[#FFE8DD] p-4 text-center shadow-sm">
                                            <p class="text-[11px] font-semibold uppercase tracking-wide text-[#C06245]">Diterima</p>
                                            <p class="mt-2 text-xl font-semibold">{{ $formatCurrency($financialMetrics['received']) }}</p>
                                        </div>
                                        <div class="rounded-2xl bg-white/90 p-4 text-center shadow-sm">
                                            <p class="text-[11px] font-semibold uppercase tracking-wide text-[#C06245]">Menunggu</p>
                                            <p class="mt-2 text-xl font-semibold">{{ $formatCurrency($financialMetrics['pending']) }}</p>
                                        </div>
                                        <div class="rounded-2xl bg-[#FFE8DD] p-4 text-center shadow-sm">
                                            <p class="text-[11px] font-semibold uppercase tracking-wide text-[#C06245]">Potensi Refund</p>
                                            <p class="mt-2 text-xl font-semibold">{{ $formatCurrency($financialMetrics['refunded']) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid gap-6 xl:grid-cols-2">
                                <div class="rounded-[30px] border border-[#FFD1BE] bg-white/95 p-6 shadow-lg shadow-[#FFBFA8]/30">
                                    <div class="flex flex-col gap-2">
                                        <p class="text-xs font-semibold uppercase tracking-[0.4em] text-[#C06245]">Laporan Keuangan Per Event</p>
                                        <h3 class="text-xl font-semibold">Rekap pemasukan {{ $selectedEvent->title }}</h3>
                                        <p class="text-sm text-[#874532]">Unduh file keuangan dan kirimkan ke tim finance untuk proses rekonsiliasi.</p>
                                    </div>

                                    <div class="mt-6 space-y-4">
                                        <div class="flex items-center justify-between rounded-2xl bg-[#FFF5EF] px-4 py-3 text-sm">
                                            <span class="font-semibold text-[#5C2518]">Total Pembayaran Diterima</span>
                                            <span class="text-[#A3563F]">{{ $formatCurrency($financialMetrics['received']) }}</span>
                                        </div>
                                        <div class="flex items-center justify-between rounded-2xl bg-[#FFEDE5] px-4 py-3 text-sm">
                                            <span class="font-semibold text-[#5C2518]">Outstanding Pembayaran</span>
                                            <span class="text-[#A3563F]">{{ $formatCurrency($financialMetrics['pending']) }}</span>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex flex-wrap items-center gap-3">
                                        <a
                                            href="{{ route('admin.registrations.export', array_filter(['event_id' => $selectedEventId], fn ($value) => filled($value))) }}"
                                            class="inline-flex items-center gap-2 rounded-full bg-[#FFBFA8] px-5 py-2 text-sm font-semibold text-white shadow-md shadow-[#FFBFA8]/50 transition hover:bg-[#f3a98c]"
                                        >
                                            ⇩ Unduh Laporan
                                        </a>
                                        <a
                                            href="{{ route('admin.registrations.index', array_filter(['event_id' => $selectedEventId], fn ($value) => filled($value))) }}"
                                            class="inline-flex items-center gap-2 rounded-full border border-[#FFBFA8] px-5 py-2 text-xs font-semibold text-[#A3563F] transition hover:bg-[#FFF1EA]"
                                        >
                                            Kelola Transaksi
                                        </a>
                                    </div>
                                </div>

                                <div class="rounded-[30px] border border-[#FFD1BE] bg-[#FFF5EF] p-6 shadow-inner">
                                    <p class="text-xs font-semibold uppercase tracking-[0.4em] text-[#C06245]">Laporan Keuangan Akumulasi</p>
                                    <h3 class="mt-2 text-xl font-semibold text-[#5C2518]">Status pembayaran & refund</h3>
                                    <p class="mt-1 text-sm text-[#874532]">Gunakan ringkasan berikut untuk menilai kesehatan kas dan tindak lanjut peserta.</p>

                                    <div class="mt-6 space-y-4">
                                        @forelse ($paymentBreakdown as $breakdown)
                                            <div class="flex items-center justify-between rounded-2xl bg-white px-4 py-3 text-sm shadow-sm">
                                                <div>
                                                    <p class="font-semibold text-[#5C2518]">{{ $breakdown['status']->label() }}</p>
                                                    <p class="text-xs text-[#A3563F]">{{ $breakdown['count'] }} peserta</p>
                                                </div>
                                                <span class="text-[#C06245]">{{ $formatCurrency($breakdown['sum']) }}</span>
                                            </div>
                                        @empty
                                            <div class="rounded-2xl border border-dashed border-[#FFD1BE] bg-white/80 p-6 text-center text-sm text-[#A3563F]">
                                                Belum ada transaksi untuk event ini.
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="mt-6 rounded-2xl border border-dashed border-[#FFC6AD] bg-white/70 p-5 text-xs text-[#874532]">
                                        <p class="font-semibold text-[#5C2518]">Catatan</p>
                                        <p class="mt-1">Gabungkan laporan event ini dengan laporan event lain untuk laporan keuangan bulanan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="mt-8 space-y-6">
                        <div class="rounded-[32px] border border-dashed border-[#FFD1BE] bg-gradient-to-br from-[#FFE6D8] via-[#FFEDE5] to-[#FFE3D2] p-10 text-center text-[#874532] shadow-inner">
                            <h3 class="text-2xl font-semibold text-[#5C2518]">Pilih event untuk memuat laporan</h3>
                            <p class="mt-3 text-sm">Silakan pilih salah satu workshop dari daftar di kiri untuk melihat ringkasan peserta atau keuangan.</p>
                        </div>
                        <div class="grid gap-6 lg:grid-cols-2">
                            <div class="rounded-[30px] border border-[#FFD1BE] bg-white/90 p-6 text-left text-[#5C2518] shadow-lg shadow-[#FFBFA8]/30">
                                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-[#C06245]">Laporan Peserta</p>
                                <h4 class="mt-2 text-xl font-semibold">Unduh daftar hadir & status</h4>
                                <p class="mt-2 text-sm text-[#874532]">Pilih event terlebih dahulu untuk mengakses daftar peserta lengkap dan status pembayarannya.</p>
                            </div>
                            <div class="rounded-[30px] border border-[#FFD1BE] bg-[#FFF5EF] p-6 text-left text-[#5C2518] shadow-inner">
                                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-[#C06245]">Laporan Keuangan</p>
                                <h4 class="mt-2 text-xl font-semibold">Rekap pemasukan & refund</h4>
                                <p class="mt-2 text-sm text-[#874532]">Gunakan ringkasan keuangan untuk mendukung pelaporan bulanan dan proses rekonsiliasi tim finance.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
</x-layouts.admin>
