@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="'Pengajuan Refund'">
    
    {{-- Custom Style --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body, h1, h2, h3, p, a, span, div, label, input, textarea, button, dt, dd {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Button Hover Effect */
        .btn-action {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-action:hover {
            transform: scale(1.05);
            background-color: #822021 !important;
            color: #FCF5E6 !important;
            border-color: #822021 !important;
        }
    </style>

    {{-- Main Background: FFDEF8 --}}
    <section class="bg-[#FCF5E6] py-12 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('registrations.show', $registration) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#822021] hover:opacity-75 transition-opacity">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                Kembali
            </a>

            {{-- Header Step --}}
            <div class="rounded-[28px] bg-[#822021] px-6 py-3 text-center text-sm font-semibold uppercase tracking-[0.25em] text-[#FCF5E6] shadow-md">
                Step Pengajuan Refund
            </div>

            <div class="grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
                
                {{-- Form Pengajuan (Kiri) --}}
                <div class="space-y-5">
                    {{-- Box: BG FAF8F1, Border 822021 --}}
                    <div class="rounded-[28px] border border-[#822021] bg-[#FAF8F1] p-6 shadow-lg shadow-[#822021]/10">
                        <form method="POST" action="{{ route('registrations.refund.store', $registration) }}" class="space-y-5">
                            @csrf

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-[#822021]">Nama Lengkap</label>
                                    <input value="{{ $registration->user->name }}" disabled class="w-full rounded-2xl border border-[#822021]/40 bg-[#FFDEF8]/50 px-4 py-3 text-sm text-[#822021] font-medium" />
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-[#822021]">Nomor Telepon</label>
                                    <input value="{{ $registration->user->phone ?? '-' }}" disabled class="w-full rounded-2xl border border-[#822021]/40 bg-[#FFDEF8]/50 px-4 py-3 text-sm text-[#822021] font-medium" />
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-[#822021]">Jenis Bank</label>
                                    <input value="{{ data_get($registration->form_data, 'bank_name', 'Nama bank') }}" disabled class="w-full rounded-2xl border border-[#822021]/40 bg-[#FFDEF8]/50 px-4 py-3 text-sm text-[#822021] font-medium" />
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-[#822021]">Atas Nama Rekening</label>
                                    <input value="{{ data_get($registration->form_data, 'account_name', $registration->user->name) }}" disabled class="w-full rounded-2xl border border-[#822021]/40 bg-[#FFDEF8]/50 px-4 py-3 text-sm text-[#822021] font-medium" />
                                </div>
                                <div class="space-y-2 sm:col-span-2">
                                    <label class="block text-sm font-bold text-[#822021]">Nomor Rekening</label>
                                    <input value="{{ data_get($registration->form_data, 'account_number', '-') }}" disabled class="w-full rounded-2xl border border-[#822021]/40 bg-[#FFDEF8]/50 px-4 py-3 text-sm text-[#822021] font-medium" />
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-[#822021]">Alasan Refund (Opsional)</label>
                                <textarea name="reason" rows="3" class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021] placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20" placeholder="Jelaskan alasan pengajuan refund...">{{ old('reason') }}</textarea>
                                @error('reason')
                                    <p class="text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Estimasi Refund Box --}}
                            <div class="rounded-2xl border border-dashed border-[#822021]/40 bg-[#FFDEF8]/30 px-4 py-4 text-sm text-[#822021]">
                                <p class="text-[11px] font-bold uppercase tracking-[0.3em] text-[#822021]/70">Estimasi Refund</p>
                                <div class="mt-3 space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span>Total Pembayaran</span>
                                        <span class="font-bold">Rp{{ number_format($amount, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-[#822021]/80">
                                        <span>Biaya Admin (10%)</span>
                                        <span class="font-semibold">- Rp{{ number_format($adminFee, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between border-t border-[#822021]/20 pt-2 text-[#822021]">
                                        <span class="font-bold">Yang Anda Terima</span>
                                        <span class="text-base font-bold">Rp{{ number_format($netAmount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                                <a href="{{ route('registrations.show', $registration) }}" class="inline-flex items-center justify-center rounded-full border border-[#822021]/40 px-6 py-3 text-sm font-bold text-[#822021] hover:bg-[#822021]/5 transition">Batal</a>
                                
                                {{-- Button Submit: Style Baru --}}
                                <button class="btn-action inline-flex items-center justify-center rounded-full bg-[#FFDEF8] border border-[#822021] px-6 py-3 text-sm font-bold text-[#822021] shadow-md">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Ringkasan Event (Kanan) --}}
                <div class="space-y-5">
                    <div class="rounded-[28px] border border-[#822021] bg-[#FAF8F1] p-6 shadow-lg shadow-[#822021]/10">
                        <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#822021]/60 text-center">Ringkasan Event</p>
                        
                        <div class="mt-4 overflow-hidden rounded-2xl border border-[#822021]/10">
                            {{-- Placeholder Image jika tidak ada cover --}}
                            @if($registration->event->cover_image_url)
                                <img src="{{ $registration->event->cover_image_url }}" class="h-36 w-full object-cover">
                            @else
                                <div class="h-36 bg-[#FFDEF8] flex items-center justify-center text-[#822021]/40 text-xs uppercase tracking-widest">Event Image</div>
                            @endif
                        </div>

                        <h3 class="mt-4 text-xl font-bold text-center text-[#822021]">{{ $registration->event->title }}</h3>
                        <p class="mt-1 text-center text-xs text-[#822021]/70">
                            {{ Str::limit(strip_tags($registration->event->description ?? ''), 100) ?: 'Ringkasan event akan ditampilkan di sini.' }}
                        </p>

                        <div class="mt-5 rounded-2xl bg-[#FFDEF8]/40 border border-[#822021]/10 px-4 py-8">
                            <p class="text-[11px] font-bold uppercase tracking-[0.3em] text-[#822021]/60 text-center">Informasi</p>
                            <dl class="mt-3 space-y-2 text-sm text-[#822021]">
                                <div class="flex justify-between">
                                    <dt class="opacity-80">Tanggal</dt>
                                    <dd class="font-bold">{{ optional($registration->event->start_at)->translatedFormat('d F Y') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="opacity-80">Waktu</dt>
                                    <dd class="font-semibold">{{ optional($registration->event->start_at)->translatedFormat('H:i') }} WIB</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="opacity-80">Harga</dt>
                                    <dd class="font-bold">Rp{{ number_format($amount, 0, ',', '.') }}</dd>
                                </div>
                                <div class="flex justify-between border-t border-[#822021]/10 pt-2">
                                    <dt class="opacity-80">Estimasi Refund</dt>
                                    <dd class="text-base font-bold">Rp{{ number_format($netAmount, 0, ',', '.') }}</dd>
                                </div>
                            </dl>

                            <p class="mt-4 rounded-xl bg-[#822021]/5 px-3 py-2 text-xs text-[#822021]/80 text-center italic border border-[#822021]/10">
                                Proses refund akan diverifikasi dalam 3-7 hari kerja.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layouts.app>