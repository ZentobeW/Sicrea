<x-layouts.admin :title="'Edit Event: ' . $event->title" subtitle="Perbarui detail workshop agar peserta mendapatkan informasi paling relevan." :back-url="route('admin.events.index')">
    <x-slot name="actions">
        <a href="{{ route('events.show', $event) }}" target="_blank" class="inline-flex items-center gap-2 rounded-full bg-white/70 px-4 py-2 text-sm font-semibold text-[#C16A55] shadow-sm transition hover:bg-white" title="Lihat tampilan publik">
            <x-heroicon-o-arrow-up-right class="h-4 w-4" />
            Pratinjau Event
        </a>
    </x-slot>

    <form method="POST" action="{{ route('admin.events.update', $event) }}" class="space-y-8">
        @csrf
        @method('PUT')

        <section class="rounded-[32px] bg-white/95 p-6 sm:p-8 shadow-[0_35px_90px_-45px_rgba(240,128,128,0.45)]">
            <header class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#E77B5F]">Informasi Dasar</p>
                    <h2 class="text-xl font-semibold text-[#4B2A22]">Detail Utama Event</h2>
                    <p class="mt-1 text-sm text-[#A35C45]">Tentukan judul dan highlight utama agar peserta langsung memahami nilai workshop.</p>
                </div>
                <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF0E7] px-4 py-2 text-xs font-semibold text-[#C16A55]">Terakhir diperbarui {{ $event->updated_at->diffForHumans() }}</span>
            </header>

            <div class="mt-6 grid gap-6">
                <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                    <span>Judul Event</span>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full rounded-3xl border border-[#FFD6C7] bg-[#FFF7F3] px-5 py-3 text-sm text-[#4B2A22] placeholder:text-[#D28B7B] focus:border-[#F68C7B] focus:outline-none" required>
                </label>
                <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                    <span>Deskripsi Event</span>
                    <textarea name="description" rows="6" class="w-full rounded-3xl border border-[#FFD6C7] bg-[#FFF7F3] px-5 py-3 text-sm text-[#4B2A22] placeholder:text-[#D28B7B] focus:border-[#F68C7B] focus:outline-none">{{ old('description', $event->description) }}</textarea>
                </label>
            </div>
        </section>

        <section class="rounded-[32px] bg-white/95 p-6 sm:p-8 shadow-[0_35px_90px_-45px_rgba(241,128,128,0.35)]">
            <header class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#E77B5F]">Jadwal &amp; Lokasi</p>
                    <h2 class="text-xl font-semibold text-[#4B2A22]">Atur waktu dan venue</h2>
                    <p class="mt-1 text-sm text-[#A35C45]">Informasi ini akan tampil pada katalog peserta dan e-mail konfirmasi.</p>
                </div>
            </header>

            <div class="mt-6 grid gap-5 md:grid-cols-2">
                <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                    <span>Mulai</span>
                    <input type="datetime-local" name="start_at" value="{{ old('start_at', $event->start_at->format('Y-m-d\TH:i')) }}" class="w-full rounded-3xl border border-[#FFD6C7] bg-[#FFF7F3] px-5 py-3 text-sm text-[#4B2A22] focus:border-[#F68C7B] focus:outline-none" required>
                </label>
                <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                    <span>Selesai</span>
                    <input type="datetime-local" name="end_at" value="{{ old('end_at', $event->end_at->format('Y-m-d\TH:i')) }}" class="w-full rounded-3xl border border-[#FFD6C7] bg-[#FFF7F3] px-5 py-3 text-sm text-[#4B2A22] focus:border-[#F68C7B] focus:outline-none" required>
                </label>
                <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                    <span>Nama Venue</span>
                    <input type="text" name="venue_name" value="{{ old('venue_name', $event->venue_name) }}" class="w-full rounded-3xl border border-[#FFD6C7] bg-[#FFF7F3] px-5 py-3 text-sm text-[#4B2A22] placeholder:text-[#D28B7B] focus:border-[#F68C7B] focus:outline-none" required>
                </label>
                <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                    <span>Alamat Venue / Platform</span>
                    <input type="text" name="venue_address" value="{{ old('venue_address', $event->venue_address) }}" class="w-full rounded-3xl border border-[#FFD6C7] bg-[#FFF7F3] px-5 py-3 text-sm text-[#4B2A22] placeholder:text-[#D28B7B] focus:border-[#F68C7B] focus:outline-none" required>
                </label>
            </div>
        </section>

        <section class="rounded-[32px] bg-white/95 p-6 sm:p-8 shadow-[0_35px_90px_-45px_rgba(210,110,86,0.35)]">
            <header class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#E77B5F]">Pengelolaan Event</p>
                    <h2 class="text-xl font-semibold text-[#4B2A22]">Tutor, kuota, dan publikasi</h2>
                    <p class="mt-1 text-sm text-[#A35C45]">Pastikan data tutor akurat dan tentukan apakah event siap tayang.</p>
                </div>
            </header>

            <div class="mt-6 grid gap-5 md:grid-cols-2">
                <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                    <span>Nama Tutor</span>
                    <input type="text" name="tutor_name" value="{{ old('tutor_name', $event->tutor_name) }}" class="w-full rounded-3xl border border-[#FFD6C7] bg-[#FFF7F3] px-5 py-3 text-sm text-[#4B2A22] placeholder:text-[#D28B7B] focus:border-[#F68C7B] focus:outline-none" required>
                </label>
                <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                    <span>Kuota Peserta (opsional)</span>
                    <input type="number" name="capacity" value="{{ old('capacity', $event->capacity) }}" min="1" class="w-full rounded-3xl border border-[#FFD6C7] bg-[#FFF7F3] px-5 py-3 text-sm text-[#4B2A22] focus:border-[#F68C7B] focus:outline-none">
                </label>
                <label class="space-y-2 text-sm font-semibold text-[#7A3E2F]">
                    <span>Harga Tiket</span>
                    <div class="flex items-center rounded-3xl border border-[#FFD6C7] bg-[#FFF7F3] px-4 py-2 focus-within:border-[#F68C7B]">
                        <span class="text-sm text-[#D28B7B]">Rp</span>
                        <input type="number" name="price" value="{{ old('price', $event->price) }}" min="0" class="ml-2 w-full bg-transparent text-sm text-[#4B2A22] focus:outline-none" required>
                    </div>
                </label>
                <div class="space-y-3 rounded-3xl border border-[#FFD6C7] bg-[#FFF4EE] px-5 py-4">
                    <p class="text-sm font-semibold text-[#7A3E2F]">Status Publikasi</p>
                    <p class="text-xs text-[#B36A54]">Aktifkan untuk menayangkan event di katalog peserta.</p>
                    <label class="inline-flex items-center gap-3 text-sm font-semibold text-[#C16A55]">
                        <input type="hidden" name="publish" value="0">
                        <input type="checkbox" name="publish" value="1" class="h-4 w-4 rounded border-[#F4A994] text-[#F68C7B] focus:ring-[#F68C7B]" {{ old('publish', $event->status->value === 'published') ? 'checked' : '' }}>
                        Publikasikan setelah disimpan
                    </label>
                    <p class="text-xs text-[#D28B7B]">Status saat ini: <strong>{{ $event->status->label() }}</strong></p>
                </div>
            </div>
        </section>

        <div class="flex flex-col gap-3 rounded-[32px] bg-white/95 p-6 shadow-[0_35px_90px_-45px_rgba(234,140,101,0.45)] sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#FFF0E7] px-5 py-3 text-sm font-semibold text-[#C16A55] transition hover:bg-[#FFD6C7]">Batal</a>
            <button class="inline-flex items-center justify-center gap-2 rounded-full bg-[#F68C7B] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#F68C7B]/40 transition hover:-translate-y-0.5 hover:bg-[#e37b69]">
                Simpan Perubahan
            </button>
        </div>
    </form>
</x-layouts.admin>
