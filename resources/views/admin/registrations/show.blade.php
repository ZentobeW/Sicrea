@php use Illuminate\Support\Facades\Storage; @endphp
<x-layouts.app :title="'Detail Registrasi'">
    <div class="flex justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">{{ $registration->user->name }}</h1>
            <p class="text-sm text-slate-500">{{ $registration->user->email }}</p>
        </div>
        <a href="{{ route('admin.registrations.index') }}" class="text-sm text-slate-500 hover:text-slate-700">&larr; Kembali</a>
    </div>

    <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
        <section class="bg-white rounded-xl border border-slate-100 shadow-sm p-6 space-y-5">
            <div class="grid md:grid-cols-2 gap-4 text-sm text-slate-600">
                <div>
                    <span class="font-medium text-slate-700 block">Event</span>
                    <p>{{ $registration->event->title }}</p>
                    <p class="text-xs text-slate-500">{{ $registration->event->start_at->translatedFormat('d M Y H:i') }}</p>
                </div>
                <div>
                    <span class="font-medium text-slate-700 block">Status Pendaftaran</span>
                    <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-600">{{ $registration->status->label() }}</span>
                </div>
                <div>
                    <span class="font-medium text-slate-700 block">Status Pembayaran</span>
                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">{{ $registration->payment_status->label() }}</span>
                </div>
                <div>
                    <span class="font-medium text-slate-700 block">Nominal</span>
                    <p>Rp{{ number_format($registration->amount, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="border border-dashed border-slate-200 rounded-lg p-4">
                <h2 class="text-sm font-semibold text-slate-700 mb-2">Data Peserta</h2>
                <dl class="grid md:grid-cols-2 gap-x-6 gap-y-2 text-sm text-slate-600">
                    @foreach ($registration->form_data as $key => $value)
                        <div>
                            <dt class="font-medium text-slate-700 capitalize">{{ str_replace('_', ' ', $key) }}</dt>
                            <dd>{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            @if ($registration->payment_proof_path)
                <div class="border border-slate-200 rounded-lg p-4">
                    <h2 class="text-sm font-semibold text-slate-700 mb-2">Bukti Pembayaran</h2>
                    <a href="{{ Storage::disk('public')->url($registration->payment_proof_path) }}" target="_blank" class="text-indigo-600 text-sm">Lihat Bukti</a>
                </div>
            @endif
        </section>

        <aside class="space-y-6">
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-6 space-y-4">
                <h2 class="text-lg font-semibold text-slate-800">Tindakan Admin</h2>
                @if ($registration->payment_status->value === 'awaiting_verification')
                    <form method="POST" action="{{ route('admin.registrations.verify-payment', $registration) }}">
                        @csrf
                        <button class="w-full rounded-md bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Verifikasi Pembayaran</button>
                    </form>
                    <form method="POST" action="{{ route('admin.registrations.reject-payment', $registration) }}">
                        @csrf
                        <button class="w-full rounded-md bg-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">Tolak Pembayaran</button>
                    </form>
                @endif
            </div>

            @if ($registration->refundRequest)
                <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-slate-800">Permintaan Refund</h2>
                    <p class="text-sm text-slate-600">Status: {{ $registration->refundRequest->status->label() }}</p>
                    <p class="text-sm text-slate-600">Alasan: {{ $registration->refundRequest->reason ?? '-' }}</p>

                    @if ($registration->refundRequest->status->value === 'pending')
                        <div class="space-y-3">
                            <form method="POST" action="{{ route('admin.refunds.approve', $registration->refundRequest) }}">
                                @csrf
                                <button class="w-full rounded-md bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Setujui Refund</button>
                            </form>
                            <form method="POST" action="{{ route('admin.refunds.reject', $registration->refundRequest) }}">
                                @csrf
                                <button class="w-full rounded-md bg-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">Tolak Refund</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endif
        </aside>
    </div>
</x-layouts.app>
