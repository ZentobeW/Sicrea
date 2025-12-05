@php($list = $items)

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
                        @if ($isRefundView)
                            <div class="inline-flex items-center gap-2">
                                <form method="POST" action="{{ route('admin.refunds.approve', $refund) }}">
                                    @csrf
                                    <button class="inline-flex items-center gap-2 rounded-full bg-[#E4F5E9] px-3 py-1 text-xs font-semibold text-[#2F9A55] transition hover:bg-[#d4efdf]">
                                        <x-heroicon-o-check class="h-4 w-4" />
                                        Setujui
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.refunds.reject', $refund) }}">
                                    @csrf
                                    <button class="inline-flex items-center gap-2 rounded-full bg-[#FDE1E7] px-3 py-1 text-xs font-semibold text-[#BA1B1D] transition hover:bg-[#f7cdd7]">
                                        <x-heroicon-o-x-mark class="h-4 w-4" />
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="inline-flex items-center justify-end gap-2">
                                <a href="{{ route('admin.registrations.show', $registration) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#822021] text-[#FAF8F1] shadow-inner transition hover:-translate-y-0.5 hover:bg-[#822021]/70" title="Detail transaksi">
                                    <span class="sr-only">Detail</span>
                                    <x-heroicon-o-eye class="h-5 w-5" />
                                </a>
                            </div>
                        @endif
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
