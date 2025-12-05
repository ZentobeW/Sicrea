@php
    $formatCurrency = fn ($value) => 'Rp ' . number_format($value ?? 0, 0, ',', '.');

    $reportLink = function (string $type) use ($selectedEventId) {
        return route('admin.reports.index', array_filter([
            'event_id' => $selectedEventId,
            'report' => $type,
        ], fn ($value) => filled($value)));
    };
@endphp

<x-layouts.admin
    title="Laporan & Analitik"
    subtitle="Tampilan laporan peserta atau keuangan akan muncul dari aksi pada halaman Kelola Event."
>
    <x-slot name="actions">
        <a href="{{ route('admin.events.index') }}" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-5 py-3 text-sm font-semibold text-[#FAF8F1] shadow-lg shadow-[#822021]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70 hover:text-[#FAF8F1]">
            ← Kembali ke Event
        </a>
    </x-slot>
    <div class="space-y-8">
        @if (! $selectedEvent)
            <div class="rounded-[32px] border border-dashed border-[#FFD1BE] bg-white/70 p-10 text-center text-[#822021] shadow-sm shadow-[#FFBFA8]/30">
                <p class="text-sm font-semibold tracking-[0.3em] uppercase text-[#822021]">Tidak ada event dipilih</p>
                <h2 class="mt-3 text-2xl font-semibold text-[#822021]">Buka laporan dari Kelola Event</h2>
                <p class="mt-2 text-base text-[#822021]">
                    Silakan kembali ke halaman Kelola Event lalu gunakan aksi
                    <span class="font-semibold">Laporan Peserta</span> atau <span class="font-semibold">Laporan Keuangan</span>
                    pada event yang ingin dianalisis.
                </p>
                <a
                    href="{{ route('admin.events.index') }}"
                    class="mt-6 inline-flex items-center gap-2 rounded-full bg-[#822021] px-6 py-3 text-sm font-semibold text-[#FAF8F1] shadow-lg shadow-[#B49F9A]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70"
                >
                    Kembali ke Kelola Event
                </a>
            </div>
        @else
            <div class="rounded-[36px] border border-[#FFD1BE] bg-white/95 p-8 shadow-lg shadow-[#FFBFA8]/40">
                <div class="flex flex-col gap-6 text-[#822021] lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.4em] text-[#822021]">{{ $selectedEvent->title }}</p>
                        <h2 class="mt-2 text-3xl font-semibold text-[#822021]">{{ $selectedEvent->title }}</h2>
                        <dl class="mt-4 space-y-2 text-base text-[#822021]">
                            <div>
                                <dt class="font-semibold text-[#822021]">Jadwal</dt>
                                <dd>{{ optional($selectedEvent->start_at)->translatedFormat('d M Y H:i') ?? 'Belum dijadwalkan' }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-[#822021]">Venue</dt>
                                <dd>
                                    <span class="font-semibold">{{ $selectedEvent->venue_name }}</span><br>
                                    <span class="text-sm">{{ $selectedEvent->venue_address }}</span>
                                </dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-[#822021]">Pemateri</dt>
                                <dd>{{ $selectedEvent->tutor_name }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div class="space-y-3 rounded-[26px] border border-[#FFE3D2] bg-[#FCF5E6] p-4">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#822021]">Jenis laporan</p>
                        <div class="flex flex-wrap gap-3">
                            <a
                                href="{{ $reportLink('participants') }}"
                                @class([
                                    'inline-flex flex-1 items-center justify-center gap-2 rounded-full px-4 py-2 text-base font-semibold transition',
                                    'bg-[#822021] text-[#FCF5E6] shadow-md shadow-[#FFBFA8]/40' => $reportType === 'participants',
                                    'bg-white text-[#822021] hover:bg-[#822021] hover:text-[#FCF5E6]' => $reportType !== 'participants',
                                ])
                            >
                                <x-heroicon-o-user-group class="h-5 w-5" />
                                Peserta
                            </a>
                            <a
                                href="{{ $reportLink('finance') }}"
                                @class([
                                    'inline-flex flex-1 items-center justify-center gap-2 rounded-full px-4 py-2 text-base font-semibold transition',
                                    'bg-[#822021] text-[#FCF5E6] shadow-md shadow-[#FFBFA8]/40' => $reportType === 'finance',
                                    'bg-white text-[#822021] hover:bg-[#822021] hover:text-[#FCF5E6]' => $reportType !== 'finance',
                                ])
                            >
                                <x-heroicon-o-credit-card class="h-5 w-5" />
                                Keuangan
                            </a>
                        </div>
                        <p class="text-base text-[#822021]">Gunakan tautan di atas bila ingin berpindah jenis laporan.</p>
                    </div>
                </div>
            </div>

            @if ($reportType === 'participants')
                <div class="space-y-8">
                    <div class="grid gap-4 text-[#822021] sm:grid-cols-2 xl:grid-cols-4">
                        <div class="rounded-3xl bg-white p-6 shadow-md transition hover:bg-[#822021] hover:shadow-lg cursor-pointer group">
                            <p class="text-sm font-semibold uppercase tracking-wide text-[#822021] group-hover:text-[#FCF5E6]">Total Registrasi</p>
                            <p class="mt-3 text-4xl font-semibold text-[#822021] group-hover:text-[#FCF5E6]">{{ $participantMetrics['total'] }}</p>
                        </div>
                        <div class="rounded-3xl bg-white p-6 shadow-md transition hover:bg-[#822021] hover:shadow-lg cursor-pointer group">
                            <p class="text-sm font-semibold uppercase tracking-wide text-[#822021] group-hover:text-[#FCF5E6]">Terverifikasi</p>
                            <p class="mt-3 text-4xl font-semibold text-[#822021] group-hover:text-[#FCF5E6]">{{ $participantMetrics['confirmed'] }}</p>
                            <p class="mt-1 text-base text-[#822021] group-hover:text-[#FCF5E6]">Peserta siap hadir.</p>
                        </div>
                        <div class="rounded-3xl bg-white p-6 shadow-md transition hover:bg-[#822021] hover:shadow-lg cursor-pointer group">
                            <p class="text-sm font-semibold uppercase tracking-wide text-[#822021] group-hover:text-[#FCF5E6]">Pending Pembayaran</p>
                            <p class="mt-3 text-4xl font-semibold text-[#822021] group-hover:text-[#FCF5E6]">{{ $participantMetrics['pending'] }}</p>
                        </div>
                        <div class="rounded-3xl bg-white p-6 shadow-md transition hover:bg-[#822021] hover:shadow-lg cursor-pointer group">
                            <p class="text-sm font-semibold uppercase tracking-wide text-[#822021] group-hover:text-[#FCF5E6]">Permintaan Refund</p>
                            <p class="mt-3 text-4xl font-semibold text-[#822021] group-hover:text-[#FCF5E6]">{{ $participantMetrics['refund_requests'] }}</p>
                        </div>
                    </div>

                    <div class="rounded-[30px] border border-[#FFE3D2] bg-[#FCF5E6] p-6 shadow-inner">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-[#822021]">Registrasi Terbaru</h3>
                                <p class="text-base text-[#822021]">Gunakan data berikut sebagai dasar follow up peserta.</p>
                            </div>
                            <a href="{{ route('admin.registrations.index', array_filter(['event_id' => $selectedEventId], fn ($value) => filled($value))) }}" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-4 py-2 text-xs font-semibold text-[#FAF8F1] shadow-md shadow-[#B49F9A]/30 transition hover:bg-[#822021]/70">
                                Lihat Semua Peserta
                            </a>
                        </div>

                        <div class="mt-5 space-y-3">
                            @forelse ($recentRegistrations as $registration)
                                @php($transaction = $registration->transaction)
                                <div class="flex flex-col gap-3 rounded-3xl border border-[#FFE3D2] bg-white/90 p-4 text-base text-[#822021] shadow-sm transition hover:bg-[#822021] hover:text-[#FCF5E6] sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="font-semibold">{{ $registration->user->name }}</p>
                                        <p class="text-sm">{{ $registration->user->email }}</p>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2 text-sm">
                                        <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF5EF] px-3 py-1 font-semibold text-[#822021]">
                                            {{ $registration->status->label() }}
                                        </span>
                                        <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF5EF] px-3 py-1 font-semibold text-[#822021]">
                                            {{ $transaction?->status->label() ?? 'Tidak ada data' }}
                                        </span>
                                        <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF5EF] px-3 py-1 font-semibold text-[#822021]">
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
                <div class="space-y-8 text-[#822021]">
                    <div class="rounded-[32px] bg-[#FCF5E6] p-8 shadow-lg shadow-[#FFBFA8]/40">
                        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.35em] text-[#822021]">Ringkasan Keuangan Event</p>
                                <h3 class="mt-2 text-2xl font-semibold text-[#822021]">{{ $selectedEvent->title }}</h3>
                                <p class="mt-2 text-base text-[#822021]">
                                    Tanggal {{ optional($selectedEvent->start_at)->translatedFormat('d M Y H:i') ?? 'Belum dijadwalkan' }}
                                    · Venue {{ $selectedEvent->venue_name }}
                                </p>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                                <div class="rounded-2xl bg-white/90 p-4 text-center shadow-sm transition hover:bg-[#822021] hover:text-[#FCF5E6] hover:shadow-lg cursor-pointer">
                                    <p class="text-sm font-semibold uppercase tracking-wide">Target</p>
                                    <p class="mt-2 text-xl font-semibold">{{ $formatCurrency($financialMetrics['target']) }}</p>
                                </div>
                                <div class="rounded-2xl bg-white/90 p-4 text-center shadow-sm transition hover:bg-[#822021] hover:text-[#FCF5E6] hover:shadow-lg cursor-pointer">
                                    <p class="text-sm font-semibold uppercase tracking-wide">Diterima</p>
                                    <p class="mt-2 text-xl font-semibold">{{ $formatCurrency($financialMetrics['received']) }}</p>
                                </div>
                                <div class="rounded-2xl bg-white/90 p-4 text-center shadow-sm transition hover:bg-[#822021] hover:text-[#FCF5E6] hover:shadow-lg cursor-pointer">
                                    <p class="text-sm font-semibold uppercase tracking-wide">Menunggu</p>
                                    <p class="mt-2 text-xl font-semibold">{{ $formatCurrency($financialMetrics['pending']) }}</p>
                                </div>
                                <div class="rounded-2xl bg-white/90 p-4 text-center shadow-sm transition hover:bg-[#822021] hover:text-[#FCF5E6] hover:shadow-lg cursor-pointer">
                                    <p class="text-sm font-semibold uppercase tracking-wide">Potensi Refund</p>
                                    <p class="mt-2 text-xl font-semibold">{{ $formatCurrency($financialMetrics['refunded']) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-6 xl:grid-cols-2">
                        <div class="rounded-[30px] border border-[#FFD1BE] bg-[#FAF8F1]/95 p-6 shadow-lg shadow-[#FFBFA8]/30">
                            <div class="flex flex-col gap-2">
                                <p class="text-sm font-semibold uppercase tracking-[0.4em] text-[#822021]">Laporan Keuangan Per Event</p>
                                <h3 class="text-xl font-semibold text-[#822021]">Rekap pemasukan {{ $selectedEvent->title }}</h3>
                                <p class="text-base text-[#822021]">Unduh file keuangan dan kirimkan ke tim finance untuk proses rekonsiliasi.</p>
                            </div>

                            <div class="mt-6 space-y-4">
                                <div class="flex items-center justify-between rounded-2xl bg-white px-4 py-3 text-base text-[#822021] transition hover:bg-[#822021] hover:text-[#FCF5E6] hover:shadow-md cursor-pointer">
                                    <span class="font-semibold">Total Pembayaran Diterima</span>
                                    <span>{{ $formatCurrency($financialMetrics['received']) }}</span>
                                </div>
                                <div class="flex items-center justify-between rounded-2xl bg-white px-4 py-3 text-base text-[#822021] transition hover:bg-[#822021] hover:text-[#FCF5E6] hover:shadow-md cursor-pointer">
                                    <span class="font-semibold">Outstanding Pembayaran</span>
                                    <span>{{ $formatCurrency($financialMetrics['pending']) }}</span>
                                </div>
                            </div>

                            <div class="mt-6 flex flex-wrap items-center gap-3">
                                <a
                                    href="{{ route('admin.registrations.export', array_filter(['event_id' => $selectedEventId, 'report' => 'finance'], fn ($value) => filled($value))) }}"
                                    class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-5 py-2 text-sm font-semibold text-[#FAF8F1] shadow-md shadow-[#B49F9A]/30 transition hover:bg-[#822021]/70"
                                >
                                    ⇩ Unduh Laporan
                                </a>
                                <a
                                    href="{{ route('admin.registrations.index', array_filter(['event_id' => $selectedEventId], fn ($value) => filled($value))) }}"
                                    class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-5 py-2 text-xs font-semibold text-[#FAF8F1] shadow-md shadow-[#B49F9A]/30 transition hover:bg-[#822021]/70"
                                >
                                    Kelola Transaksi
                                </a>
                            </div>
                        </div>

                        <div class="rounded-[30px] border border-[#FFD1BE] bg-[#FCF5E6] p-6 shadow-inner">
                            <p class="text-sm font-semibold uppercase tracking-[0.4em] text-[#822021]">Laporan Keuangan Akumulasi</p>
                            <h3 class="mt-2 text-xl font-semibold text-[#822021]">Status pembayaran & refund</h3>
                            <p class="mt-1 text-base text-[#822021]">Gunakan ringkasan berikut untuk menilai kesehatan kas dan tindak lanjut peserta.</p>

                            <div class="mt-6 space-y-4">
                                @forelse ($paymentBreakdown as $breakdown)
                                    <div class="flex items-center justify-between rounded-2xl bg-white px-4 py-3 text-base text-[#822021] shadow-sm transition hover:bg-[#822021] hover:text-[#FCF5E6] hover:shadow-md cursor-pointer">
                                        <div>
                                            <p class="font-semibold">{{ $breakdown['status']->label() }}</p>
                                            <p class="text-sm">{{ $breakdown['count'] }} transaksi</p>
                                        </div>
                                        <span class="font-semibold">{{ $formatCurrency($breakdown['sum']) }}</span>
                                    </div>
                                @empty
                                    <div class="rounded-3xl border border-dashed border-[#FFD1BE] bg-white/80 p-6 text-center text-base text-[#822021]">
                                        Belum ada transaksi yang tercatat untuk event ini.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="rounded-[28px] border border-[#FFE3D2] bg-[#FCF5E6] p-5 text-base text-[#822021] shadow-inner">
                <p class="font-semibold text-[#822021]">Tips cepat</p>
                <p class="mt-2 text-[#822021]">Gunakan laporan peserta untuk membuat daftar hadir, dan laporan keuangan untuk rekonsiliasi pembayaran.</p>
            </div>
        @endif
    </div>
</x-layouts.admin>
