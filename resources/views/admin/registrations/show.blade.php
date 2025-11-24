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
            <div class="relative overflow-hidden rounded-[32px] bg-gradient-to-br from-[#FFE3D3] via-[#FFF3EA] to-white p-6 shadow-lg shadow-[#FFD7BE]/40 sm:p-7">
                <div class="absolute -right-10 -top-10 h-44 w-44 rounded-full bg-[#FFE3D3]/60 blur-3xl"></div>
                <div class="absolute -left-14 bottom-0 h-36 w-36 rounded-full bg-[#FFF3EA]/70 blur-3xl"></div>

                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <a
                            href="{{ route('admin.registrations.index') }}"
                            class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-4 py-2 text-sm font-semibold text-[#FAF8F1] shadow-md shadow-[#B49F9A]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70"
                        >
                            <x-heroicon-o-arrow-left-on-rectangle class="h-4 w-4" />
                            Kembali
                        </a>
                        <h1 class="text-2xl font-semibold text-[#2C1E1E] sm:text-3xl">Detail Transaksi</h1>
                    </div>
                </div>
            </div>

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

                @if ($refund->status->value === 'pending')
                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        <form method="POST" action="{{ route('admin.refunds.approve', $refund) }}" class="space-y-3 rounded-2xl border border-[#E4F5E9] bg-[#F7FFF9] px-4 py-4 shadow-sm">
                            @csrf
                            <label class="block text-sm font-semibold text-[#2C1E1E]">Catatan Admin</label>
                            <textarea name="admin_note" rows="3" class="w-full rounded-xl border border-[#D1F2DC] bg-white/80 px-3 py-2 text-sm text-[#2C1E1E] focus:border-[#2F9A55] focus:outline-none focus:ring-2 focus:ring-[#2F9A55]/30" placeholder="Catatan persetujuan">{{ old('admin_note') }}</textarea>
                            <button class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 px-4 py-2 text-xs font-semibold text-white shadow-md shadow-emerald-500/30 transition hover:-translate-y-0.5 hover:bg-emerald-700">
                                Setujui Refund
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.refunds.reject', $refund) }}" class="space-y-3 rounded-2xl border border-[#FDE1E7] bg-[#FFF5F7] px-4 py-4 shadow-sm">
                            @csrf
                            <label class="block text-sm font-semibold text-[#2C1E1E]">Catatan Admin</label>
                            <textarea name="admin_note" rows="3" class="w-full rounded-xl border border-[#FBD5DF] bg-white/80 px-3 py-2 text-sm text-[#2C1E1E] focus:border-[#E11D48] focus:outline-none focus:ring-2 focus:ring-[#E11D48]/20" placeholder="Catatan penolakan">{{ old('admin_note') }}</textarea>
                            <button class="inline-flex items-center justify-center gap-2 rounded-full bg-rose-600 px-4 py-2 text-xs font-semibold text-white shadow-md shadow-rose-500/30 transition hover:-translate-y-0.5 hover:bg-rose-700">
                                Tolak Refund
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </section>
    @endif
</x-layouts.admin>
