<x-layouts.admin title="Edit Event" subtitle="Perbarui informasi event agar peserta mendapatkan detail terkini." back-url="{{ route('admin.events.index') }}">
    <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
        <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6 rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(240,128,128,0.55)]">
                <h2 class="text-xl font-semibold text-[#822021]">Informasi Dasar</h2>
                <div class="grid gap-5">
                    <label class="space-y-2 text-base font-semibold text-[#822021]">
                        <span>Judul Event</span>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] placeholder:text-[#D28B7B] focus:border-[#822021] focus:outline-none" required>
                    </label>

                    {{-- Input Foto Edit (Menampilkan yang lama jika ada) --}}
                    <div class="space-y-2">
                        <label class="text-base font-semibold text-[#822021]">Banner Event</label>
                        @if($event->image)
                            <div class="mb-2">
                                <p class="text-xs text-[#822021] mb-1">Gambar Saat Ini:</p>
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($event->image) }}" alt="Current Banner" class="h-32 w-auto rounded-lg object-cover border border-[#FFD6C7]">
                            </div>
                        @endif
                        <div class="relative">
                            <input type="file" name="image" accept="image/*" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] file:mr-4 file:rounded-full file:border-0 file:bg-[#822021] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#FAF8F1] hover:file:bg-[#822021]/80 focus:border-[#822021] focus:outline-none cursor-pointer">
                        </div>
                        <p class="text-xs text-[#D28B7B] mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                        @error('image')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="space-y-2 text-base font-semibold text-[#822021]">
                            <span>Mulai</span>
                            <input type="datetime-local" name="start_at" value="{{ old('start_at', $event->start_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] focus:border-[#822021] focus:outline-none" required>
                        </label>
                        <label class="space-y-2 text-base font-semibold text-[#822021]">
                            <span>Selesai</span>
                            <input type="datetime-local" name="end_at" value="{{ old('end_at', $event->end_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] focus:border-[#822021] focus:outline-none" required>
                        </label>
                    </div>
                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="space-y-2 text-base font-semibold text-[#822021]">
                            <span>Nama Venue</span>
                            <input type="text" name="venue_name" value="{{ old('venue_name', $event->venue_name) }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] placeholder:text-[#D28B7B] focus:border-[#822021] focus:outline-none" required>
                        </label>
                        <label class="space-y-2 text-base font-semibold text-[#822021]">
                            <span>Nama Tutor</span>
                            <input type="text" name="tutor_name" value="{{ old('tutor_name', $event->tutor_name) }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] placeholder:text-[#D28B7B] focus:border-[#822021] focus:outline-none" required>
                        </label>
                    </div>
                    <label class="space-y-2 text-base font-semibold text-[#822021]">
                        <span>Alamat Venue / Platform</span>
                        <input type="text" name="venue_address" value="{{ old('venue_address', $event->venue_address) }}" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] placeholder:text-[#D28B7B] focus:border-[#822021] focus:outline-none" required>
                    </label>
                </div>
            </div>

            <div class="grid gap-6 rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(241,128,128,0.45)] md:grid-cols-2">
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-[#822021]">Kapasitas &amp; Harga</h2>
                    <label class="space-y-2 text-base font-semibold text-[#822021]">
                        <span>Kuota (opsional)</span>
                        <input type="number" name="capacity" value="{{ old('capacity', $event->capacity) }}" min="1" class="w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] focus:border-[#822021] focus:outline-none">
                    </label>
                    <label class="space-y-2 text-base font-semibold text-[#822021]">
                        <span>Harga</span>
                        <div class="flex items-center rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-3 py-2 focus-within:border-[#822021]">
                            <span class="text-base text-[#D28B7B]">Rp</span>
                            <input type="number" name="price" value="{{ old('price', $event->price) }}" min="0" class="ml-2 w-full bg-transparent text-base text-[#822021] focus:outline-none" required>
                        </div>
                    </label>
                </div>
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-[#822021]">Status Publikasi</h2>
                    <p class="text-base text-[#822021]">Aktifkan pilihan di bawah agar event tampil di katalog peserta.</p>
                    <label class="inline-flex items-center gap-3 rounded-2xl bg-[#FFF0E7] px-4 py-3 text-base font-semibold text-[#822021]">
                        <input type="hidden" name="publish" value="0">
                        <input type="checkbox" name="publish" value="1" class="h-4 w-4 rounded border-[#F4A994] text-[#822021] focus:ring-[#822021]" {{ old('publish', $event->isPublished()) ? 'checked' : '' }}>
                        Publikasikan Event Ini
                    </label>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(210,110,86,0.45)]">
                <h2 class="text-xl font-semibold text-[#822021]">Deskripsi Event</h2>
                <textarea name="description" rows="6" class="mt-4 w-full rounded-2xl border border-[#FFD6C7] bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] placeholder:text-[#D28B7B] focus:border-[#822021] focus:outline-none">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="flex flex-col gap-3 rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(234,140,101,0.5)] sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#FCF5E6] px-4 py-2 text-base font-semibold text-[#822021] transition hover:bg-[#822021] hover:text-[#FAF8F1]">Batal</a>
                <button class="inline-flex items-center gap-2 rounded-full bg-[#822021]/70 px-4 py-2 text-base font-semibold text-[#FAF8F1] shadow-sm transition hover:bg-[#822021] hover:text-[#FAF8F1]">Simpan Perubahan</button>
            </div>
        </form>

        <aside class="space-y-5 rounded-3xl bg-[#822021] p-6 shadow-[0_25px_60px_-30px_rgba(255,159,128,0.45)]">
            <div class="rounded-2xl bg-white/80 p-4">
                <h3 class="text-base font-semibold text-[#822021]">Info Terakhir</h3>
                <p class="mt-2 text-base text-[#822021]">Terakhir diperbarui oleh: <span class="font-bold">{{ $event->updater->name ?? 'System' }}</span></p>
                <p class="text-sm text-[#822021]/80">{{ $event->updated_at->diffForHumans() }}</p>
            </div>
        </aside>
    </div>
</x-layouts.admin>