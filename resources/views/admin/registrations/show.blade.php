@php($tabs = $tabs ?? [
    ['label' => 'Event', 'route' => route('admin.events.index'), 'active' => request()->routeIs('admin.events.*'), 'icon' => 'calendar'],
    ['label' => 'Pendaftaran', 'route' => route('admin.registrations.index'), 'active' => request()->routeIs('admin.registrations.*'), 'icon' => 'document-text'],
    ['label' => 'Portofolio', 'route' => route('admin.portfolios.index'), 'active' => request()->routeIs('admin.portfolios.*'), 'icon' => 'photo'],
])

@php use Illuminate\Support\Facades\Storage; @endphp


@php($transaction = $registration->transaction)

<x-layouts.admin :title="$registration->user->name" :subtitle="$registration->user->email" :tabs="$tabs" :back-url="route('admin.registrations.index')">
    <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
        <section class="space-y-6 rounded-3xl border border-slate-200/60 bg-white/95 p-6 sm:p-8 shadow-xl">
            <div class="grid gap-4 md:grid-cols-2 text-sm text-slate-600">
                <div>
                    <span class="font-semibold text-slate-700 block">Event</span>
                    <p class="mt-1 text-base font-semibold text-slate-900">{{ $registration->event->title }}</p>
                    <p class="text-xs text-slate-500">{{ $registration->event->start_at->translatedFormat('d M Y H:i') }}</p>
                    <p class="text-xs text-slate-500">{{ $registration->event->venue_name }}</p>
                    <p class="text-xs text-slate-500">{{ $registration->event->venue_address }}</p>
                    <p class="text-[11px] text-slate-500">Tutor: {{ $registration->event->tutor_name }}</p>
                </div>
                <div>
                    <span class="font-semibold text-slate-700 block">Status Pendaftaran</span>
                    <span class="mt-1 inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">
                        <span class="h-2 w-2 rounded-full bg-indigo-400"></span>
                        {{ $registration->status->label() }}
                    </span>
                </div>
                <div>
                    <span class="font-semibold text-slate-700 block">Status Pembayaran</span>
                    <span @class([
                        'mt-1 inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold transition',
                        'bg-emerald-100 text-emerald-600 ring-1 ring-emerald-500/20' => ($transaction?->status?->value ?? null) === 'verified',
                        'bg-amber-100 text-amber-600 ring-1 ring-amber-500/20' => ($transaction?->status?->value ?? null) === 'pending',
                        'bg-rose-100 text-rose-600 ring-1 ring-rose-500/20' => ($transaction?->status?->value ?? null) === 'rejected',
                        'bg-slate-100 text-slate-600 ring-1 ring-slate-500/10' => ! in_array($transaction?->status?->value ?? '', ['verified', 'pending', 'rejected']),
                    ])>
                        <span class="h-2 w-2 rounded-full {{ match ($transaction?->status?->value) {
                            'verified' => 'bg-emerald-500',
                            'pending' => 'bg-amber-500',
                            'rejected' => 'bg-rose-500',
                            default => 'bg-slate-400',
                        } }}"></span>
                        {{ $transaction?->status->label() ?? 'Tidak ada data' }}
                    </span>
                </div>
                <div>
                    <span class="font-semibold text-slate-700 block">Nominal</span>
                    <p class="mt-1 text-base font-semibold text-slate-900">Rp{{ number_format($registration->amount ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="rounded-2xl border border-dashed border-slate-200 bg-white/80 p-6">
                <h2 class="text-sm font-semibold text-slate-700">Data Peserta</h2>
                <dl class="mt-4 grid gap-x-6 gap-y-3 md:grid-cols-2 text-sm text-slate-600">
                    @foreach ($registration->form_data as $key => $value)
                        <div>
                            <dt class="font-medium text-slate-700 capitalize">{{ str_replace('_', ' ', $key) }}</dt>
                            <dd class="mt-1">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            @if ($registration->payment_proof_path)
                <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-6">
                    <h2 class="text-sm font-semibold text-slate-700">Bukti Pembayaran</h2>
                    <p class="mt-2 text-sm text-slate-500">Periksa kecocokan nominal dan detail transfer sebelum verifikasi.</p>
                    <a href="{{ Storage::disk('public')->url($registration->payment_proof_path) }}" target="_blank" class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700">Lihat Bukti →</a>
                </div>
            @endif

            <div class="rounded-2xl border border-dashed border-slate-200 bg-white/80 p-6">
                <h2 class="text-sm font-semibold text-slate-700">Riwayat Aktivitas</h2>
                <ol class="mt-4 space-y-3 text-sm text-slate-600">
                    <li class="flex items-start gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-slate-400"></span>
                        <div>
                            <p class="font-medium text-slate-700">Pendaftaran dibuat</p>
                            <p class="text-xs text-slate-500">{{ optional($registration->registered_at)->translatedFormat('d M Y H:i') ?? '-' }}</p>
                        </div>
                    </li>
                    @if ($transaction?->paid_at)
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2 w-2 rounded-full bg-amber-500"></span>
                            <div>
                                <p class="font-medium text-slate-700">Bukti pembayaran diunggah</p>
                                <p class="text-xs text-slate-500">{{ $transaction->paid_at->translatedFormat('d M Y H:i') }}</p>
                            </div>
                        </li>
                    @endif
                    @if ($transaction?->verified_at)
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span>
                            <div>
                                <p class="font-medium text-slate-700">Pembayaran terverifikasi</p>
                                <p class="text-xs text-slate-500">{{ $transaction->verified_at->translatedFormat('d M Y H:i') }}</p>
                            </div>
                        </li>
                    @endif
                    @if ($transaction?->refund)
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2 w-2 rounded-full bg-indigo-500"></span>
                            <div>
                                <p class="font-medium text-slate-700">Refund diminta</p>
                                <p class="text-xs text-slate-500">{{ optional($transaction->refund->requested_at)->translatedFormat('d M Y H:i') ?? '-' }}</p>
                            </div>
                        </li>
                        @if ($transaction->refund->processed_at)
                            <li class="flex items-start gap-3">
                                <span class="mt-1 h-2 w-2 rounded-full {{ in_array($transaction->refund->status->value, ['approved', 'completed']) ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                <div>
                                    <p class="font-medium text-slate-700">Refund diproses ({{ $transaction->refund->status->label() }})</p>
                                    <p class="text-xs text-slate-500">{{ $transaction->refund->processed_at->translatedFormat('d M Y H:i') }}</p>
                                </div>
                            </li>
                        @endif
                    @endif
                </ol>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-white/60 bg-white/80 p-6 shadow-xl backdrop-blur">
                <h2 class="text-base font-semibold text-slate-800">Tindakan Admin</h2>
                <p class="mt-2 text-sm text-slate-500">Verifikasi pembayaran atau mintalah peserta mengunggah ulang jika data belum valid.</p>
                <div class="mt-4 space-y-3">
                    @if ($transaction?->status?->value === 'awaiting_verification')
                        <form method="POST" action="{{ route('admin.registrations.verify-payment', $registration) }}">
                            @csrf
                            <button class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:-translate-y-0.5 hover:bg-emerald-600">Verifikasi Pembayaran</button>
                        </form>
                        <form method="POST" action="{{ route('admin.registrations.reject-payment', $registration) }}">
                            @csrf
                            <button class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-rose-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-rose-500/30 transition hover:-translate-y-0.5 hover:bg-rose-600">Tolak Pembayaran</button>
                        </form>
                    @else
                        <p class="text-sm text-slate-500">Pembayaran telah diproses. Anda dapat mengelola refund jika diperlukan.</p>
                    @endif
                </div>
            </div>

            @if ($transaction?->refund)
                <div class="rounded-3xl border border-white/60 bg-white/80 p-6 shadow-xl backdrop-blur">
                    <h2 class="text-base font-semibold text-slate-800">Permintaan Refund</h2>
                    <p class="mt-2 text-sm text-slate-500">Status: <span class="font-semibold text-slate-700">{{ $transaction->refund->status->label() }}</span></p>
                    <p class="mt-2 text-sm text-slate-500">Alasan peserta:</p>
                    <p class="mt-1 rounded-2xl border border-slate-200 bg-slate-50/80 px-4 py-3 text-sm text-slate-600">{{ $transaction->refund->reason ?? '-' }}</p>

                    @if ($transaction->refund->status->value === 'pending')
                        <div class="mt-4 space-y-3">
                            <form method="POST" action="{{ route('admin.refunds.approve', $transaction->refund) }}">
                                @csrf
                                <button class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:-translate-y-0.5 hover:bg-emerald-600">Setujui Refund</button>
                            </form>
                            <form method="POST" action="{{ route('admin.refunds.reject', $transaction->refund) }}">
                                @csrf
                                <button class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-amber-500/30 transition hover:-translate-y-0.5 hover:bg-amber-600">Tolak Refund</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endif

            <div class="rounded-3xl border border-white/60 bg-white/80 p-6 shadow-xl backdrop-blur">
                <h2 class="text-base font-semibold text-slate-800">Riwayat Email</h2>
                @if($registration->emails->isEmpty())
                    <p class="mt-2 text-sm text-slate-500">Belum ada email yang tercatat untuk pendaftaran ini.</p>
                @else
                    <ul class="mt-3 space-y-3 text-sm">
                        @foreach ($registration->emails as $email)
                            <li class="rounded-2xl border border-slate-200 bg-white/60 px-4 py-3">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-slate-700">{{ $email->subject }}</span>
                                    <span class="text-xs text-slate-500">{{ optional($email->sent_at)->translatedFormat('d M Y H:i') ?? '-' }}</span>
                                </div>
                                <p class="mt-1 text-xs text-slate-500">Dikirim ke: {{ $email->recipient }}</p>
                                <p class="mt-0.5 text-[11px] text-slate-500">Tipe: {{ str_replace('_', ' ', $email->type) }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </aside>
    </div>
</x-layouts.admin>
