<x-layouts.admin title="Tambah Event" subtitle="Susun pengalaman workshop yang inspiratif dan pastikan informasinya lengkap sebelum dibagikan ke publik." back-url="{{ route('admin.events.index') }}">
    <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
        {{-- PENTING: Tambahkan enctype="multipart/form-data" --}}
        <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="space-y-6 rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(240,128,128,0.55)]">
                <h2 class="text-xl font-semibold text-[#822021]">Informasi Dasar</h2>
                <div class="grid gap-5">
                    <label class="space-y-2 text-base font-semibold text-[#822021]">
                        <span>Judul Event</span>
                        <input type="text" name="title" value="{{ old('title') }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] placeholder:text-[#D28B7B] focus:border-[#822021] focus:outline-none" required>
                    </label>

                    {{-- Input Foto Baru --}}
                    <label class="space-y-2 text-base font-semibold text-[#822021]">
                        <span>Banner Event</span>
                        <div class="relative">
                            <input type="file" name="image" accept="image/*" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] file:mr-4 file:rounded-full file:border-0 file:bg-[#822021] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#FAF8F1] hover:file:bg-[#822021]/80 focus:border-[#822021] focus:outline-none cursor-pointer">
                        </div>
                        <p class="text-xs text-[#D28B7B] mt-1">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
                        @error('image')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="space-y-2 text-base font-semibold text-[#822021]">
                            <span>Mulai</span>
                            <input type="datetime-local" name="start_at" value="{{ old('start_at') }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] focus:border-[#822021] focus:outline-none" required>
                        </label>
                        <label class="space-y-2 text-base font-semibold text-[#822021]">
                            <span>Selesai</span>
                            <input type="datetime-local" name="end_at" value="{{ old('end_at') }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] focus:border-[#822021] focus:outline-none" required>
                        </label>
                    </div>
                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="space-y-2 text-base font-semibold text-[#822021]">
                            <span>Nama Venue</span>
                            <input type="text" name="venue_name" value="{{ old('venue_name') }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] placeholder:text-[#D28B7B] focus:border-[#822021] focus:outline-none" required>
                        </label>
                        <label class="space-y-2 text-base font-semibold text-[#822021]">
                            <span>Nama Tutor</span>
                            <input type="text" name="tutor_name" value="{{ old('tutor_name') }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] placeholder:text-[#D28B7B] focus:border-[#822021] focus:outline-none" required>
                        </label>
                    </div>
                    <label class="space-y-2 text-base font-semibold text-[#822021]">
                        <span>Alamat Venue / Platform</span>
                        <input type="text" name="venue_address" value="{{ old('venue_address') }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] placeholder:text-[#D28B7B] focus:border-[#822021] focus:outline-none" required>
                    </label>
                </div>
            </div>

            <div class="grid gap-6 rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(241,128,128,0.45)] md:grid-cols-2">
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-[#822021]">Kapasitas &amp; Harga</h2>
                    <label class="space-y-2 text-base font-semibold text-[#822021]">
                        <span>Kuota (opsional)</span>
                        <input type="number" name="capacity" value="{{ old('capacity') }}" min="1" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] focus:border-[#822021] focus:outline-none">
                    </label>
                    <label class="space-y-2 text-base font-semibold text-[#822021]">
                        <span>Harga</span>
                        <div class="flex items-center rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-3 py-2 focus-within:border-[#822021]">
                            <span class="text-base text-[#D28B7B]">Rp</span>
                            <input type="number" name="price" value="{{ old('price', 0) }}" min="0" class="ml-2 w-full bg-transparent text-base text-[#822021] focus:outline-none" required>
                        </div>
                    </label>
                </div>
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-[#822021]">Status Publikasi</h2>
                    <p class="text-base text-[#822021]">Aktifkan pilihan di bawah agar event langsung tampil di katalog peserta.</p>
                    <label class="inline-flex items-center gap-3 rounded-2xl bg-[#FFF0E7] px-4 py-3 text-base font-semibold text-[#822021]">
                        <input type="hidden" name="publish" value="0">
                        <input type="checkbox" name="publish" value="1" class="h-4 w-4 rounded border-[#F4A994] text-[#822021] focus:ring-[#822021]" {{ old('publish') ? 'checked' : '' }}>
                        Publikasikan setelah disimpan
                    </label>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(210,110,86,0.45)]">
                <h2 class="text-xl font-semibold text-[#822021]">Deskripsi Event</h2>
                <p class="mt-1 text-base text-[#822021]">Bagikan highlight kegiatan, manfaat utama, dan kebutuhan peserta.</p>
                <textarea name="description" rows="6" class="mt-4 w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] placeholder:text-[#D28B7B] focus:border-[#822021] focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <div class="flex flex-col gap-3 rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(234,140,101,0.5)] sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#FCF5E6] px-4 py-2 text-base font-semibold text-[#822021] transition hover:bg-[#822021] hover:text-[#FAF8F1]">Batal</a>
                <button class="inline-flex items-center gap-2 rounded-full bg-[#822021]/70 px-4 py-2 text-base font-semibold text-[#FAF8F1] shadow-sm transition hover:bg-[#822021] hover:text-[#FAF8F1]">Simpan Event</button>
            </div>
        </form>

        <aside class="space-y-5 rounded-3xl bg-[#822021] p-6 shadow-[0_25px_60px_-30px_rgba(255,159,128,0.45)]">
            <div class="rounded-2xl bg-white/80 p-4">
                <h3 class="text-base font-semibold text-[#822021]">Checklist Publikasi</h3>
                <ul class="mt-3 space-y-2 text-base text-[#822021]">
                    <li>✔ Jadwal dan venue telah dikonfirmasi.</li>
                    <li>✔ Kuota dan harga mengikuti brief.</li>
                    <li>✔ Materi promosi siap dibagikan.</li>
                </ul>
            </div>
            <div class="rounded-2xl bg-white/80 p-4">
                <h3 class="text-base font-semibold text-[#822021]">Catatan Tim</h3>
                <p class="mt-2 text-base text-[#822021] leading-relaxed">Pastikan mengunggah foto pendukung minimal 3 hari sebelum event berlangsung untuk memperkuat promosi.</p>
            </div>
            <div class="rounded-2xl bg-[#FCF5E6] p-5 text-[#822021]">
                <h3 class="text-base font-semibold">Butuh Template?</h3>
                <p class="mt-2 text-base leading-relaxed">Gunakan template copy promosi dan aset visual yang tersedia di drive tim marketing.</p>
            </div>
        </aside>
    </div>
</x-layouts.admin>