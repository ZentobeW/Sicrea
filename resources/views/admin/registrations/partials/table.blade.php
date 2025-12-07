@php($list = $items)

<style>
    /* --- CUSTOM PAGINATION STYLE --- */

    /* 1. Teks "Showing ... results" */
    nav[role="navigation"] p.text-sm {
        color: #822021 !important; /* Warna Teks Merah */
    }
    nav[role="navigation"] p.text-sm span {
        color: #822021 !important; /* Warna Angka Tebal Merah */
        font-weight: 700;
    }

    /* 2. Container Tombol Pagination (Desktop) */
    nav[role="navigation"] > div:last-child > div > span {
        box-shadow: none !important; /* Hilangkan shadow bawaan */
    }

    /* 3. Semua Tombol (Angka & Panah) - Default State */
    nav[role="navigation"] a, 
    nav[role="navigation"] span[aria-current="page"] span,
    nav[role="navigation"] span[aria-disabled="true"] span {
        background-color: #FCF5E6 !important; /* Background Krem */
        color: #822021 !important;             /* Text Merah */
        border: 1px solid #822021 !important;  /* Border Merah */
        border-radius: 8px;                    /* Sedikit Rounded */
        margin: 0 2px;                         /* Jarak antar tombol */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 36px;
        min-width: 36px;
        padding: 0 10px;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    /* 4. Tombol Disabled / Mentok (Panah Kiri/Kanan saat disable) */
    nav[role="navigation"] span[aria-disabled="true"] span {
        background-color: #FCF5E6 !important; /* Tetap Krem */
        color: #822021 !important;             /* Tetap Merah */
        opacity: 0.5;                          /* Agak transparan agar terlihat non-aktif */
        cursor: not-allowed;
    }
    /* Memastikan icon SVG di dalam tombol disabled juga berwarna merah */
    nav[role="navigation"] span[aria-disabled="true"] span svg {
        color: #822021 !important;
        fill: currentColor;
    }

    /* 5. Tombol Aktif (Halaman saat ini) */
    nav[role="navigation"] span[aria-current="page"] span {
        background-color: #822021 !important; /* Background Merah */
        color: #FCF5E6 !important;            /* Text Krem */
        border-color: #822021 !important;
    }

    /* 6. Efek Hover (Untuk tombol yang bisa diklik) */
    nav[role="navigation"] a:hover {
        background-color: #822021 !important; /* Hover jadi Merah */
        color: #FCF5E6 !important;            /* Text jadi Krem */
        transform: scale(1.1);                /* Efek Zoom */
        z-index: 10;
    }

    /* 7. Icon SVG (Panah Previous/Next) */
    nav[role="navigation"] svg {
        width: 16px;
        height: 16px;
        stroke-width: 2.5; /* Menebalkan panah */
    }
    
    /* Hilangkan style rounded bawaan tailwind yang menyatu */
    nav[role="navigation"] span.relative.z-0.inline-flex.shadow-sm.rounded-md {
        box-shadow: none !important;
    }
    nav[role="navigation"] a.relative.inline-flex.items-center,
    nav[role="navigation"] span[aria-disabled="true"] span {
        margin-left: 4px !important; /* Beri jarak antar tombol */
    }
</style>

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-[#FAD6C7]/70 text-base">
        <thead class="bg-[#FFF5EF] text-sm font-semibold uppercase tracking-widest text-[#822021]">
            <tr>
                <th class="px-6 py-3 text-left">{{ $isRefundView ? 'ID Refund' : 'ID Daftar' }}</th>
                <th class="px-6 py-3 text-left">Event</th>
                <th class="px-6 py-3 text-left">Peserta</th>
                <th class="px-6 py-3 text-left">No. Rekening</th>
                <th class="px-6 py-3 text-left">Jumlah</th>
                <th class="px-6 py-3 text-left">{{ $isRefundView ? 'Status Refund' : 'Status' }}</th>
                <th class="px-6 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#FAD6C7]/60 bg-white/80">
            @forelse ($list as $row)
                @if ($isRefundView)
                    @php($refund = $row)
                    @php($registration = optional($refund->transaction)->registration)
                    @php($formData = collect($registration?->form_data))
                    @php($transaction = $refund->transaction)
                @else
                    @php($registration = $row)
                    @php($refund = optional($registration->transaction)->refund)
                    @php($formData = collect($registration->form_data))
                    @php($transaction = $registration->transaction)
                @endif
                <tr class="transition hover:bg-[#FCF5E6]">
                    <td class="px-6 py-4 align-top">
                            <div class="font-semibold text-base text-[#822021]">
                                #{{ str_pad($isRefundView ? $refund->id : $registration->id, 4, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="text-sm text-[#822021]">
                                {{ $isRefundView ? optional($refund->requested_at)->translatedFormat('d M Y H:i') : optional($registration->registered_at)->translatedFormat('d M Y H:i') }}
                            </div>
                    </td>
                    <td class="px-6 py-4 align-top">
                            <p class="font-semibold text-base text-[#822021]">{{ $registration?->event->title }}</p>
                            <p class="text-sm text-[#822021]">{{ $registration?->event->venue_name }}</p>
                            <p class="text-sm text-[#822021]">Tutor: {{ $registration?->event->tutor_name }}</p>
                    </td>
                    <td class="px-6 py-4 align-top">
                            <p class="font-semibold text-base text-[#822021]">{{ $registration?->user->name }}</p>
                            <p class="text-sm text-[#822021]">{{ $formData->get('phone', $registration?->user->phone ?? '-') }}</p>
                            <p class="text-sm text-[#822021]">{{ $registration?->user->email }}</p>
                    </td>
                    <td class="px-6 py-4 align-top text-base text-[#822021]">
                            {{ $formData->get('account_number') ?? $formData->get('bank_account') ?? '-' }}
                    </td>
                    <td class="px-6 py-4 align-top">
                            <p class="font-semibold text-base text-[#822021]">Rp{{ number_format($transaction?->amount ?? 0, 0, ',', '.') }}</p>
                            <p class="text-sm text-[#822021]">
                                {{ $isRefundView
                                    ? optional($refund->requested_at)->translatedFormat('d M Y H:i')
                                    : $registration?->event->start_at->translatedFormat('d M Y') }}
                            </p>
                    </td>
                    <td class="px-6 py-4 align-top">
                            @if ($isRefundView)
                                @php($refundStatus = $refund->status)
                                <span @class([
                                    'inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold',
                                    'bg-[#FCE2CF] text-[#C65B74]' => optional($refundStatus)->value === 'pending',
                                    'bg-[#E4F5E9] text-[#2F9A55]' => in_array(optional($refundStatus)->value, ['approved', 'completed']),
                                    'bg-[#FDE1E7] text-[#BA1B1D]' => optional($refundStatus)->value === 'rejected',
                                    'bg-[#E5E7EB] text-[#4B5563]' => ! in_array(optional($refundStatus)->value, ['pending', 'approved', 'completed', 'rejected']),
                                ])>
                                    <span class="h-2 w-2 rounded-full {{ match (optional($refundStatus)->value) {
                                        'pending' => 'bg-[#FF8A64]',
                                        'approved', 'completed' => 'bg-[#2F9A55]',
                                        'rejected' => 'bg-[#BA1B1D]',
                                        default => 'bg-[#6B7280]',
                                    } }}"></span>
                                    {{ optional($refundStatus)->label() ?? 'Tidak diketahui' }}
                                </span>
                            @else
                                @php($paymentStatus = optional($transaction)->status?->value)
                                <span @class([
                                    'inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold',
                                    'bg-[#FFF0E6] text-[#C65B74]' => $paymentStatus === 'pending',
                                    'bg-[#FCE2CF] text-[#C65B74]' => $paymentStatus === 'awaiting_verification',
                                    'bg-[#E4F5E9] text-[#2F9A55]' => $paymentStatus === 'verified',
                                    'bg-[#FDE1E7] text-[#BA1B1D]' => $paymentStatus === 'rejected',
                                    'bg-[#E5E7EB] text-[#4B5563]' => ! in_array($paymentStatus, ['pending', 'awaiting_verification', 'verified', 'rejected']),
                                ])>
                                    <span class="h-2 w-2 rounded-full {{ match ($paymentStatus) {
                                        'pending' => 'bg-[#FF8A64]',
                                        'awaiting_verification' => 'bg-[#F59E0B]',
                                        'verified' => 'bg-[#2F9A55]',
                                        'rejected' => 'bg-[#BA1B1D]',
                                        default => 'bg-[#6B7280]',
                                    } }}"></span>
                                    {{ $transaction?->status->label() ?? 'Tidak diketahui' }}
                                </span>
                            @endif
                    </td>
                    <td class="px-6 py-4 align-top text-right">
                        {{-- PERBAIKAN: Menyamakan tombol aksi menjadi "Lihat Detail" untuk semua tampilan --}}
                        <div class="inline-flex items-center justify-end gap-2">
                            <a href="{{ route('admin.registrations.show', $registration) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#822021] text-[#FAF8F1] shadow-inner transition hover:-translate-y-0.5 hover:bg-[#822021]/70" title="Lihat Detail & Proses">
                                <span class="sr-only">Detail</span>
                                <x-heroicon-o-eye class="h-5 w-5" />
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-base text-[#822021]">
                        Tidak ada data pada filter saat ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="border-t border-[#FAD6C7]/70 bg-[#FAF8F1] px-6 py-4 text-base text-[#822021] flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        @if ($list->count())
            Menampilkan {{ $list->firstItem() }}–{{ $list->lastItem() }} dari {{ $list->total() }} data
        @else
            Menampilkan 0 data
        @endif
    </div>
    <div class="pagination-links">{!! $list->links() !!}</div>
</div>