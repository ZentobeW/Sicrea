@php($tabs = [
    ['label' => 'Dashboard', 'route' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard'), 'icon' => 'home'],
    ['label' => 'Event', 'route' => route('admin.events.index'), 'active' => request()->routeIs('admin.events.*'), 'icon' => 'calendar'],
    ['label' => 'Portofolio', 'route' => route('admin.portfolios.index'), 'active' => request()->routeIs('admin.portfolios.*'), 'icon' => 'photo'],
    ['label' => 'Transaksi', 'route' => route('admin.registrations.index'), 'active' => request()->routeIs('admin.registrations.*'), 'icon' => 'credit-card'],
    ['label' => 'Laporan & Analitik', 'route' => route('admin.reports.index'), 'active' => request()->routeIs('admin.reports.*'), 'icon' => 'chart-bar-square'],
])

@php($isRefundView = in_array(request('view'), ['refund', 'refunds'], true) || ($isRefundView ?? false))
@php($pendingRefunds = $isRefundView ? $refundSummary['pending'] : $registrationSummary['pendingRefunds'])
@php($totalAmount = $isRefundView ? $refundSummary['amount'] : $registrationSummary['amount'])

<x-layouts.admin
    title="Kelola Transaksi"
    subtitle="Pantau pembayaran peserta, tindak lanjuti refund, dan pastikan semua tagihan terselesaikan."
    :tabs="$tabs"
>
    <x-slot name="actions">
        <a
            href="{{ route('admin.registrations.export', request()->all()) }}"
            class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-4 py-2 text-sm font-semibold text-[#FAF8F1] shadow-lg shadow-[#B49F9A]/40 transition hover:-translate-y-0.5 hover:bg-[#822021]/70"
        >
            <x-heroicon-o-arrow-up-right class="h-4 w-4" />
            Export CSV
        </a>
    </x-slot>

    <section class="rounded-[32px] bg-gradient-to-br from-[#FFE3D3] via-[#FFF3EA] to-white p-8 shadow-lg shadow-[#FFD7BE]/40">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Kelola Transaksi</p>
                <h1 class="mt-2 text-3xl font-semibold text-[#2C1E1E]">
                    {{ $isRefundView ? 'Kelola Permintaan Refund' : 'Ringkasan Pendaftaran Peserta' }}
                </h1>
                <p class="mt-3 max-w-xl text-sm text-[#6F4F4F]">
                    {{ $isRefundView
                        ? 'Tinjau setiap pengajuan pengembalian dana, pastikan statusnya jelas, dan lanjutkan komunikasi dengan peserta.'
                        : 'Gunakan panel ini untuk mengecek status pembayaran, menindaklanjuti refund, dan mengekspor data peserta sesuai kebutuhan operasional.'
                    }}
                </p>
            </div>
            <div class="rounded-3xl border border-[#FAD6C7] bg-white/80 px-6 py-4 text-sm text-[#C65B74] shadow-inner">
                <p class="text-xs font-semibold uppercase tracking-widest text-[#A04E62]">
                    {{ $isRefundView ? 'Refund Menunggu' : 'Refund Pending' }}
                </p>
                <p class="mt-1 text-3xl font-semibold text-[#C65B74]">{{ $pendingRefunds }}</p>
                <p class="text-xs text-[#B87A7A]">
                    {{ $isRefundView
                        ? 'Jumlah refund yang menunggu persetujuan admin.'
                        : 'Permintaan refund peserta yang perlu segera ditinjau.'
                    }}
                </p>
            </div>
        </div>

        <div class="mt-6 inline-flex items-center gap-2 rounded-full bg-white p-2 text-sm font-semibold shadow-inner">
            <a
                href="{{ route('admin.registrations.index', request()->except(['view', 'page'])) }}"
                @class([
                    'rounded-full px-5 py-2 transition',
                    'bg-[#822021] text-[#FAF8F1] shadow-md shadow-[#B49F9A]/30' => ! request('view'),
                    'bg-white/70 text-[#822021]' => request('view'),
                ])
            >
                Kelola Pendaftaran
            </a>
            <a
                href="{{ route('admin.registrations.index', array_merge(request()->except(['page', 'view']), ['view' => 'refunds'])) }}"
                @class([
                    'rounded-full px-5 py-2 transition',
                    'bg-[#822021] text-[#FAF8F1] shadow-md shadow-[#B49F9A]/30' => request('view') === 'refunds',
                    'bg-white/70 text-[#822021]' => request('view') !== 'refunds',
                ])
            >
                Kelola Refund
            </a>
        </div>
    </section>

    <section class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="flex items-start gap-3 rounded-3xl border border-[#FAD6C7] bg-white/90 p-5 shadow-sm">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#FF8A64]/10 text-[#FF8A64]">
                <x-heroicon-o-user-group class="h-5 w-5" />
            </span>
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-[#A04E62]">
                    {{ $isRefundView ? 'Total Refund' : 'Total Pendaftar' }}
                </p>
                <p class="mt-1 text-2xl font-semibold text-[#2C1E1E]">{{ $isRefundView ? $refundSummary['total'] : $registrationSummary['total'] }}</p>
                <p class="text-xs text-[#B87A7A]">
                    {{ $isRefundView ? 'Permintaan refund yang tercatat pada periode ini.' : 'Akumulasi seluruh peserta pada filter saat ini.' }}
                </p>
            </div>
        </article>
        <article class="flex items-start gap-3 rounded-3xl border border-[#FFE0CC] bg-amber-100 text-amber-600 p-5 shadow-sm">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#FFB5A7]/20 text-[#FF6F61]">
                <x-heroicon-o-credit-card class="h-5 w-5" />
            </span>
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-[#C65B74]">
                    {{ $isRefundView ? 'Menunggu Persetujuan' : 'Menunggu' }}
                </p>
                <p class="mt-1 text-2xl font-semibold text-[#2C1E1E]">{{ $isRefundView ? $refundSummary['pending'] : $registrationSummary['awaiting'] }}</p>
                <p class="text-xs text-[#B87A7A]">
                    {{ $isRefundView ? 'Refund yang belum diproses oleh admin.' : 'Pembayaran pending & menunggu verifikasi.' }}
                </p>
            </div>
        </article>
        <article class="flex items-start gap-3 rounded-3xl border border-[#DAF2DC] bg-[#F1FBF2] p-5 shadow-sm">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#9EE6B8]/20 text-[#2F9A55]">
                <x-heroicon-o-presentation-chart-bar class="h-5 w-5" />
            </span>
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-[#2F9A55]">{{ $isRefundView ? 'Refund Disetujui' : 'Disetujui' }}</p>
                <p class="mt-1 text-2xl font-semibold text-[#2C1E1E]">{{ $isRefundView ? $refundSummary['approved'] : $registrationSummary['verified'] }}</p>
                <p class="text-xs text-[#6F8F7C]">
                    {{ $isRefundView ? 'Refund yang telah disetujui atau selesai diproses.' : 'Pembayaran telah diverifikasi oleh admin.' }}
                </p>
            </div>
        </article>
        <article class="flex items-start gap-3 rounded-3xl border border-[#FAD6C7] bg-white/90 p-5 shadow-sm">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#FF8A64]/10 text-[#FF8A64]">
                <x-heroicon-o-chart-bar-square class="h-5 w-5" />
            </span>
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-[#A04E62]">Total Dana</p>
                <p class="mt-1 text-2xl font-semibold text-[#2C1E1E]">Rp{{ number_format($totalAmount, 0, ',', '.') }}</p>
                <p class="text-xs text-[#B87A7A]">
                    {{ $isRefundView ? 'Nilai nominal dari registrasi yang mengajukan refund.' : 'Nilai transaksi berdasarkan filter aktif.' }}
                </p>
            </div>
        </article>
    </section>

    {{-- FILTER FORM (AUTO SUBMIT) --}}
    <form method="GET" class="mt-8 grid gap-4 rounded-[28px] border border-[#FAD6C7] bg-white/90 p-6 shadow-lg shadow-[#FFD7BE]/40 md:grid-cols-2 text-sm">
        @if ($isRefundView)
            <input type="hidden" name="view" value="refunds">
        @endif
        
        <div>
            <label class="block text-sm font-semibold text-[#2C1E1E]">Filter Event</label>
            <select
                name="event_id"
                data-auto-submit
                class="mt-2 w-full rounded-2xl border border-[#FAD6C7] bg-white/80 px-4 py-3 text-sm text-[#2C1E1E] focus:border-[#FF8A64] focus:outline-none focus:ring-2 focus:ring-[#FF8A64]/30 cursor-pointer"
            >
                <option value="">Semua Event</option>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}" @selected(request('event_id') == $event->id)>{{ $event->title }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold text-[#2C1E1E]">
                {{ $isRefundView ? 'Status Refund' : 'Status Pembayaran' }}
            </label>
            <select
                name="{{ $isRefundView ? 'refund_status' : 'payment_status' }}"
                data-auto-submit
                class="mt-2 w-full rounded-2xl border border-[#FAD6C7] bg-white/80 px-4 py-3 text-sm text-[#2C1E1E] focus:border-[#FF8A64] focus:outline-none focus:ring-2 focus:ring-[#FF8A64]/30 cursor-pointer"
            >
                <option value="">{{ $isRefundView ? 'Semua Status Refund' : 'Semua Status' }}</option>
                @if ($isRefundView)
                    @foreach (\App\Enums\RefundStatus::cases() as $status)
                        <option value="{{ $status->value }}" @selected(request('refund_status') === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                @else
                    @foreach (\App\Enums\PaymentStatus::cases() as $status)
                        <option value="{{ $status->value }}" @selected(request('payment_status') === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </form>

    @php($items = $isRefundView ? ($refunds ?? collect()) : $registrations)
    @php($list = $items)

    <section class="mt-8 rounded-[32px] border border-[#FAD6C7] bg-white/95 shadow-xl shadow-[#FFD7BE]/40">
        <header class="flex flex-col gap-4 border-b border-[#FAD6C7]/70 px-6 py-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-[#2C1E1E]">
                    {{ $isRefundView ? 'Daftar Permintaan Refund' : 'Daftar Pendaftaran' }}
                </h2>
                <p class="text-sm text-[#6F4F4F]">
                    {{ $isRefundView
                        ? 'Kelola dan proses permintaan refund peserta sesuai status terbaru.'
                        : 'Pantau status dan akses detail peserta untuk verifikasi lanjutan.' }}
                </p>
            </div>
        </header>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#FAD6C7]/70 text-sm">
                <thead class="bg-[#FFF5EF] text-xs font-semibold uppercase tracking-widest text-[#B87A7A]">
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
                        <tr class="transition hover:bg-[#FFF0E6]">
                            <td class="px-6 py-4 align-top">
                                    <div class="font-semibold text-[#2C1E1E]">
                                        #{{ str_pad($isRefundView ? $refund->id : $registration->id, 4, '0', STR_PAD_LEFT) }}
                                    </div>
                                    <div class="text-xs text-[#B87A7A]">
                                        {{ $isRefundView ? optional($refund->requested_at)->translatedFormat('d M Y H:i') : optional($registration->registered_at)->translatedFormat('d M Y H:i') }}
                                    </div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                    <p class="font-semibold text-[#2C1E1E]">{{ $registration?->event->title }}</p>
                                    <p class="text-xs text-[#B87A7A]">{{ $registration?->event->venue_name }}</p>
                                    <p class="text-[11px] text-[#B87A7A]">Tutor: {{ $registration?->event->tutor_name }}</p>
                            </td>
                            <td class="px-6 py-4 align-top">
                                    <p class="font-semibold text-[#2C1E1E]">{{ $registration?->user->name }}</p>
                                    <p class="text-xs text-[#B87A7A]">{{ $formData->get('phone', $registration?->user->phone ?? '-') }}</p>
                                    <p class="text-[11px] text-[#B87A7A]">{{ $registration?->user->email }}</p>
                            </td>
                            <td class="px-6 py-4 align-top text-[#2C1E1E]">
                                    {{ $formData->get('account_number') ?? $formData->get('bank_account') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 align-top">
                                    <p class="font-semibold text-[#2C1E1E]">Rp{{ number_format($transaction?->amount ?? 0, 0, ',', '.') }}</p>
                                    <p class="text-[11px] text-[#B87A7A]">
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
                                            {{ optional($refundStatus)->label() ?? 'Tidak ada data' }}
                                        </span>
                                    @else
                                        <span @class([
                                            'inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold',
                                            'bg-[#FCE2CF] text-[#C65B74]' => in_array($transaction?->status->value ?? '', ['pending', 'awaiting_verification']),
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
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right align-top">
                                    <div class="flex items-center justify-end gap-2">
                                        @if ($isRefundView)
                                            <a
                                                href="{{ $registration ? route('admin.registrations.show', $registration) : '#' }}"
                                                class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-semibold bg-[#822021] text-[#FAF8F1] shadow-md shadow-[#B49F9A]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70"
                                            >
                                                Detail
                                                <x-heroicon-o-arrow-up-right class="h-4 w-4" />
                                            </a>
                                            @if ($refund->status === \App\Enums\RefundStatus::Pending)
                                                <form method="POST" action="{{ route('admin.refunds.approve', $refund) }}">
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center rounded-full p-2 bg-emerald-100 text-emerald-600 shadow-md shadow-[#B49F9A]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70"
                                                        title="Setujui refund"
                                                    >
                                                        <x-heroicon-o-check class="h-4 w-4" />
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.refunds.reject', $refund) }}">
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center rounded-full p-2 bg-rose-100 text-rose-600 shadow-md shadow-[#B49F9A]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70"
                                                        title="Tolak refund"
                                                    >
                                                        <x-heroicon-o-x-mark class="h-4 w-4" />
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            @if (($transaction?->status?->value ?? null) === 'awaiting_verification')
                                                <form method="POST" action="{{ route('admin.registrations.verify-payment', $registration) }}">
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center rounded-full p-2 bg-emerald-100 text-emerald-600 shadow-md shadow-[#B49F9A]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70"
                                                        title="Setujui pembayaran"
                                                    >
                                                        <x-heroicon-o-check class="h-4 w-4" />
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.registrations.reject-payment', $registration) }}">
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center rounded-full p-2 bg-rose-100 text-rose-600 shadow-md shadow-[#B49F9A]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70"
                                                        title="Tolak pembayaran"
                                                    >
                                                        <x-heroicon-o-x-mark class="h-4 w-4" />
                                                    </button>
                                                </form>
                                            @endif

                                            <a
                                                href="{{ route('admin.registrations.show', $registration) }}"
                                                class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-semibold bg-[#822021] text-[#FAF8F1] shadow-md shadow-[#B49F9A]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70"
                                            >
                                                Detail
                                                <x-heroicon-o-arrow-up-right class="h-4 w-4" />
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-[#B87A7A]">Belum ada data {{ $isRefundView ? 'refund' : 'pendaftaran' }} pada filter ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-6 flex flex-col gap-3 text-sm text-[#6F4F4F] sm:flex-row sm:items-center sm:justify-between">
        <p>
            Menampilkan
            <span class="font-semibold text-[#C65B74]">{{ $items->firstItem() }}-{{ $items->lastItem() }}</span>
            dari
            <span class="font-semibold text-[#C65B74]">{{ $items->total() }}</span>
            {{ $isRefundView ? 'permintaan refund' : 'pendaftaran' }}.
        </p>
        <div class="sm:ml-auto">{{ $items->links() }}</div>
    </div>
</x-layouts.admin>