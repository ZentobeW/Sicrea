<x-layouts.admin title="Dashboard Admin" subtitle="Selamat datang kembali! Berikut ringkasan aktivitas mingguan platform Anda.">
    <x-slot name="actions">
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-5 py-3 text-sm font-semibold text-[#FAF8F1] shadow-lg shadow-[#822021]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70 hover:text-[#FAF8F1]">
            <x-heroicon-o-plus class="h-5 w-5" />
            Tambah Event Baru
        </a>
    </x-slot>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl bg-white border border-[#FFD1BE] shadow-[0_25px_60px_-30px_rgba(180,159,154,0.4)] p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#822021]">Event Aktif</p>
            <p class="mt-3 text-3xl font-semibold text-[#822021]">{{ $metrics['activeEvents'] }}</p>
            <p class="mt-1 text-sm text-[#B49F9A]">Event yang sedang tayang untuk publik.</p>
        </div>
        <div class="rounded-3xl bg-white border border-[#FFD1BE] shadow-[0_25px_60px_-30px_rgba(180,159,154,0.4)] p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#822021]">Total Peserta</p>
            <p class="mt-3 text-3xl font-semibold text-[#822021]">{{ $metrics['totalParticipants'] }}</p>
            <p class="mt-1 text-sm text-[#B49F9A]">Akumulasi peserta dari seluruh event.</p>
        </div>
        <div class="rounded-3xl bg-white border border-[#FFD1BE] shadow-[0_25px_60px_-30px_rgba(180,159,154,0.4)] p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#822021]">Pendapatan</p>
            <p class="mt-3 text-3xl font-semibold text-[#822021]">Rp{{ number_format($metrics['totalRevenue'], 0, ',', '.') }}</p>
            <p class="mt-1 text-sm text-[#B49F9A]">Total pembayaran terverifikasi.</p>
        </div>
        <div class="rounded-3xl bg-white border border-[#FFD1BE] shadow-[0_25px_60px_-30px_rgba(180,159,154,0.4)] p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#822021]">Terkonfirmasi</p>
            <p class="mt-3 text-3xl font-semibold text-[#822021]">{{ $metrics['confirmedRegistrations'] }}</p>
            <p class="mt-1 text-sm text-[#B49F9A]">Peserta dengan status pembayaran sah.</p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.2fr_1fr]">
        <div class="rounded-3xl bg-white border border-[#FFD1BE] shadow-[0_35px_90px_-45px_rgba(180,159,154,0.3)] p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-[#822021]">Pendaftaran Terbaru</h2>
                    <p class="text-sm text-[#B49F9A]">Tinjau peserta yang baru saja mendaftar.</p>
                </div>
                <a href="{{ route('admin.registrations.index') }}" class="text-sm font-semibold text-[#822021] hover:text-[#9C5A45]">Lihat Semua</a>
            </div>
            <div class="mt-6 space-y-4">
                @forelse ($recentRegistrations as $registration)
                    @php($transaction = $registration->transaction)
                    <div class="flex items-start justify-between rounded-2xl bg-white border border-[#FFD1BE] px-4 py-3">
                        <div>
                            <p class="text-sm font-semibold text-[#822021]">{{ $registration->user->name }}</p>
                            <p class="text-xs text-[#B49F9A]">{{ $registration->event->title }}</p>
                        </div>
                        <div class="text-right text-xs text-[#B49F9A]">
                            <p>{{ optional($registration->registered_at ?? $registration->created_at)->translatedFormat('d M Y') }}</p>
                            <p class="font-semibold text-[#822021]">{{ $transaction?->status->label() ?? 'Tidak ada data' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl bg-white border border-[#FFD1BE] px-4 py-6 text-center text-sm text-[#B49F9A]">
                        Belum ada pendaftaran terbaru.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-3xl bg-white border border-[#FFD1BE] shadow-[0_35px_90px_-45px_rgba(180,159,154,0.3)] p-6">
            <h2 class="text-lg font-semibold text-[#822021]">Event Mendatang</h2>
            <p class="text-sm text-[#B49F9A]">Siapkan materi dan promosi untuk jadwal berikut.</p>
            <div class="mt-6 space-y-4">
                @forelse ($upcomingEvents as $event)
                    <div class="rounded-2xl bg-white border border-[#FFD1BE] px-4 py-3">
                        <p class="text-sm font-semibold text-[#822021]">{{ $event->title }}</p>
                        <p class="text-xs text-[#B49F9A]">{{ $event->start_at->translatedFormat('d M Y, H:i') }}</p>
                        <div class="mt-1 flex flex-col gap-1 text-xs text-[#822021]">
                            <span class="inline-flex items-center gap-1">
                                <x-heroicon-o-map-pin class="h-4 w-4" />
                                {{ $event->venue_name }}
                            </span>
                            <span>{{ $event->venue_address }}</span>
                            <span class="text-[11px] text-[#B49F9A]">Tutor: {{ $event->tutor_name }}</span>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl bg-white border border-[#FFD1BE] px-4 py-6 text-center text-sm text-[#B49F9A]">
                        Belum ada event yang akan datang.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="rounded-3xl bg-white border border-[#FFD1BE] shadow-[0_35px_90px_-45px_rgba(180,159,154,0.3)] p-6">
        <h2 class="text-lg font-semibold text-[#822021]">Aksi Cepat</h2>
        <p class="text-sm text-[#B49F9A]">Akses tugas rutin hanya dengan satu klik.</p>
        <div class="mt-6 grid gap-4 md:grid-cols-3">
            @foreach ($quickActions as $action)
                <a href="{{ $action['route'] }}" class="group flex h-full flex-col justify-between rounded-3xl bg-white border border-[#FFD1BE] shadow-[0_25px_60px_-30px_rgba(180,159,154,0.3)] p-5 text-left transition hover:-translate-y-1 hover:shadow-[0_25px_60px_-30px_rgba(180,159,154,0.5)]">
                    <div>
                        <p class="text-sm font-semibold text-[#822021]">{{ $action['label'] }}</p>
                        <p class="mt-2 text-xs text-[#B49F9A] leading-relaxed">{{ $action['description'] }}</p>
                    </div>
                    <span class="mt-4 inline-flex items-center gap-2 text-xs font-semibold text-[#822021]">
                        Mulai
                        <x-heroicon-o-arrow-up-right class="h-4 w-4" />
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</x-layouts.admin>
