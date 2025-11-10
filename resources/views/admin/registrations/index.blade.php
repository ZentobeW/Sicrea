@php($tabs = [
    ['label' => 'Event', 'route' => route('admin.events.index'), 'active' => request()->routeIs('admin.events.*'), 'icon' => 'calendar'],
    ['label' => 'Pendaftaran', 'route' => route('admin.registrations.index'), 'active' => request()->routeIs('admin.registrations.*'), 'icon' => 'document-text'],
    ['label' => 'Portofolio', 'route' => route('admin.portfolios.index'), 'active' => request()->routeIs('admin.portfolios.*'), 'icon' => 'photo'],
])

<x-layouts.admin title="Registrasi Peserta" subtitle="Verifikasi pembayaran, kelola permohonan refund, dan pastikan setiap peserta siap mengikuti workshop." :tabs="$tabs">
    <x-slot name="actions">
        <a href="{{ route('admin.registrations.export', request()->all()) }}" class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-lg shadow-emerald-500/20 transition hover:-translate-y-0.5 hover:bg-slate-100">
            <span class="text-lg">⇩</span>
            Export CSV
        </a>
    </x-slot>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-slate-200/60 bg-white/90 p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Registrasi</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $summary['total'] }}</p>
        </div>
        <div class="rounded-2xl border border-amber-200/70 bg-amber-50/90 p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-amber-600">Menunggu Pembayaran</p>
            <p class="mt-2 text-2xl font-semibold text-amber-700">{{ $summary['pendingPayment'] }}</p>
        </div>
        <div class="rounded-2xl border border-emerald-200/70 bg-emerald-50/80 p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-emerald-600">Terverifikasi</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-700">{{ $summary['verifiedPayment'] }}</p>
        </div>
        <div class="rounded-2xl border border-rose-200/70 bg-rose-50/80 p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-rose-600">Permintaan Refund</p>
            <p class="mt-2 text-2xl font-semibold text-rose-700">{{ $summary['refundRequests'] }}</p>
        </div>
    </div>

    <form method="GET" class="rounded-3xl border border-slate-200/60 bg-white/90 p-6 shadow-xl grid gap-4 md:grid-cols-4 text-sm">
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-slate-700">Filter Event</label>
            <select name="event_id" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-inner focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Semua Event</option>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}" @selected(request('event_id') == $event->id)>{{ $event->title }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700">Status Pembayaran</label>
            <select name="payment_status" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-inner focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Semua</option>
                @foreach (\App\Enums\PaymentStatus::cases() as $status)
                    <option value="{{ $status->value }}" @selected(request('payment_status') === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-indigo-600 px-4 py-2 font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:-translate-y-0.5 hover:bg-indigo-700">Terapkan Filter</button>
        </div>
    </form>

    <div class="rounded-3xl border border-slate-200/60 bg-white/90 shadow-xl">
        <div class="flex flex-col gap-4 border-b border-slate-200/60 p-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Daftar Registrasi</h2>
                <p class="text-sm text-slate-500">Klik detail untuk memverifikasi pembayaran atau meninjau bukti transfer.</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200/70 text-sm">
                <thead class="bg-slate-50/80 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">Peserta</th>
                        <th class="px-6 py-3 text-left">Event</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Pembayaran</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/60 bg-white/60">
                    @forelse ($registrations as $registration)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-6 py-4 align-top">
                                <div class="font-semibold text-slate-900">{{ $registration->user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $registration->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="font-semibold text-slate-900">{{ $registration->event->title }}</div>
                                <div class="text-xs text-slate-500">{{ optional($registration->registered_at)->translatedFormat('d M Y H:i') }}</div>
                                <div class="text-[11px] text-slate-500">{{ $registration->event->venue_name }}</div>
                                <div class="text-[11px] text-slate-500">Tutor: {{ $registration->event->tutor_name }}</div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <span class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">
                                    <span class="h-2 w-2 rounded-full bg-indigo-400"></span>
                                    {{ $registration->status->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <span @class([
                                    'inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold transition',
                                    'bg-emerald-100 text-emerald-600 ring-1 ring-emerald-500/20' => $registration->payment_status->value === 'verified',
                                    'bg-amber-100 text-amber-600 ring-1 ring-amber-500/20' => $registration->payment_status->value === 'pending',
                                    'bg-rose-100 text-rose-600 ring-1 ring-rose-500/20' => $registration->payment_status->value === 'rejected',
                                    'bg-slate-100 text-slate-600 ring-1 ring-slate-500/10' => ! in_array($registration->payment_status->value, ['verified', 'pending', 'rejected']),
                                ])>
                                    <span class="h-2 w-2 rounded-full {{ match ($registration->payment_status->value) {
                                        'verified' => 'bg-emerald-500',
                                        'pending' => 'bg-amber-500',
                                        'rejected' => 'bg-rose-500',
                                        default => 'bg-slate-400',
                                    } }}"></span>
                                    {{ $registration->payment_status->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right align-top">
                                <a href="{{ route('admin.registrations.show', $registration) }}" class="inline-flex items-center gap-2 rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600 transition hover:border-indigo-300 hover:bg-indigo-100">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada data registrasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-between items-center text-sm text-slate-500">
        <div>Menampilkan {{ $registrations->firstItem() }}-{{ $registrations->lastItem() }} dari {{ $registrations->total() }} registrasi</div>
        <div>{{ $registrations->links() }}</div>
    </div>
</x-layouts.admin>
