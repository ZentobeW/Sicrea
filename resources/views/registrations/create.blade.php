<x-layouts.app :title="'Daftar Workshop'">
    <section class="bg-gradient-to-br from-[#FFE3D3] via-[#FFF3EA] to-white py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('events.show', $event->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#C65B74] hover:text-[#A2475D]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Detail Event
            </a>

            <div class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,2fr),minmax(0,1fr)]">
                <div class="rounded-[32px] border border-[#FAD6C7] bg-white/90 p-8 shadow-lg shadow-[#FAD6C7]/40 backdrop-blur">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Step Pendaftaran</p>
                            <h1 class="mt-2 text-2xl font-semibold text-[#2C1E1E]">Lengkapi Data Peserta</h1>
                        </div>
                        <div class="flex items-center gap-2 text-sm font-semibold text-[#C65B74]">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#FF8A64] text-white">1</span>
                            <span>Langkah 1 dari 3</span>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-3 md:grid-cols-3">
                        <div class="rounded-2xl border border-[#FAD6C7] bg-[#FFF5EF] px-4 py-3 text-sm font-semibold text-[#C65B74]">Data Diri</div>
                        <div class="rounded-2xl border border-dashed border-[#FAD6C7]/70 px-4 py-3 text-sm font-semibold text-[#C65B74]/60">Konfirmasi</div>
                        <div class="rounded-2xl border border-dashed border-[#FAD6C7]/70 px-4 py-3 text-sm font-semibold text-[#C65B74]/60">Pembayaran</div>
                    </div>

                    <div class="mt-8">
                        <form method="POST" action="{{ route('events.register.store', $event) }}" class="space-y-6">
                            @csrf

                            <div class="flex flex-wrap gap-3 rounded-full bg-[#FFF0E6] p-2 text-sm font-semibold text-[#C65B74]">
                                <label class="flex-1">
                                    <input type="radio" name="form_data[participant_mode]" value="self" checked class="peer hidden">
                                    <span class="flex h-11 w-full items-center justify-center rounded-full bg-white px-4 py-2 transition peer-checked:bg-[#FF8A64] peer-checked:text-white">Pribadi</span>
                                </label>
                                <label class="flex-1">
                                    <input type="radio" name="form_data[participant_mode]" value="other" class="peer hidden">
                                    <span class="flex h-11 w-full items-center justify-center rounded-full px-4 py-2 transition peer-checked:bg-[#FF8A64] peer-checked:text-white">Orang Lain</span>
                                </label>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2C1E1E]">Nama Lengkap</label>
                                    <input type="text" name="form_data[name]" value="{{ old('form_data.name', auth()->user()->name) }}" required class="w-full rounded-2xl border border-[#FAD6C7] bg-white/80 px-4 py-3 text-sm text-[#2C1E1E] placeholder:text-[#B07A7A] focus:border-[#FF8A64] focus:outline-none focus:ring-2 focus:ring-[#FF8A64]/40" placeholder="Masukkan nama sesuai identitas">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2C1E1E]">Email</label>
                                    <input type="email" name="form_data[email]" value="{{ old('form_data.email', auth()->user()->email) }}" required class="w-full rounded-2xl border border-[#FAD6C7] bg-white/80 px-4 py-3 text-sm text-[#2C1E1E] placeholder:text-[#B07A7A] focus:border-[#FF8A64] focus:outline-none focus:ring-2 focus:ring-[#FF8A64]/40" placeholder="contoh@email.com">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2C1E1E]">Nomor Telepon</label>
                                    <input type="text" name="form_data[phone]" value="{{ old('form_data.phone') }}" required class="w-full rounded-2xl border border-[#FAD6C7] bg-white/80 px-4 py-3 text-sm text-[#2C1E1E] placeholder:text-[#B07A7A] focus:border-[#FF8A64] focus:outline-none focus:ring-2 focus:ring-[#FF8A64]/40" placeholder="0812-xxxx-xxxx">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2C1E1E]">Instansi / Perusahaan <span class="text-[#C65B74]/70">(opsional)</span></label>
                                    <input type="text" name="form_data[company]" value="{{ old('form_data.company') }}" class="w-full rounded-2xl border border-[#FAD6C7] bg-white/80 px-4 py-3 text-sm text-[#2C1E1E] placeholder:text-[#B07A7A] focus:border-[#FF8A64] focus:outline-none focus:ring-2 focus:ring-[#FF8A64]/40" placeholder="Nama instansi">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-[#2C1E1E]">Catatan Tambahan <span class="text-[#C65B74]/70">(opsional)</span></label>
                                <textarea name="form_data[notes]" rows="3" class="w-full rounded-2xl border border-[#FAD6C7] bg-white/80 px-4 py-3 text-sm text-[#2C1E1E] placeholder:text-[#B07A7A] focus:border-[#FF8A64] focus:outline-none focus:ring-2 focus:ring-[#FF8A64]/40" placeholder="Tuliskan preferensi atau kebutuhan khusus"></textarea>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-3 pt-4">
                                <p class="text-xs text-[#A04E62]">Dengan melanjutkan, Anda menyetujui ketentuan dan kebijakan privasi Kreasi Hangat.</p>
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('events.show', $event->slug) }}" class="text-sm font-semibold text-[#C65B74] hover:text-[#A2475D]">Batal</a>
                                    <button class="inline-flex items-center gap-2 rounded-full bg-[#FF8A64] px-6 py-3 text-sm font-semibold text-white shadow-md shadow-[#FF8A64]/30 transition hover:bg-[#F9744B]">
                                        Lanjutkan
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <aside class="space-y-6">
                    <div class="rounded-[32px] border border-[#FAD6C7] bg-white/80 p-6 shadow-lg shadow-[#FAD6C7]/40 backdrop-blur">
                        <h2 class="text-lg font-semibold text-[#2C1E1E]">Ringkasan Event</h2>
                        <div class="mt-4 space-y-4 text-sm text-[#5F4C4C]">
                            <div class="rounded-2xl bg-[#FFF0E6] px-4 py-3 text-[#C65B74]">
                                {{ $event->title }}
                            </div>
                            <dl class="space-y-3">
                                <div class="flex items-start justify-between gap-3">
                                    <dt class="text-[#A04E62]">Tanggal</dt>
                                    <dd class="text-right">{{ $event->start_at->translatedFormat('d F Y') }}</dd>
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <dt class="text-[#A04E62]">Waktu</dt>
                                    <dd class="text-right">{{ $event->start_at->translatedFormat('H:i') }} - {{ $event->end_at->translatedFormat('H:i') }} WIB</dd>
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <dt class="text-[#A04E62]">Lokasi</dt>
                                    <dd class="text-right">{{ $event->location }}</dd>
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <dt class="text-[#A04E62]">Kuota</dt>
                                    <dd class="text-right">{{ $event->available_slots ?? 'Tidak terbatas' }}</dd>
                                </div>
                            </dl>
                            <div class="rounded-2xl border border-dashed border-[#FAD6C7] px-4 py-3 text-sm text-[#2C1E1E]">
                                <div class="flex items-center justify-between font-semibold">
                                    <span>Total Pembayaran</span>
                                    <span class="text-[#C65B74]">Rp{{ number_format($event->price, 0, ',', '.') }}</span>
                                </div>
                                <p class="mt-2 text-xs text-[#A04E62]">Biaya sudah termasuk materi, alat pendukung, dan akses rekaman.</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[28px] border border-dashed border-[#FAD6C7]/80 bg-white/70 p-6 text-sm text-[#5F4C4C] shadow-sm shadow-[#FAD6C7]/40">
                        <h3 class="text-base font-semibold text-[#2C1E1E]">Tips Pendaftaran</h3>
                        <ul class="mt-3 space-y-2 list-disc list-inside">
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
