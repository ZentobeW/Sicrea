<x-layouts.app :title="'Daftar Workshop'">
    {{-- Custom Style --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        /* Set Default Font to Poppins */
        body, h1, h2, h3, p, a, span, div, input, select, textarea, button, label {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Button Hover Effect (Zoom In & Color Change) */
        .btn-action {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-action:hover {
            transform: scale(1.05); /* Zoom In */
            background-color: #822021 !important;
            color: #FCF5E6 !important;
            border-color: #822021 !important;
        }
    </style>

    {{-- Main Background: FFDEF8 --}}
    <section class="bg-[#FCF5E6] py-8 md:py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Back Link --}}
            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#822021] hover:opacity-75 transition-opacity">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Detail Event
            </a>

            <div class="mt-4 md:mt-6 grid gap-4 md:gap-8 lg:grid-cols-[minmax(0,2fr),minmax(0,1fr)]">
                
                {{-- Left Column: Form Container --}}
                {{-- Box Color: FAF8F1, Border: 822021 --}}
                <div class="rounded-2xl md:rounded-[32px] border border-[#822021] bg-[#FAF8F1] p-4 md:p-6 lg:p-8 shadow-lg shadow-[#822021]/10">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="text-center md:text-left">
                            <p class="text-xs md:text-sm font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Step Pendaftaran</p>
                            <h1 class="mt-2 text-xl md:text-2xl lg:text-3xl font-bold text-[#822021]">Lengkapi Data Peserta</h1>
                        </div>
                        <div class="flex items-center justify-center md:justify-start gap-2 text-sm font-semibold text-[#822021]">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#822021] text-[#FAF8F1] font-bold">1</span>
                            <span>Langkah 1 dari 3</span>
                        </div>
                    </div>

                    {{-- Progress Indicators --}}
                    <div class="mt-4 md:mt-6 grid gap-2 md:gap-3 grid-cols-1 sm:grid-cols-3">
                        <div class="rounded-xl md:rounded-2xl border border-[#822021] bg-[#FFDEF8] px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm font-semibold text-[#822021] text-center">Data Peserta</div>
                        <div class="rounded-xl md:rounded-2xl border border-dashed border-[#822021]/40 px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm font-semibold text-[#822021]/60 text-center">Informasi Pembayaran</div>
                        <div class="rounded-xl md:rounded-2xl border border-dashed border-[#822021]/40 px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm font-semibold text-[#822021]/60 text-center">Konfirmasi</div>
                    </div>

                    <div class="mt-6 md:mt-8">
                        <form method="POST" action="{{ route('events.register.store', $event) }}" class="space-y-4 md:space-y-6">
                            @csrf

                            {{-- Radio Buttons: Pribadi / Orang Lain --}}
                            {{-- Exception: Tidak pakai efek zoom in tombol utama --}}
                            <div class="flex flex-wrap gap-2 md:gap-3 rounded-full bg-[#FCF5E6] p-2 text-sm font-semibold text-[#822021]">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="form_data[participant_mode]" value="self" checked class="peer hidden">
                                    <span class="flex h-10 md:h-11 w-full items-center justify-center rounded-full bg-white/50 px-3 md:px-4 py-2 transition peer-checked:bg-[#822021] peer-checked:text-[#FCF5E6] text-center border border-transparent peer-checked:border-[#822021]">Pribadi</span>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="form_data[participant_mode]" value="other" class="peer hidden">
                                    <span class="flex h-10 md:h-11 w-full items-center justify-center rounded-full bg-white/50 px-3 md:px-4 py-2 transition peer-checked:bg-[#822021] peer-checked:text-[#FCF5E6] text-center border border-transparent peer-checked:border-[#822021]">Orang Lain</span>
                                </label>
                            </div>

                            <div class="grid gap-4 md:gap-5 grid-cols-1 md:grid-cols-2">
                                <div class="space-y-2">
                                    <label class="block text-sm md:text-base font-bold text-[#822021]">Nama Lengkap</label>
                                    <input type="text" name="form_data[name]" value="{{ old('form_data.name', auth()->user()->name) }}" required class="w-full rounded-xl md:rounded-2xl border border-[#822021]/40 bg-white px-3 md:px-4 py-2 md:py-3 text-sm md:text-base text-[#822021] placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20" placeholder="Masukkan nama sesuai identitas">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm md:text-base font-bold text-[#822021]">Email</label>
                                    <input type="email" name="form_data[email]" value="{{ old('form_data.email', auth()->user()->email) }}" required class="w-full rounded-xl md:rounded-2xl border border-[#822021]/40 bg-white px-3 md:px-4 py-2 md:py-3 text-sm md:text-base text-[#822021] placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20" placeholder="contoh@email.com">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm md:text-base font-bold text-[#822021]">Nomor Telepon</label>
                                    <input type="text" name="form_data[phone]" value="{{ old('form_data.phone', auth()->user()->phone) }}" required class="w-full rounded-xl md:rounded-2xl border border-[#822021]/40 bg-white px-3 md:px-4 py-2 md:py-3 text-sm md:text-base text-[#822021] placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20" placeholder="0812-xxxx-xxxx">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm md:text-base font-bold text-[#822021]">Jenis Bank</label>
                                    <select name="form_data[bank_name]" required class="w-full rounded-xl md:rounded-2xl border border-[#822021]/40 bg-white px-3 md:px-4 py-2 md:py-3 text-sm md:text-base text-[#822021] focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20">
                                        <option value="" disabled {{ old('form_data.bank_name') ? '' : 'selected' }}>Pilih bank</option>
                                        @php
                                            $banks = [
                                                'BCA', 'Mandiri', 'BRI', 'BNI', 'BTN', 'CIMB Niaga', 'Permata', 'BSI', 'OCBC NISP', 'Danamon', 'Bank Jatim', 'Bank Jateng', 'Bank BJB', 'Bank Mega', 'Maybank', 'Panin', 'Sinarmas'
                                            ];
                                        @endphp
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank }}" @selected(old('form_data.bank_name') === $bank)>{{ $bank }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm md:text-base font-bold text-[#822021]">Nomor Rekening</label>
                                    <input type="text" name="form_data[account_number]" value="{{ old('form_data.account_number') }}" required class="w-full rounded-xl md:rounded-2xl border border-[#822021]/40 bg-white px-3 md:px-4 py-2 md:py-3 text-sm md:text-base text-[#822021] placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20" placeholder="1234 5678 9000">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm md:text-base font-bold text-[#822021]">Instansi / Perusahaan <span class="text-[#822021]/60 font-normal">(opsional)</span></label>
                                    <input type="text" name="form_data[company]" value="{{ old('form_data.company') }}" class="w-full rounded-xl md:rounded-2xl border border-[#822021]/40 bg-white px-3 md:px-4 py-2 md:py-3 text-sm md:text-base text-[#822021] placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20" placeholder="Nama instansi">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm md:text-base font-bold text-[#822021]">Catatan Tambahan <span class="text-[#822021]/60 font-normal">(opsional)</span></label>
                                <textarea name="form_data[notes]" rows="3" class="w-full rounded-xl md:rounded-2xl border border-[#822021]/40 bg-white px-3 md:px-4 py-2 md:py-3 text-sm md:text-base text-[#822021] placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20" placeholder="Tuliskan preferensi atau kebutuhan khusus"></textarea>
                            </div>

                            <div class="flex flex-col md:flex-row items-center justify-between gap-3 pt-4">
                                <p class="text-xs md:text-sm text-[#822021]/70 text-center md:text-left">Dengan melanjutkan, Anda menyetujui ketentuan dan kebijakan privasi Kreasi Hangat.</p>
                                <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                                    <a href="{{ route('events.show', $event) }}" class="w-full sm:w-auto text-sm font-semibold text-[#822021] hover:text-[#822021]/80 text-center">Batal</a>
                                    
                                    {{-- Button Lanjutkan: BG FFDEF8, Text 822021, Border 822021. Hover: Zoom, BG 822021, Text Putih --}}
                                    <button class="btn-action w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-full bg-[#FFDEF8] border-2 border-[#822021] px-4 md:px-6 py-2 md:py-3 text-sm font-bold text-[#822021] shadow-md">
                                        Lanjutkan
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Right Column: Summary --}}
                <aside class="space-y-4 md:space-y-6">
                    {{-- Summary Box: Color FAF8F1, Border 822021 --}}
                    <div class="rounded-2xl md:rounded-[32px] border border-[#822021] bg-[#FAF8F1] p-4 md:p-6 shadow-lg">
                        <h2 class="text-lg md:text-xl font-bold text-[#822021]">Ringkasan Event</h2>
                        <div class="mt-4 space-y-3 md:space-y-4 text-sm">
                            <div class="rounded-xl md:rounded-2xl bg-[#822021] px-3 md:px-4 py-3 text-[#FCF5E6] font-bold text-center">
                                {{ $event->title }}
                            </div>
                            <dl class="space-y-3">
                                <div class="flex items-start justify-between gap-3">
                                    <dt class="text-[#822021]/70">Tanggal</dt>
                                    <dd class="text-right text-[#822021] font-semibold">{{ $event->start_at->translatedFormat('d F Y') }}</dd>
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <dt class="text-[#822021]/70">Waktu</dt>
                                    <dd class="text-right text-[#822021] font-semibold">{{ $event->start_at->translatedFormat('H:i') }} - {{ $event->end_at->translatedFormat('H:i') }} WIB</dd>
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <dt class="text-[#822021]/70">Venue</dt>
                                    <dd class="text-right">
                                        <span class="block font-bold text-[#822021]">{{ $event->venue_name }}</span>
                                        <span class="block text-xs text-[#822021]/70">{{ $event->venue_address }}</span>
                                    </dd>
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <dt class="text-[#822021]/70">Pemateri</dt>
                                    <dd class="text-right text-[#822021] font-semibold">{{ $event->tutor_name }}</dd>
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <dt class="text-[#822021]/70">Kuota</dt>
                                    <dd class="text-right text-[#822021] font-semibold">{{ $event->remainingSlots() ?? 'Tidak terbatas' }}</dd>
                                </div>
                            </dl>
                            <div class="rounded-xl md:rounded-2xl border border-[#822021] px-3 md:px-4 py-3 text-sm bg-white">
                                <div class="flex items-center justify-between font-bold">
                                    <span class="text-[#822021]">Total Pembayaran</span>
                                    <span class="text-[#822021]">Rp{{ number_format($event->price, 0, ',', '.') }}</span>
                                </div>
                                <p class="mt-2 text-xs text-[#822021]/70">Biaya sudah termasuk materi, alat pendukung, dan akses rekaman.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Tips Box --}}
                    <div class="rounded-2xl md:rounded-[28px] border border-dashed border-[#822021] bg-[#FAF8F1] p-4 md:p-6 text-sm shadow-sm">
                        <h3 class="text-base md:text-lg font-bold text-[#822021]">Tips Pendaftaran</h3>
                        <ul class="mt-3 space-y-2 list-disc list-inside text-[#822021]/80">
                            <li>Siapkan data peserta sesuai identitas resmi.</li>
                            <li>Pastikan email aktif untuk menerima konfirmasi.</li>
                            <li>Pembayaran dapat dilakukan setelah data diverifikasi.</li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-layouts.app>