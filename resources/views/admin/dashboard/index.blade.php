<x-layouts.admin title="Dashboard Admin" subtitle="Selamat datang kembali! Berikut ringkasan aktivitas mingguan platform Anda.">
    <x-slot name="actions">
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-5 py-3 text-sm font-semibold text-[#FAF8F1] shadow-lg shadow-[#822021]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70 hover:text-[#FAF8F1]">
            <x-heroicon-o-plus class="h-5 w-5" />
            Tambah Event Baru
        </a>
    </x-slot>

    {{-- KONTEN UTAMA DIBUNGKUS ALPINE JS UNTUK MODAL --}}
    <div x-data="{ 
        showModal: false, 
        type: '', 
        data: {}, 
        notes: '',
        openModal(item, itemType) {
            this.data = item;
            this.type = itemType;
            this.notes = '';
            this.showModal = true;
        },
        actionRoute(action) {
            if (this.type === 'payment') {
                return action === 'approve' 
                    ? '{{ url('admin/registrations') }}/' + this.data.id + '/verify-payment' 
                    : '{{ url('admin/registrations') }}/' + this.data.id + '/reject-payment';
            } else if (this.type === 'refund') {
                return action === 'approve' 
                    ? '{{ url('admin/refunds') }}/' + this.data.id + '/approve' 
                    : '{{ url('admin/refunds') }}/' + this.data.id + '/reject';
            }
            return '#';
        },
        submitAction(action) {
            const form = document.getElementById('modal-form-' + action);
            if (form) {
                // Tambahkan field notes ke form sebelum submit
                const notesInput = document.createElement('input');
                notesInput.type = 'hidden';
                notesInput.name = 'admin_note';
                notesInput.value = this.notes;
                form.appendChild(notesInput);
                
                form.submit();
            }
        }
    }"></div>

    {{-- METRICS CARD --}}
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

    {{-- VERIFIKASI & REFUND --}}
    <div class="grid gap-6 xl:grid-cols-[1.2fr_1fr] mt-6">
        {{-- Section 1: Pendaftar Menunggu Verifikasi Pembayaran --}}
        <div class="rounded-3xl bg-white border border-[#FFD1BE] shadow-[0_35px_90px_-45px_rgba(180,159,154,0.3)] p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-[#822021]">Menunggu Verifikasi Pembayaran</h2>
                    <p class="text-sm text-[#B49F9A]">Peserta terbaru yang telah mengunggah bukti bayar.</p>
                </div>
                <a href="{{ route('admin.registrations.index', ['payment_status' => 'awaiting_verification']) }}" class="text-sm font-semibold text-[#822021] hover:text-[#9C5A45]">Lihat Semua ({{ $awaitingVerification->count() }})</a>
            </div>

            <div class="mt-6 space-y-4">
                @forelse ($awaitingVerification as $registration)
                    {{-- Arahkan ke halaman detail transaksi untuk verifikasi --}}
                    <a href="{{ route('admin.registrations.show', $registration) }}" class="flex items-center justify-between rounded-2xl border border-[#FFD1BE] bg-white px-4 py-3 transition hover:bg-[#FFF5F0] hover:shadow-sm group">
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-[#822021] group-hover:text-[#E77B5F]">{{ $registration->user->name }}</p>
                            <p class="text-xs text-[#B49F9A]">{{ $registration->event->title }}</p>
                        </div>
                        <div class="text-right text-xs text-[#B49F9A] mr-4 min-w-[80px]">
                            <p>{{ optional($registration->registered_at)->translatedFormat('d M Y') }}</p>
                            <p class="font-semibold text-[#822021]">Rp{{ number_format($registration->transaction->amount, 0, ',', '.') }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-[#822021] min-w-[70px] justify-end">
                             Detail & Aksi
                            <x-heroicon-o-arrow-up-right class="h-4 w-4" />
                        </span>
                    </a>
                @empty
                    <div class="rounded-2xl border border-dashed border-[#FFD1BE] px-4 py-6 text-center text-sm text-[#B49F9A]">
                        Tidak ada pendaftaran menunggu verifikasi.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Section 2: Permintaan Refund Pending --}}
        <div class="rounded-3xl bg-white border border-[#FFD1BE] shadow-[0_35px_90px_-45px_rgba(180,159,154,0.3)] p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-[#822021]">Permintaan Refund Pending</h2>
                    <p class="text-sm text-[#B49F9A]">Pengajuan yang perlu segera ditinjau dan diproses.</p>
                </div>
                <a href="{{ route('admin.registrations.index', ['view' => 'refunds', 'refund_status' => 'pending']) }}" class="text-sm font-semibold text-[#822021] hover:text-[#9C5A45]">Lihat Semua ({{ $pendingRefunds->count() }})</a>
            </div>

            <div class="mt-6 space-y-4">
                @forelse ($pendingRefunds as $refund)
                    @php($registration = $refund->transaction->registration)
                    {{-- Arahkan ke halaman detail transaksi (yang sudah memuat detail refund) --}}
                    <a href="{{ route('admin.registrations.show', $registration) }}" class="flex items-center justify-between rounded-2xl border border-[#FFD1BE] bg-white px-4 py-3 transition hover:bg-[#FFF5F0] hover:shadow-sm group">
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-[#822021] group-hover:text-[#E77B5F]">{{ $registration->user->name }}</p>
                            <p class="text-xs text-[#B49F9A]">{{ $registration->event->title }}</p>
                        </div>
                        <div class="text-right text-xs text-[#B49F9A] mr-4 min-w-[80px]">
                            <p>{{ optional($refund->requested_at)->translatedFormat('d M Y') }}</p>
                            <p class="font-semibold text-[#822021]">Rp{{ number_format($registration->transaction->amount, 0, ',', '.') }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-[#822021] min-w-[70px] justify-end">
                             Detail & Aksi
                            <x-heroicon-o-arrow-up-right class="h-4 w-4" />
                        </span>
                    </a>
                @empty
                    <div class="rounded-2xl border border-dashed border-[#FFD1BE] px-4 py-6 text-center text-sm text-[#B49F9A]">
                        Tidak ada permintaan refund pending.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- <div class="grid gap-6 xl:grid-cols-[1.2fr_1fr] mt-6">
        <div class="rounded-3xl bg-white border border-[#FFD1BE] shadow-[0_35px_90px_-45px_rgba(180,159,154,0.3)] p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-[#822021]">Menunggu Verifikasi Pembayaran</h2>
                    <p class="text-sm text-[#B49F9A]">Peserta terbaru yang telah mengunggah bukti bayar.</p>
                </div>
                <a href="{{ route('admin.registrations.index', ['payment_status' => 'awaiting_verification']) }}" class="text-sm font-semibold text-[#822021] hover:text-[#9C5A45]">Lihat Semua ({{ $awaitingVerification->count() }})</a>
            </div>

            <div class="mt-6 space-y-4">
                @forelse ($awaitingVerification as $registration)
                    <div class="flex items-start justify-between rounded-2xl bg-white border border-[#FFD1BE] px-4 py-3">
                        <div>
                            <p class="text-sm font-semibold text-[#822021]">{{ $registration->user->name }}</p>
                            <p class="text-xs text-[#B49F9A]">{{ $registration->event->title }}</p>
                        </div>
                        <div class="text-right text-xs text-[#B49F9A]">
                            <p>{{ optional($registration->registered_at)->translatedFormat('d M Y') }}</p>
                            <p class="font-semibold text-[#822021]">Rp{{ number_format($registration->transaction->amount, 0, ',', '.') }}</p>
                        </div>

                        <div class="flex items-center gap-2">
                            {{-- Form Verifikasi --}}
                            <form method="POST" action="{{ route('admin.registrations.verify-payment', $registration) }}" onsubmit="return confirm('Verifikasi pembayaran dari {{ $registration->user->name }}?')">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-full p-2 bg-emerald-100 text-emerald-600 shadow-md shadow-[#B49F9A]/30 transition hover:bg-emerald-600 hover:text-white"
                                    title="Setujui Pembayaran"
                                >
                                    <x-heroicon-o-check class="h-4 w-4" />
                                </button>
                            </form>
                            
                            {{-- Form Tolak --}}
                            <form method="POST" action="{{ route('admin.registrations.reject-payment', $registration) }}" onsubmit="return confirm('Tolak pembayaran dari {{ $registration->user->name }}?')">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-full p-2 bg-rose-100 text-rose-600 shadow-md shadow-[#B49F9A]/30 transition hover:bg-rose-600 hover:text-white"
                                    title="Tolak Pembayaran"
                                >
                                    <x-heroicon-o-x-mark class="h-4 w-4" />
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-[#FFD1BE] px-4 py-6 text-center text-sm text-[#B49F9A]">
                        Tidak ada pendaftaran menunggu verifikasi.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-3xl bg-white border border-[#FFD1BE] shadow-[0_35px_90px_-45px_rgba(180,159,154,0.3)] p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-[#822021]">Permintaan Refund Pending</h2>
                    <p class="text-sm text-[#B49F9A]">Pengajuan yang perlu segera ditinjau dan diproses.</p>
                </div>
                <a href="{{ route('admin.registrations.index', ['view' => 'refunds', 'refund_status' => 'pending']) }}" class="text-sm font-semibold text-[#822021] hover:text-[#9C5A45]">Lihat Semua ({{ $pendingRefunds->count() }})</a>
            </div>

            <div class="mt-6 space-y-4">
                @forelse ($pendingRefunds as $refund)
                    @php($registration = $refund->transaction->registration)
                    <div class="flex items-start justify-between rounded-2xl bg-white border border-[#FFD1BE] px-4 py-3">
                        <div>
                            <p class="text-sm font-semibold text-[#822021]">{{ $registration->user->name }}</p>
                            <p class="text-xs text-[#B49F9A]">{{ $registration->event->title }}</p>
                        </div>
                        <div class="text-right text-xs text-[#B49F9A]">
                            <p>{{ optional($refund->requested_at)->translatedFormat('d M Y') }}</p>
                            <p class="font-semibold text-[#822021]">Rp{{ number_format($registration->transaction->amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            {{-- Form Setujui Refund --}}
                            <form method="POST" action="{{ route('admin.refunds.approve', $refund) }}" onsubmit="return confirm('Setujui refund dari {{ $registration->user->name }}? Ini akan menutup permintaan.')">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-full p-2 bg-emerald-100 text-emerald-600 shadow-md shadow-[#B49F9A]/30 transition hover:bg-emerald-600 hover:text-white"
                                    title="Setujui Refund"
                                >
                                    <x-heroicon-o-check class="h-4 w-4" />
                                </button>
                            </form>
                            
                            {{-- Form Tolak Refund --}}
                            <form method="POST" action="{{ route('admin.refunds.reject', $refund) }}" onsubmit="return confirm('Tolak refund dari {{ $registration->user->name }}? Ini akan menutup permintaan.')">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-full p-2 bg-rose-100 text-rose-600 shadow-md shadow-[#B49F9A]/30 transition hover:bg-rose-600 hover:text-white"
                                    title="Tolak Refund"
                                >
                                    <x-heroicon-o-x-mark class="h-4 w-4" />
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-[#FFD1BE] px-4 py-6 text-center text-sm text-[#B49F9A]">
                        Tidak ada permintaan refund pending.
                    </div>
                @endforelse
            </div>
        </div>
    </div> -->

    {{-- ⭐ EVENT AKAN DATANG --}}
    <div class="rounded-3xl bg-white border border-[#FFD1BE] shadow-[0_35px_90px_-45px_rgba(180,159,154,0.3)] p-6 mt-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-[#822021]">Event Akan Datang</h2>
                <p class="text-sm text-[#B49F9A]">Yang bakal tayang dalam waktu dekat.</p>
            </div>

            <a href="{{ route('admin.events.index') }}" 
                class="text-sm font-semibold text-[#822021] hover:text-[#9C5A45]">
                Lihat Semua →
            </a>
        </div>

        <div class="mt-6 space-y-4">
            @forelse ($upcomingEvents as $event)
                <div class="flex items-start justify-between rounded-2xl bg-white border border-[#FFD1BE] px-4 py-3">
                    <div>
                        <p class="text-sm font-semibold text-[#822021]">{{ $event->title }}</p>
                        <p class="text-xs text-[#B49F9A]">
                            Mulai: {{ $event->start_at->translatedFormat('d M Y H:i') }}
                        </p>
                    </div>

                    <a href="{{ route('admin.events.edit', $event) }}"
                        class="mt-1 inline-block text-xs font-semibold text-[#E77B5F] hover:text-[#822021] transition">
                        Edit →
                    </a>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-[#FFD1BE] px-4 py-6 text-center text-sm text-[#B49F9A]">
                    Belum ada event terjadwal.
                </div>
            @endforelse
        </div>
    </div>

    {{-- AKSI CEPAT --}}
    <div class="rounded-3xl bg-white border border-[#FFD1BE] shadow-[0_35px_90px_-45px_rgba(180,159,154,0.3)] p-6 mt-6">
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