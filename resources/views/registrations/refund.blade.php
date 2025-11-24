@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="'Pengajuan Refund'">
    <section class="bg-gradient-to-br from-[#FFE3D3] via-[#FFF3EA] to-white py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <a href="{{ route('registrations.show', $registration) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#C65B74] hover:text-[#A2475D]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                Kembali
            </a>

            <div class="rounded-[28px] bg-[#FDE4F0] px-6 py-3 text-center text-sm font-semibold uppercase tracking-[0.25em] text-[#7C3A2D] shadow-inner shadow-[#F4B59E]/30">
                Step Pengajuan Refund
            </div>

            <div class="grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
                <div class="space-y-5">
                    <div class="rounded-[28px] border border-[#FAD6C7] bg-white/95 p-6 shadow-lg shadow-[#FAD6C7]/40">
                        <form method="POST" action="{{ route('registrations.refund.store', $registration) }}" class="space-y-5">
                            @csrf

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2C1E1E]">Nama Lengkap</label>
                                    <input value="{{ $registration->user->name }}" disabled class="w-full rounded-2xl border border-[#FAD6C7] bg-white/80 px-4 py-3 text-sm text-[#2C1E1E]" />
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2C1E1E]">Nomor Telepon</label>
                                    <input value="{{ $registration->user->phone ?? '-' }}" disabled class="w-full rounded-2xl border border-[#FAD6C7] bg-white/80 px-4 py-3 text-sm text-[#2C1E1E]" />
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2C1E1E]">Jenis Bank</label>
                                    <input value="{{ data_get($registration->form_data, 'bank_name', 'Nama bank') }}" disabled class="w-full rounded-2xl border border-[#FAD6C7] bg-white/80 px-4 py-3 text-sm text-[#2C1E1E]" />
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2C1E1E]">Atas Nama Rekening</label>
                                    <input value="{{ data_get($registration->form_data, 'account_name', $registration->user->name) }}" disabled class="w-full rounded-2xl border border-[#FAD6C7] bg-white/80 px-4 py-3 text-sm text-[#2C1E1E]" />
                                </div>
                                <div class="space-y-2 sm:col-span-2">
                                    <label class="block text-sm font-semibold text-[#2C1E1E]">Nomor Rekening</label>
                                    <input value="{{ data_get($registration->form_data, 'account_number', '-') }}" disabled class="w-full rounded-2xl border border-[#FAD6C7] bg-white/80 px-4 py-3 text-sm text-[#2C1E1E]" />
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-[#2C1E1E]">Alasan Refund (Opsional)</label>
                                <textarea name="reason" rows="3" class="w-full rounded-2xl border border-[#FAD6C7] bg-white/80 px-4 py-3 text-sm text-[#2C1E1E] placeholder:text-[#B07A7A] focus:border-[#FF8A64] focus:outline-none focus:ring-2 focus:ring-[#FF8A64]/40" placeholder="Jelaskan alasan pengajuan refund...">{{ old('reason') }}</textarea>
                                @error('reason')
                                    <p class="text-xs font-medium text-[#BA1B1D]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="rounded-2xl border border-dashed border-[#FAD6C7] bg-[#FFF8F3] px-4 py-4 text-sm text-[#6F4F4F]">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Estimasi Refund</p>
                                <div class="mt-3 space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span>Total Pembayaran</span>
                                        <span class="font-semibold text-[#7C3A2D]">Rp{{ number_format($amount, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Biaya Admin (10%)</span>
                                        <span class="font-semibold text-[#C65B74]">Rp{{ number_format($adminFee, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between border-t border-[#FAD6C7]/70 pt-2">
                                        <span class="font-semibold text-[#2C1E1E]">Yang Anda Terima</span>
                                        <span class="text-base font-semibold text-[#2C1E1E]">Rp{{ number_format($netAmount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                                <a href="{{ route('registrations.show', $registration) }}" class="inline-flex items-center justify-center rounded-full border border-[#FAD6C7] px-6 py-3 text-sm font-semibold text-[#C65B74] hover:bg-[#FFF0E6] transition">Batal</a>
                                <button class="inline-flex items-center justify-center rounded-full bg-[#822021] px-6 py-3 text-sm font-semibold text-[#FAF8F1] shadow-md shadow-[#B49F9A]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="rounded-[28px] border border-[#FAD6C7] bg-white/95 p-6 shadow-lg shadow-[#FAD6C7]/40 backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74] text-center">Ringkasan Event</p>
                        <div class="mt-4 overflow-hidden rounded-2xl">
                            <div class="h-36 bg-gradient-to-br from-[#FFE1D0] to-[#FFD2C0]"></div>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-center text-[#2C1E1E]">{{ $registration->event->title }}</h3>
                        <p class="mt-1 text-center text-xs text-[#9A5A46]">
                            {{ Str::limit(strip_tags($registration->event->description ?? ''), 100) ?: 'Ringkasan event akan ditampilkan di sini.' }}
                        </p>

                        <div class="mt-5 rounded-2xl bg-[#FFF8F3] px-4 py-4">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74] text-center">Tabel Informasi</p>
                            <dl class="mt-3 space-y-2 text-sm text-[#6F4F4F]">
                                <div class="flex justify-between">
                                    <dt>Tanggal Event</dt>
                                    <dd class="font-semibold text-[#2C1E1E]">{{ optional($registration->event->start_at)->translatedFormat('d F Y') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Waktu</dt>
                                    <dd>{{ optional($registration->event->start_at)->translatedFormat('H:i') }} - {{ optional($registration->event->end_at)->translatedFormat('H:i') }} WIB</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Tempat</dt>
                                    <dd class="text-right">{{ $registration->event->venue_name }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Harga Event</dt>
                                    <dd class="font-semibold text-[#7C3A2D]">Rp{{ number_format($amount, 0, ',', '.') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>ID Pendaftaran</dt>
                                    <dd class="font-semibold text-[#7C3A2D]">reg{{ $registration->id }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Biaya Admin (10%)</dt>
                                    <dd class="font-semibold text-[#C65B74]">Rp{{ number_format($adminFee, 0, ',', '.') }}</dd>
                                </div>
                                <div class="flex justify-between border-t border-[#FAD6C7]/60 pt-2">
                                    <dt class="font-semibold text-[#2C1E1E]">Estimasi Refund</dt>
                                    <dd class="text-base font-semibold text-[#2C1E1E]">Rp{{ number_format($netAmount, 0, ',', '.') }}</dd>
                                </div>
                            </dl>

                            <p class="mt-4 rounded-xl bg-[#FFF1EC] px-3 py-2 text-xs text-[#9A5A46]">
                                Catatan: Proses refund akan diverifikasi dalam 3-7 hari kerja. Dana akan ditransfer ke rekening yang terdaftar setelah disetujui.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
