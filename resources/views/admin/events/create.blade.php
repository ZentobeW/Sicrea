<x-layouts.admin title="Tambah Event" subtitle="Susun pengalaman workshop yang inspiratif dan pastikan informasinya lengkap sebelum dibagikan ke publik." back-url="{{ route('admin.events.index') }}">
    <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
        <form method="POST" action="{{ route('admin.events.store') }}" class="space-y-6">
            @csrf
            <div class="space-y-6 rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(240,128,128,0.55)]">
                <h2 class="text-base font-semibold text-[#4B2A22]">Informasi Dasar</h2>
                <div class="grid gap-5">
                    <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                        <span>Judul Event</span>
                        <input type="text" name="title" value="{{ old('title') }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] placeholder:text-[#D28B7B] focus:border-[#F68C7B] focus:outline-none" required>
                    </label>
                    
                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                            <span>Mulai</span>
                            <input type="datetime-local" name="start_at" value="{{ old('start_at') }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] focus:border-[#F68C7B] focus:outline-none" required>
                        </label>
                        <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                            <span>Selesai</span>
                            <input type="datetime-local" name="end_at" value="{{ old('end_at') }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] focus:border-[#F68C7B] focus:outline-none" required>
                        </label>
                    </div>

                    <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                        <span>Nama Tutor / Pembicara</span>
                        <input type="text" name="tutor_name" value="{{ old('tutor_name') }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] placeholder:text-[#D28B7B] focus:border-[#F68C7B] focus:outline-none" required>
                    </label>

                    <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                        <span>Nama Tempat / Venue</span>
                        <input type="text" name="venue_name" value="{{ old('venue_name') }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] placeholder:text-[#D28B7B] focus:border-[#F68C7B] focus:outline-none" required>
                    </label>

                    <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                        <span>Alamat Tempat / Platform (Link jika online)</span>
                        <input type="text" name="venue_address" value="{{ old('venue_address') }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] placeholder:text-[#D28B7B] focus:border-[#F68C7B] focus:outline-none" required>
                    </label>
                </div>
            </div>

            <div class="grid gap-6 rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(241,128,128,0.45)] md:grid-cols-2">
                <div class="space-y-4">
                    <h2 class="text-base font-semibold text-[#4B2A22]">Kapasitas &amp; Harga</h2>
                    <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                        <span>Kuota (opsional)</span>
                        <input type="number" name="capacity" value="{{ old('capacity') }}" min="1" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] focus:border-[#F68C7B] focus:outline-none">
                    </label>
                    <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                        <span>Harga</span>
                        <div class="flex items-center rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-3 py-2 focus-within:border-[#F68C7B]">
                            <span class="text-sm text-[#D28B7B]">Rp</span>
                            <input type="number" name="price" value="{{ old('price', 0) }}" min="0" class="ml-2 w-full bg-transparent text-sm text-[#4B2A22] focus:outline-none" required>
                        </div>
                    </label>
                </div>
                <div class="space-y-4">
                    <h2 class="text-base font-semibold text-[#4B2A22]">Status Publikasi</h2>
                    <p class="text-sm text-[#A35C45]">Aktifkan pilihan di bawah agar event langsung tampil di katalog peserta.</p>
                    <label class="inline-flex items-center gap-3 rounded-2xl bg-[#FFF0E7] px-4 py-3 text-sm font-semibold text-[#C16A55]">
                        <input type="hidden" name="publish" value="0">
                        <input type="checkbox" name="publish" value="1" class="h-4 w-4 rounded border-[#F4A994] text-[#F68C7B] focus:ring-[#F68C7B]" {{ old('publish') ? 'checked' : '' }}>
                        Publikasikan setelah disimpan
                    </label>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(210,110,86,0.45)]">
                <h2 class="text-base font-semibold text-[#4B2A22]">Deskripsi Event</h2>
                <p class="mt-1 text-sm text-[#A35C45]">Bagikan highlight kegiatan, manfaat utama, dan kebutuhan peserta.</p>
                <textarea name="description" rows="6" class="mt-4 w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] placeholder:text-[#D28B7B] focus:border-[#F68C7B] focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <div class="flex flex-col gap-3 rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(234,140,101,0.5)] sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#FFF0E7] px-4 py-2 text-sm font-semibold text-[#C16A55] transition hover:bg-[#FFD6C7]">Batal</a>
                <button class="inline-flex items-center justify-center gap-2 rounded-full bg-[#F68C7B] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#F68C7B]/40 transition hover:-translate-y-0.5 hover:bg-[#e37b69]">Simpan Event</button>
            </div>
        </form>

        <aside class="space-y-5 rounded-3xl bg-[#FFF5F0] p-6 shadow-[0_25px_60px_-30px_rgba(255,159,128,0.45)]">
            <div class="rounded-2xl bg-white/80 p-4">
                <h3 class="text-sm font-semibold text-[#4B2A22]">Checklist Publikasi</h3>
                <ul class="mt-3 space-y-2 text-sm text-[#A35C45]">
                    <li>✔ Jadwal dan lokasi telah dikonfirmasi.</li>
                    <li>✔ Kuota dan harga mengikuti brief.</li>
                    <li>✔ Materi promosi siap dibagikan.</li>
                </ul>
            </div>
            <div class="rounded-2xl bg-white/80 p-4">
                <h3 class="text-sm font-semibold text-[#4B2A22]">Catatan Tim</h3>
                <p class="mt-2 text-sm text-[#A35C45] leading-relaxed">Pastikan mengunggah foto pendukung minimal 3 hari sebelum event berlangsung untuk memperkuat promosi.</p>
            </div>
            <div class="rounded-2xl bg-gradient-to-br from-[#FFE3D2] via-[#FFD0C0] to-[#FFC3B5] p-5 text-[#4B2A22]">
                <h3 class="text-sm font-semibold">Butuh Template?</h3>
                <p class="mt-2 text-sm leading-relaxed">Gunakan template copy promosi dan aset visual yang tersedia di drive tim marketing.</p>
            </div>
        </aside>
    </div>
</x-layouts.admin>