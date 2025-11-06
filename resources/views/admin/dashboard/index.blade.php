<x-layouts.admin title="Dashboard Admin" subtitle="Selamat datang kembali! Berikut ringkasan aktivitas mingguan platform Anda.">
    <x-slot name="actions">
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-semibold text-[#6B3021] shadow-lg shadow-[#FFB59F]/40 transition hover:-translate-y-0.5 hover:bg-[#FFEFE9]">
            <span class="text-lg">＋</span>
            Tambah Event Baru
        </a>
    </x-slot>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl bg-white/90 p-6 shadow-[0_25px_60px_-30px_rgba(240,128,128,0.55)]">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#F0896D]">Event Aktif</p>
            <p class="mt-3 text-3xl font-semibold text-[#5A291B]">{{ $metrics['activeEvents'] }}</p>
            <p class="mt-1 text-sm text-[#9C5A45]">Event yang sedang tayang untuk publik.</p>
        </div>
        <div class="rounded-3xl bg-[#FFF4EB] p-6 shadow-[0_25px_60px_-30px_rgba(249,170,121,0.65)]">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#F3A15E]">Total Peserta</p>
            <p class="mt-3 text-3xl font-semibold text-[#5A291B]">{{ $metrics['totalParticipants'] }}</p>
            <p class="mt-1 text-sm text-[#9C5A45]">Akumulasi peserta dari seluruh event.</p>
        </div>
        <div class="rounded-3xl bg-[#FFE6DC] p-6 shadow-[0_25px_60px_-30px_rgba(235,133,96,0.5)]">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#E77758]">Pendapatan</p>
            <p class="mt-3 text-3xl font-semibold text-[#5A291B]">Rp{{ number_format($metrics['totalRevenue'], 0, ',', '.') }}</p>
            <p class="mt-1 text-sm text-[#9C5A45]">Total pembayaran terverifikasi.</p>
        </div>
        <div class="rounded-3xl bg-white/90 p-6 shadow-[0_25px_60px_-30px_rgba(214,119,101,0.45)]">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#D96953]">Terkonfirmasi</p>
            <p class="mt-3 text-3xl font-semibold text-[#5A291B]">{{ $metrics['confirmedRegistrations'] }}</p>
            <p class="mt-1 text-sm text-[#9C5A45]">Peserta dengan status pembayaran sah.</p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.2fr_1fr]">
        <div class="rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(240,128,128,0.65)]">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-[#5A291B]">Pendaftaran Terbaru</h2>
                    <p class="text-sm text-[#A35C45]">Tinjau peserta yang baru saja mendaftar.</p>
                </div>
                <a href="{{ route('admin.registrations.index') }}" class="text-sm font-semibold text-[#E57255] hover:text-[#C9573D]">Lihat Semua</a>
            </div>
            <div class="mt-6 space-y-4">
                @forelse ($recentRegistrations as $registration)
                    <div class="flex items-start justify-between rounded-2xl bg-[#FFF6F1] px-4 py-3">
                        <div>
                            <p class="text-sm font-semibold text-[#5A291B]">{{ $registration->user->name }}</p>
                            <p class="text-xs text-[#A35C45]">{{ $registration->event->title }}</p>
                        </div>
                        <div class="text-right text-xs text-[#A35C45]">
                            <p>{{ optional($registration->registered_at ?? $registration->created_at)->translatedFormat('d M Y') }}</p>
                            <p class="font-semibold text-[#E57255]">{{ $registration->payment_status->label() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl bg-[#FFF1EA] px-4 py-6 text-center text-sm text-[#A35C45]">
                        Belum ada pendaftaran terbaru.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-3xl bg-[#FFF4EB] p-6 shadow-[0_35px_90px_-45px_rgba(234,140,101,0.6)]">
            <h2 class="text-lg font-semibold text-[#5A291B]">Event Mendatang</h2>
            <p class="text-sm text-[#A35C45]">Siapkan materi dan promosi untuk jadwal berikut.</p>
            <div class="mt-6 space-y-4">
                @forelse ($upcomingEvents as $event)
                    <div class="rounded-2xl bg-white/80 px-4 py-3">
                        <p class="text-sm font-semibold text-[#5A291B]">{{ $event->title }}</p>
                        <p class="text-xs text-[#A35C45]">{{ $event->start_at->translatedFormat('d M Y, H:i') }}</p>
                        <p class="mt-1 text-xs text-[#D16A54] flex items-center gap-1">📍 {{ $event->location }}</p>
                    </div>
                @empty
                    <div class="rounded-2xl bg-white/70 px-4 py-6 text-center text-sm text-[#A35C45]">
                        Belum ada event yang akan datang.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(234,140,101,0.6)]">
        <h2 class="text-lg font-semibold text-[#5A291B]">Aksi Cepat</h2>
        <p class="text-sm text-[#A35C45]">Akses tugas rutin hanya dengan satu klik.</p>
        <div class="mt-6 grid gap-4 md:grid-cols-3">
            @foreach ($quickActions as $action)
                <a href="{{ $action['route'] }}" class="group flex h-full flex-col justify-between rounded-3xl bg-[#FFF4EF] p-5 text-left transition hover:-translate-y-1 hover:shadow-[0_25px_60px_-30px_rgba(255,159,128,0.55)]">
                    <div>
                        <p class="text-sm font-semibold text-[#5A291B]">{{ $action['label'] }}</p>
                        <p class="mt-2 text-xs text-[#A35C45] leading-relaxed">{{ $action['description'] }}</p>
                    </div>
                    <span class="mt-4 inline-flex items-center gap-2 text-xs font-semibold text-[#E57255]">Mulai ↗</span>
                </a>
            @endforeach
        </div>
    </div>
</x-layouts.admin>
