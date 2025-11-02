<x-layouts.admin :title="'Edit Event: ' . $event->title" subtitle="Perbarui detail workshop agar peserta mendapatkan informasi paling relevan." :back-url="route('admin.events.index')">
    <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
        <form method="POST" action="{{ route('admin.events.update', $event) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="space-y-6 rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(240,128,128,0.55)]">
                <h2 class="text-base font-semibold text-[#4B2A22]">Informasi Dasar</h2>
                <div class="grid gap-5">
                    <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                        <span>Judul Event</span>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] placeholder:text-[#D28B7B] focus:border-[#F68C7B] focus:outline-none" required>
                    </label>
                    <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                        <span>Slug</span>
                        <input type="text" name="slug" value="{{ old('slug', $event->slug) }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] placeholder:text-[#D28B7B] focus:border-[#F68C7B] focus:outline-none">
                    </label>
                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                            <span>Mulai</span>
                            <input type="datetime-local" name="start_at" value="{{ old('start_at', $event->start_at->format('Y-m-d\TH:i')) }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] focus:border-[#F68C7B] focus:outline-none" required>
                        </label>
                        <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                            <span>Selesai</span>
                            <input type="datetime-local" name="end_at" value="{{ old('end_at', $event->end_at->format('Y-m-d\TH:i')) }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] focus:border-[#F68C7B] focus:outline-none" required>
                        </label>
                    </div>
                    <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                        <span>Lokasi / Platform</span>
                        <input type="text" name="location" value="{{ old('location', $event->location) }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] placeholder:text-[#D28B7B] focus:border-[#F68C7B] focus:outline-none" required>
                    </label>
                </div>
            </div>

            <div class="grid gap-6 rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(241,128,128,0.45)] md:grid-cols-2">
                <div class="space-y-4">
                    <h2 class="text-base font-semibold text-[#4B2A22]">Kapasitas &amp; Harga</h2>
                    <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                        <span>Kuota (opsional)</span>
                        <input type="number" name="capacity" value="{{ old('capacity', $event->capacity) }}" min="1" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] focus:border-[#F68C7B] focus:outline-none">
                    </label>
                    <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                        <span>Harga</span>
                        <div class="flex items-center rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-3 py-2 focus-within:border-[#F68C7B]">
                            <span class="text-sm text-[#D28B7B]">Rp</span>
                            <input type="number" name="price" value="{{ old('price', $event->price) }}" min="0" class="ml-2 w-full bg-transparent text-sm text-[#4B2A22] focus:outline-none" required>
                        </div>
                    </label>
                </div>
                <div class="space-y-4">
                    <h2 class="text-base font-semibold text-[#4B2A22]">Status Publikasi</h2>
                    <p class="text-sm text-[#A35C45]">Aktifkan pilihan di bawah agar event langsung tampil di katalog peserta.</p>
                    <label class="inline-flex items-center gap-3 rounded-2xl bg-[#FFF0E7] px-4 py-3 text-sm font-semibold text-[#C16A55]">
                        <input type="hidden" name="publish" value="0">
                        <input type="checkbox" name="publish" value="1" class="h-4 w-4 rounded border-[#F4A994] text-[#F68C7B] focus:ring-[#F68C7B]" {{ old('publish', $event->status->value === 'published') ? 'checked' : '' }}>
                        Publikasikan setelah disimpan
                    </label>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(210,110,86,0.45)]">
                <h2 class="text-base font-semibold text-[#4B2A22]">Deskripsi Event</h2>
                <p class="mt-1 text-sm text-[#A35C45]">Bagikan highlight kegiatan, manfaat utama, dan kebutuhan peserta.</p>
                <textarea name="description" rows="6" class="mt-4 w-full rounded-2xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-3 text-sm text-[#4B2A22] placeholder:text-[#D28B7B] focus:border-[#F68C7B] focus:outline-none">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="flex flex-col gap-3 rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(234,140,101,0.5)] sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#FFF0E7] px-4 py-2 text-sm font-semibold text-[#C16A55] transition hover:bg-[#FFD6C7]">Batal</a>
                <button class="inline-flex items-center justify-center gap-2 rounded-full bg-[#F68C7B] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#F68C7B]/40 transition hover:-translate-y-0.5 hover:bg-[#e37b69]">Simpan Perubahan</button>
            </div>
        </form>

        <aside class="space-y-5 rounded-3xl bg-[#FFF5F0] p-6 shadow-[0_25px_60px_-30px_rgba(255,159,128,0.45)]">
            <div class="rounded-2xl bg-white/80 p-4">
                <h3 class="text-sm font-semibold text-[#4B2A22]">Status Publikasi</h3>
                <p class="mt-2 text-sm text-[#A35C45] leading-relaxed">{{ $event->status->value === 'published' ? 'Event ini sedang tayang di katalog peserta.' : 'Event masih berupa draft dan belum tampil di katalog.' }}</p>
            </div>
            <div class="rounded-2xl bg-white/80 p-4">
                <h3 class="text-sm font-semibold text-[#4B2A22]">Catatan Tim</h3>
                <ul class="mt-3 space-y-2 text-sm text-[#A35C45]">
                    <li>• Perbarui narahubung jika ada pergantian PIC.</li>
                    <li>• Pastikan stok materi modul telah siap.</li>
                    <li>• Reviu ulang harga sesuai segmentasi peserta.</li>
                </ul>
            </div>
            <div class="rounded-2xl bg-gradient-to-br from-[#FFE3D2] via-[#FFD0C0] to-[#FFC3B5] p-5 text-[#4B2A22]">
                <h3 class="text-sm font-semibold">Pratinjau Publik</h3>
                <p class="mt-2 text-sm leading-relaxed">Cek tampilan event di katalog peserta untuk memastikan seluruh informasi tampil sesuai.</p>
                <a href="{{ route('events.show', $event) }}" class="mt-3 inline-flex items-center gap-2 text-xs font-semibold text-[#E57255]">Buka Preview →</a>
            </div>
        </aside>
    </div>
</x-layouts.admin>
