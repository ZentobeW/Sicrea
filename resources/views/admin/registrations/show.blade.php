@php
    use Illuminate\Support\Facades\Storage;
    $transaction = $registration->transaction;
@endphp

<x-layouts.admin
    title="Kelola Transaksi"
    :back-url="route('admin.registrations.index')"
>
    <section class="py-12">
        <div class="max-w-5xl mx-auto space-y-8">

            <div class="rounded-[28px] border border-[#FAD6C7] bg-white/95 p-6 shadow-xl shadow-[#FFD7BE]/40 sm:p-7">
                <dl class="grid gap-x-8 gap-y-5 text-sm text-[#6F4F4F] sm:grid-cols-2">
                    <div class="space-y-1">
                        <dt class="text-[11px] font-semibold uppercase tracking-[0.25em] text-[#B87A7A]">ID Transaksi</dt>
                        <dd class="text-base font-semibold text-[#2C1E1E]">#{{ str_pad($registration->id, 4, '0', STR_PAD_LEFT) }}</dd>
                    </div>
                    <div class="space-y-1">
                        <dt class="text-[11px] font-semibold uppercase tracking-[0.25em] text-[#B87A7A]">Judul Event</dt>
                        <dd class="text-base font-semibold text-[#2C1E1E]">{{ $registration->event->title }}</dd>
                        <dd class="text-xs text-[#B87A7A]">{{ optional($registration->event->start_at)->translatedFormat('d M Y H:i') }}</dd>
                    </div>
                    <div class="space-y-1">
                        <dt class="text-[11px] font-semibold uppercase tracking-[0.25em] text-[#B87A7A]">Nama Peserta</dt>
                        <dd class="text-base font-semibold text-[#2C1E1E]">{{ $registration->user->name }}</dd>
                    </div>
                    <div class="space-y-1">
                        <dt class="text-[11px] font-semibold uppercase tracking-[0.25em] text-[#B87A7A]">Email Peserta</dt>
                        <dd class="text-base font-semibold text-[#2C1E1E]">{{ $registration->user->email }}</dd>
                    </div>
                    <div class="space-y-1">
                        <dt class="text-[11px] font-semibold uppercase tracking-[0.25em] text-[#B87A7A]">Jumlah Bayar</dt>
                        <dd class="text-base font-semibold text-[#2C1E1E]">Rp{{ number_format($transaction?->amount ?? $registration->amount ?? 0, 0, ',', '.') }}</dd>
                    </div>
                    <div class="space-y-1">
                        <dt class="text-[11px] font-semibold uppercase tracking-[0.25em] text-[#B87A7A]">Metode Pembayaran</dt>
                        <dd class="text-base font-semibold text-[#2C1E1E]">{{ $transaction?->payment_method ?? config('payment.method', 'Virtual Account') }}</dd>
                    </div>
                    <div class="space-y-1">
                        <dt class="text-[11px] font-semibold uppercase tracking-[0.25em] text-[#B87A7A]">Tanggal Transaksi</dt>
                        <dd class="text-base font-semibold text-[#2C1E1E]">
                            {{ optional($transaction?->paid_at ?? $registration->registered_at)->translatedFormat('d M Y H:i') ?? '-' }}
                        </dd>
                    </div>
                    <div class="space-y-1">
                        <dt class="text-[11px] font-semibold uppercase tracking-[0.25em] text-[#B87A7A]">Status</dt>
                        <dd>
                            <span @class([
                                'inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold',
                                'bg-[#FCE2CF] text-[#C65B74]' => in_array($transaction?->status?->value ?? '', ['pending', 'awaiting_verification']),
                                'bg-[#E4F5E9] text-[#2F9A55]' => ($transaction?->status?->value ?? null) === 'verified',
                                'bg-[#FDE1E7] text-[#BA1B1D]' => ($transaction?->status?->value ?? null) === 'rejected',
                                'bg-[#E5E7EB] text-[#4B5563]' => ! in_array($transaction?->status?->value ?? '', ['pending', 'awaiting_verification', 'verified', 'rejected']),
                            ])>
                                <span class="h-2 w-2 rounded-full {{ match ($transaction?->status?->value) {
                                    'pending', 'awaiting_verification' => 'bg-[#FF8A64]',
                                    'verified' => 'bg-[#2F9A55]',
                                    'rejected' => 'bg-[#BA1B1D]',
                                    default => 'bg-[#6B7280]',
                                } }}"></span>
                                {{ $transaction?->status->label() ?? 'Tidak ada data' }}
                            </span>
                        </dd>
                    </div>
                </dl>

                <div class="mt-6 rounded-2xl border border-[#FAD6C7] bg-[#FFF7F1]/80 px-4 py-3">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.25em] text-[#B87A7A]">Bukti Pembayaran</p>
                            <p class="text-sm text-[#6F4F4F]">Periksa kecocokan nominal sebelum verifikasi.</p>
                        </div>
                        @if ($registration->payment_proof_path)
                            <a
                                href="{{ Storage::disk('public')->url($registration->payment_proof_path) }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-4 py-2 text-xs font-semibold text-[#FAF8F1] shadow-md shadow-[#B49F9A]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70"
                            >
                                Lihat Bukti
                                <x-heroicon-o-arrow-up-right class="h-4 w-4" />
                            </a>
                        @else
                            <p class="text-sm font-semibold text-[#C65B74]">Belum ada bukti pembayaran yang diunggah.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- START: BLOK TINDAK LANJUT PEMBAYARAN (Satu Notes Field) --}}
            @if ($transaction && $transaction->status->value === 'awaiting_verification')
                <div x-data="{ adminNote: '' }" class="mt-6 space-y-3 rounded-[28px] border border-[#FFD1BE] bg-white/95 p-6 shadow-xl shadow-[#FFD7BE]/40 sm:p-7">
                    <h3 class="text-xl font-semibold text-[#2C1E1E]">Tindak Lanjut Pembayaran</h3>
                    <p class="text-sm text-[#9A5A46]">Tinjau bukti bayar dan ambil keputusan. Catatan admin akan disimpan ke pendaftaran.</p>

                    {{-- KOTAK NOTES TERPUSAT --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-[#2C1E1E]">Catatan Admin (Opsional/Wajib Tolak)</label>
                        <textarea x-model="adminNote" id="admin_note_field_payment" rows="3" class="w-full rounded-xl border border-[#FFD1BE] bg-white/80 px-3 py-2 text-sm text-[#2C1E1E] focus:border-[#FF8A64] focus:outline-none focus:ring-2 focus:ring-[#FF8A64]/30" placeholder="Tuliskan catatan persetujuan atau alasan penolakan"></textarea>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2 pt-2">
                        {{-- Form 1: Setujui Pembayaran (Verify) --}}
                        <form id="verify-form" method="POST" action="{{ route('admin.registrations.verify-payment', $registration) }}">
                            @csrf
                            {{-- Hidden input untuk transfer nilai catatan --}}
                            <input type="hidden" name="admin_note" x-bind:value="adminNote">
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-md shadow-emerald-500/30 transition hover:-translate-y-0.5 hover:bg-emerald-700">
                                <x-heroicon-o-check class="h-4 w-4" /> Setujui Pembayaran
                            </button>
                        </form>

                        {{-- Form 2: Tolak Pembayaran (Reject) --}}
                        <form id="reject-form" method="POST" action="{{ route('admin.registrations.reject-payment', $registration) }}" 
                            onsubmit="if (!document.getElementById('admin_note_field_payment').value.trim()) { alert('Catatan penolakan wajib diisi!'); return false; } return true;">
                            @csrf
                            {{-- Hidden input untuk transfer nilai catatan --}}
                            <input type="hidden" name="admin_note" x-bind:value="adminNote">
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-rose-600 px-4 py-3 text-sm font-semibold text-white shadow-md shadow-rose-500/30 transition hover:-translate-y-0.5 hover:bg-rose-700">
                                <x-heroicon-o-x-mark class="h-4 w-4" /> Tolak Pembayaran
                            </button>
                        </form>
                    </div>
                    <p class="text-xs text-[#B49F9A] mt-2">Catatan: Untuk **Penolakan**, kolom di atas wajib diisi.</p>
                </div>
            @endif
            {{-- END: BLOK TINDAK LANJUT PEMBAYARAN --}}
        </div>
    </section>

    @if ($transaction?->refund)
        @php($refund = $transaction->refund)
        <section class="py-6">
            <div class="max-w-5xl mx-auto rounded-[28px] border border-[#FAD6C7] bg-white/95 p-6 shadow-xl shadow-[#FFD7BE]/40 sm:p-7">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Detail Refund</p>
                        <h2 class="text-xl font-semibold text-[#2C1E1E]">Alasan & Catatan Admin</h2>
                        <p class="text-xs text-[#9A5A46]">Kelola status refund, alasan peserta, dan catatan admin.</p>
                    </div>
                    <span @class([
                        'inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold',
                        'bg-[#FCE2CF] text-[#C65B74]' => $refund->status->value === 'pending',
                        'bg-[#E4F5E9] text-[#2F9A55]' => in_array($refund->status->value, ['approved', 'completed']),
                        'bg-[#FDE1E7] text-[#BA1B1D]' => $refund->status->value === 'rejected',
                        'bg-[#E5E7EB] text-[#4B5563]' => ! in_array($refund->status->value, ['pending', 'approved', 'completed', 'rejected']),
                    ])>
                        <span class="h-2 w-2 rounded-full {{ match ($refund->status->value) {
                            'pending' => 'bg-[#FF8A64]',
                            'approved', 'completed' => 'bg-[#2F9A55]',
                            'rejected' => 'bg-[#BA1B1D]',
                            default => 'bg-[#6B7280]',
                        } }}"></span>
                        {{ $refund->status->label() }}
                    </span>
                </div>

                <div class="mt-5 grid gap-4 text-sm text-[#6F4F4F] sm:grid-cols-2">
                    <div class="space-y-2 rounded-2xl bg-[#FFF5EF] px-4 py-3">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Alasan Peserta</p>
                        <p class="text-sm text-[#2C1E1E]">{{ $refund->reason ?: 'Tidak ada alasan yang diisi.' }}</p>
                        <p class="text-[11px] text-[#9A5A46]">Diajukan: {{ optional($refund->requested_at)->translatedFormat('d M Y H:i') ?? '-' }}</p>
                    </div>
                    <div class="space-y-2 rounded-2xl bg-[#F7FFF9] px-4 py-3">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#2F9A55]">Catatan Admin</p>
                        <p class="text-sm text-[#2C1E1E]">{{ $refund->admin_note ?: 'Belum ada catatan admin.' }}</p>
                        <p class="text-[11px] text-[#9A5A46]">Diproses: {{ optional($refund->processed_at)->translatedFormat('d M Y H:i') ?? '-' }}</p>
                    </div>
                </div>

                {{-- START: BLOK TINDAK LANJUT REFUND (Satu Notes Field) --}}
                @if ($refund->status->value === 'pending')
                    <div x-data="{ refundNote: '' }" class="mt-6 space-y-4 rounded-[28px] border border-[#FFD1BE] bg-white/95 p-6 shadow-xl shadow-[#FFD7BE]/40 sm:p-7">
                        <h3 class="text-xl font-semibold text-[#2C1E1E]">Tindak Lanjut Refund</h3>
                        <p class="text-sm text-[#9A5A46]">Tinjau permohonan refund dan berikan catatan sebelum mengambil keputusan.</p>

                        {{-- KOTAK NOTES TERPUSAT --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-[#2C1E1E]">Catatan Admin (Opsional/Wajib Tolak)</label>
                            <textarea x-model="refundNote" id="admin_note_field_refund" rows="3" class="w-full rounded-xl border border-[#FFD1BE] bg-white/80 px-3 py-2 text-sm text-[#2C1E1E] focus:border-[#FF8A64] focus:outline-none focus:ring-2 focus:ring-[#FF8A64]/30" placeholder="Tuliskan catatan persetujuan atau alasan penolakan"></textarea>
                        </div>
                        
                        <div class="grid gap-3 sm:grid-cols-2 pt-2">
                            {{-- Form 1: Setujui Refund (Approve) --}}
                            <form method="POST" action="{{ route('admin.refunds.approve', $refund) }}">
                                @csrf
                                <input type="hidden" name="admin_note" x-bind:value="refundNote">
                                <button class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-md shadow-emerald-500/30 transition hover:-translate-y-0.5 hover:bg-emerald-700">
                                    Setujui Refund
                                </button>
                            </form>

                            {{-- Form 2: Tolak Refund (Reject) --}}
                            <form method="POST" action="{{ route('admin.refunds.reject', $refund) }}"
                                onsubmit="if (!document.getElementById('admin_note_field_refund').value.trim()) { alert('Catatan penolakan wajib diisi!'); return false; } return true;">
                                @csrf
                                <input type="hidden" name="admin_note" x-bind:value="refundNote">
                                <button class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-rose-600 px-4 py-3 text-sm font-semibold text-white shadow-md shadow-rose-500/30 transition hover:-translate-y-0.5 hover:bg-rose-700">
                                    Tolak Refund
                                </button>
                            </form>
                        </div>
                        <p class="text-xs text-[#B49F9A] mt-2">Catatan: Untuk **Penolakan**, kolom di atas wajib diisi.</p>
                    </div>
                @endif
                {{-- END: BLOK TINDAK LANJUT REFUND --}}
            </div>
        </section>
    @endif
</x-layouts.admin>