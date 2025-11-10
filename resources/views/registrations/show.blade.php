<x-layouts.app :title="'Detail Pendaftaran'">
    <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
        <section class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-800">{{ $registration->event->title }}</h1>
                    <p class="text-sm text-slate-500">{{ $registration->event->start_at->translatedFormat('d M Y H:i') }}</p>
                </div>
                <div class="text-right text-sm">
                    <span class="block text-slate-500">Status Pendaftaran</span>
                    <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-600">{{ $registration->status->label() }}</span>
                </div>
            </div>

            @php($transaction = $registration->transaction)

            <div class="grid md:grid-cols-2 gap-4 text-sm text-slate-600">
                <div>
                    <span class="font-medium text-slate-700 block">Pembayaran</span>
                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">{{ $transaction?->status->label() ?? 'Belum Dibuat' }}</span>
                </div>
                <div>
                    <span class="font-medium text-slate-700 block">Nominal</span>
                    <p>Rp{{ number_format($transaction?->amount ?? 0, 0, ',', '.') }}</p>
                </div>
                <div>
                    <span class="font-medium text-slate-700 block">Tanggal Daftar</span>
                    <p>{{ optional($registration->registered_at)->translatedFormat('d M Y H:i') }}</p>
                </div>
                <div>
                    <span class="font-medium text-slate-700 block">Venue</span>
                    <p class="font-semibold text-slate-700">{{ $registration->event->venue_name }}</p>
                    <p>{{ $registration->event->venue_address }}</p>
                </div>
                <div>
                    <span class="font-medium text-slate-700 block">Pemateri</span>
                    <p>{{ $registration->event->tutor_name }}</p>
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
        </section>

        <aside class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 space-y-4">
                <h2 class="text-lg font-semibold text-slate-800">Pembayaran</h2>
                <p class="text-sm text-slate-600">Silakan lakukan pembayaran dan unggah bukti untuk diproses admin.</p>

                @if ($transaction?->payment_proof_path)
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm">
                        Bukti pembayaran telah diunggah pada {{ optional($transaction->paid_at)->translatedFormat('d M Y H:i') }}.
                    </div>
                @endif

                @if ($transaction?->status !== \App\Enums\PaymentStatus::Verified)
                    <form method="POST" action="{{ route('registrations.payment-proof', $registration) }}" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Unggah Bukti Pembayaran</label>
                            <input type="file" name="payment_proof"
                                class="mt-1 block w-full text-sm text-slate-600 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-indigo-700" required>
                            <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG, atau PDF. Maksimal 5MB.</p>
                        </div>
                        <button class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Kirim Bukti</button>
                    </form>
                @endif
            </div>

            @if ($transaction?->status === \App\Enums\PaymentStatus::Verified)
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 space-y-3">
                    <h2 class="text-lg font-semibold text-slate-800">Pengajuan Refund</h2>
                    @if ($transaction?->refund)
                        <p class="text-sm text-slate-600">Status refund: {{ $transaction->refund->status->label() }}.</p>
                    @else
                        <form method="POST" action="{{ route('registrations.refund.store', $registration) }}" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Alasan Refund</label>
                                <textarea name="reason" rows="3" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('reason') }}</textarea>
                            </div>
                            <button class="inline-flex items-center rounded-md bg-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">Ajukan Refund</button>
                        </form>
                    @endif
                </div>
            @endif
        </aside>
    </div>
</x-layouts.app>
