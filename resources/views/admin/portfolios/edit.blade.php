@php($tabs = [
    ['label' => 'Event', 'route' => route('admin.events.index'), 'active' => request()->routeIs('admin.events.*'), 'icon' => 'calendar'],
    ['label' => 'Pendaftaran', 'route' => route('admin.registrations.index'), 'active' => request()->routeIs('admin.registrations.*'), 'icon' => 'document-text'],
    ['label' => 'Portofolio', 'route' => route('admin.portfolios.index'), 'active' => request()->routeIs('admin.portfolios.*'), 'icon' => 'photo'],
])

@php($event = $portfolio->event)

<x-layouts.admin :title="'Edit Portofolio: ' . $portfolio->title" subtitle="Sempurnakan cerita visual agar audiens merasakan pengalaman workshop secara utuh." :tabs="$tabs" :back-url="route('admin.portfolios.index')">
    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[32px] bg-[#FCF5E6] p-6 sm:p-8 shadow-xl">
            <div class="absolute inset-y-0 right-0 hidden h-full w-1/2 translate-x-1/6 rounded-[40px] bg-white/30 blur-3xl lg:block"></div>
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-2xl space-y-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-orange-500">Ringkasan Dokumentasi</p>
                    <h2 class="text-2xl font-semibold text-slate-900 sm:text-3xl">{{ $portfolio->title }}</h2>
                    <p class="text-sm text-slate-600">Pastikan detail dokumentasi selaras dengan identitas event dan pilih foto terbaik yang mampu merepresentasikan cerita kegiatan.</p>
                </div>
                <div class="w-full max-w-xs rounded-3xl border border-orange-200/60 bg-white/80 p-4 shadow-lg backdrop-blur">
                    <p class="text-xs font-semibold uppercase tracking-widest text-orange-500">Event Terkait</p>
                    @if ($event)
                        <h3 class="mt-2 text-base font-semibold text-slate-900">{{ $event->title }}</h3>
                        <dl class="mt-4 space-y-2 text-sm text-slate-600">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-orange-100 text-orange-500">
                                    <x-heroicon-o-calendar class="h-5 w-5" />
                                </span>
                                <span>{{ optional($event->start_at)->translatedFormat('d M Y') }} • {{ optional($event->start_at)->translatedFormat('H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-orange-100 text-orange-500">
                                    <x-heroicon-o-map-pin class="h-5 w-5" />
                                </span>
                                <span class="line-clamp-2">{{ $event->venue_name }}</span>
                            </div>
                            <p class="pl-10 text-xs text-slate-500">{{ $event->venue_address }}</p>
                            <p class="pl-10 text-xs text-slate-500">Tutor: {{ $event->tutor_name }}</p>
                        </dl>
                    @else
                        <p class="mt-2 text-sm text-slate-600">Belum terhubung dengan event mana pun. Pilih event pada formulir di bawah agar portofolio tampil di halaman program terkait.</p>
                    @endif
                </div>
            </div>
        </section>

        <form method="POST" action="{{ route('admin.portfolios.update', $portfolio) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="rounded-[32px] border border-slate-200/70 bg-[#FAF8F1] p-6 sm:p-8 shadow-xl shadow-orange-100/50 space-y-6">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Informasi Dasar</h3>
                        <p class="text-sm text-slate-500">Perbarui judul, deskripsi, dan keterkaitan event sesuai kebutuhan kampanye.</p>
                    </div>
                    <span class="inline-flex items-center gap-2 rounded-full bg-orange-100 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-orange-600">
                        <x-heroicon-o-photo class="h-4 w-4" />
                        Dokumen Aktif
                    </span>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="flex items-center justify-between text-sm font-semibold text-slate-700">
                            Judul Dokumentasi
                            <span class="text-xs font-normal text-slate-400">Wajib diisi</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $portfolio->title) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-orange-400 focus:ring-orange-400" required>
                        @error('title')
                            <p class="mt-2 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Terkait Event</label>
                        <select name="event_id" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-orange-400 focus:ring-orange-400">
                            <option value="">-- Pilih Event --</option>
                            @foreach ($events as $item)
                                <option value="{{ $item->id }}" @selected(old('event_id', $portfolio->event_id) == $item->id)>{{ $item->title }}</option>
                            @endforeach
                        </select>
                        @error('event_id')
                            <p class="mt-2 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Tanggal Event</label>
                        <div class="mt-2 flex h-[52px] items-center gap-3 rounded-2xl border border-dashed border-orange-200 bg-orange-50/70 px-4 text-sm text-orange-600">
                            <x-heroicon-o-calendar class="h-5 w-5" />
                            <span>{{ $event?->start_at?->translatedFormat('d F Y') ?? 'Pilih event untuk menampilkan jadwal' }}</span>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700">Deskripsi Singkat</label>
                        <textarea name="description" rows="4" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-orange-400 focus:ring-orange-400" placeholder="Ceritakan highlight dokumentasi...">{{ old('description', $portfolio->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="rounded-[32px] border border-slate-200/70 bg-[#FAF8F1] p-6 sm:p-8 shadow-xl shadow-orange-100/50 space-y-6" data-gallery-uploader>
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Dokumentasi Foto</h3>
                        <p class="text-sm text-slate-500">Kelola galeri foto dengan menambahkan gambar baru atau menonaktifkan foto yang sudah tidak relevan.</p>
                    </div>
                    <button type="button" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-4 py-2 text-sm font-semibold text-[#FAF8F1] shadow-lg shadow-[#822021]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70 hover:text-[#FAF8F1]" data-gallery-trigger>
                        <x-heroicon-o-plus class="h-4 w-4" />
                        Tambah Foto
                    </button>
                </div>

                <input type="file" name="gallery[]" id="gallery" accept="image/*" multiple class="sr-only" data-gallery-input>

                <div class="space-y-5">
                    <div class="space-y-3">
                        <h4 class="text-sm font-semibold text-slate-700">Galeri Saat Ini</h4>
                        <div class="grid gap-4 md:grid-cols-3" data-gallery-existing>
                            @forelse ($portfolio->images as $image)
                                <label class="group relative block overflow-hidden rounded-3xl border border-orange-200/70 bg-orange-50/60 shadow-inner" data-gallery-existing-item>
                                    <input type="checkbox" name="remove_gallery[]" value="{{ $image->id }}" class="peer sr-only" data-gallery-remove>
                                    <img src="{{ $image->url }}" alt="{{ $portfolio->title }}" class="h-40 w-full object-cover transition duration-300 group-hover:scale-105">
                                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-slate-900/70 text-white opacity-0 transition peer-checked:opacity-100 group-hover:opacity-100">
                                        <span class="text-xs font-semibold uppercase tracking-[0.28em]">Ditandai</span>
                                        <span class="text-[11px]">Foto akan dihapus saat disimpan</span>
                                    </div>
                                    <span class="pointer-events-none absolute bottom-3 right-3 inline-flex items-center gap-1 rounded-full bg-white/90 px-3 py-1 text-[11px] font-semibold text-[#A3563F] shadow">
                                        <x-heroicon-o-trash class="h-4 w-4" />
                                        Hapus
                                    </span>
                                </label>
                            @empty
                                <div class="col-span-full flex h-40 flex-col items-center justify-center gap-3 rounded-3xl border border-dashed border-orange-200 bg-orange-50/50 text-slate-400">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/80 shadow-inner">
                                        <x-heroicon-o-photo class="h-5 w-5" />
                                    </span>
                                    <p class="px-6 text-center text-xs font-medium">Belum ada foto yang diunggah untuk portofolio ini.</p>
                                </div>
                            @endforelse
                        </div>
                        @if ($errors->has('remove_gallery.*'))
                            <p class="text-xs font-medium text-rose-500">{{ $errors->first('remove_gallery.*') }}</p>
                        @endif
                    </div>

                    <div class="space-y-3">
                        <h4 class="text-sm font-semibold text-slate-700">Upload Baru</h4>
                        <div class="rounded-3xl border border-dashed border-orange-200 bg-orange-50/40 p-4">
                            <div class="grid gap-4 md:grid-cols-3" data-gallery-preview>
                                <div data-gallery-empty class="col-span-full flex h-36 flex-col items-center justify-center gap-3 text-slate-400">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/80 shadow-inner">
                                        <x-heroicon-o-photo class="h-5 w-5" />
                                    </span>
                                    <p class="px-6 text-center text-xs font-medium">Belum ada foto tambahan yang dipilih.</p>
                                </div>
                            </div>
                            <p class="mt-3 text-xs text-slate-500">Format JPG atau PNG dengan ukuran maksimal 4MB per file.</p>
                        </div>
                        @if ($errors->has('gallery.*'))
                            <p class="text-xs font-medium text-rose-500">{{ $errors->first('gallery.*') }}</p>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Tautan Dokumentasi Utama</label>
                        <input type="url" name="media_url" value="{{ old('media_url', $portfolio->media_url) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-orange-400 focus:ring-orange-400" placeholder="https://drive.google.com/...">
                        @error('media_url')
                            <p class="mt-2 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('admin.portfolios.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#822021] px-5 py-3 text-sm font-semibold text-[#FAF8F1] transition hover:bg-[#822021]/70 hover:text-[#FAF8F1]">Batal</a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#822021] px-6 py-3 text-sm font-semibold text-[#FAF8F1] shadow-xl shadow-[#822021]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70 hover:text-[#FAF8F1]">
                    <x-heroicon-o-arrow-up-right class="h-4 w-4" />
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('[data-gallery-uploader]').forEach((wrapper) => {
                    if (wrapper.dataset.initialized === 'true') {
                        return;
                    }

                    const input = wrapper.querySelector('[data-gallery-input]');
                    const trigger = wrapper.querySelector('[data-gallery-trigger]');
                    const preview = wrapper.querySelector('[data-gallery-preview]');
                    const emptyState = wrapper.querySelector('[data-gallery-empty]');

                    if (!input || !preview) {
                        return;
                    }

                    const renderPreviews = () => {
                        preview.querySelectorAll('[data-gallery-item]').forEach((item) => item.remove());

                        if (!input.files.length) {
                            emptyState?.classList.remove('hidden');
                            return;
                        }

                        emptyState?.classList.add('hidden');

                        Array.from(input.files).forEach((file) => {
                            const item = document.createElement('div');
                            item.dataset.galleryItem = 'true';
                            item.className = 'relative overflow-hidden rounded-2xl border border-orange-200 bg-white shadow-sm';

                            const figure = document.createElement('figure');
                            figure.className = 'aspect-[4/3]';

                            const img = document.createElement('img');
                            img.className = 'h-full w-full object-cover';
                            const url = URL.createObjectURL(file);
                            img.src = url;
                            img.onload = () => URL.revokeObjectURL(url);

                            figure.appendChild(img);
                            item.appendChild(figure);

                            const caption = document.createElement('div');
                            caption.className = 'border-t border-orange-100 px-3 py-2 text-xs font-medium text-slate-600 truncate';
                            caption.textContent = file.name;
                            item.appendChild(caption);

                            preview.appendChild(item);
                        });
                    };

                    const existingItems = wrapper.querySelectorAll('[data-gallery-existing-item]');
                    existingItems.forEach((item) => {
                        const checkbox = item.querySelector('[data-gallery-remove]');
                        if (!checkbox) {
                            return;
                        }

                        checkbox.addEventListener('change', () => {
                            item.classList.toggle('ring-2', checkbox.checked);
                            item.classList.toggle('ring-orange-400', checkbox.checked);
                        });
                    });

                    trigger?.addEventListener('click', () => input.click());
                    input.addEventListener('change', renderPreviews);

                    wrapper.dataset.initialized = 'true';
                });
            });
        </script>
    @endpush
</x-layouts.admin>
