@php($tabs = [
    ['label' => 'Event', 'route' => route('admin.events.index'), 'active' => request()->routeIs('admin.events.*'), 'icon' => 'calendar'],
    ['label' => 'Pendaftaran', 'route' => route('admin.registrations.index'), 'active' => request()->routeIs('admin.registrations.*'), 'icon' => 'document-text'],
    ['label' => 'Portofolio', 'route' => route('admin.portfolios.index'), 'active' => request()->routeIs('admin.portfolios.*'), 'icon' => 'photo'],
])

<x-layouts.admin title="Tambah Portofolio" subtitle="Abadikan momen terbaik dari workshop dan tampilkan pada galeri inspirasi." :tabs="$tabs" :back-url="route('admin.portfolios.index')">
    <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
        <form method="POST" action="{{ route('admin.portfolios.store') }}" enctype="multipart/form-data" class="rounded-3xl border border-slate-200/60 bg-white p-6 sm:p-8 shadow-xl space-y-6">
            @csrf
            <div class="grid gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Judul Dokumentasi</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea name="description" rows="4" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                </div>
                <div class="space-y-3" data-gallery-uploader>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Galeri Foto Workshop</label>
                            <p class="text-xs text-slate-500">Pilih minimal satu foto highlight kegiatan. Anda dapat memilih beberapa file sekaligus.</p>
                        </div>
                        <button type="button" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-4 py-2 text-sm font-semibold text-[#FAF8F1] shadow-lg shadow-[#822021]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70 hover:text-[#FAF8F1]" data-gallery-trigger>
                            <x-heroicon-o-plus class="h-4 w-4" />
                            Tambah Foto
                        </button>
                    </div>
                    <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple class="sr-only" data-gallery-input>
                    <div class="rounded-3xl border border-dashed border-indigo-200 bg-indigo-50/50 p-4">
                        <div class="grid gap-4 md:grid-cols-3" data-gallery-preview>
                            <div data-gallery-empty class="col-span-full flex h-40 flex-col items-center justify-center gap-3 text-slate-400">
                                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/80 shadow-inner">
                                    <x-heroicon-o-photo class="h-5 w-5" />
                                </span>
                                <p class="px-6 text-center text-xs font-medium">Belum ada foto yang dipilih. Klik tombol di atas untuk menambahkan dokumentasi.</p>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-slate-500">Format yang didukung: JPG atau PNG dengan ukuran maksimal 4MB per file.</p>
                    </div>
                    @if ($errors->has('gallery.*'))
                        <p class="text-xs font-medium text-rose-500">{{ $errors->first('gallery.*') }}</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700">URL Dokumentasi (opsional)</label>
                    <input type="url" name="media_url" value="{{ old('media_url') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500" placeholder="https://...">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Terkait Event</label>
                    <select name="event_id" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Pilih Event --</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}" @selected(old('event_id') == $event->id)>{{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 text-sm">
                <a href="{{ route('admin.portfolios.index') }}" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-4 py-2 font-medium text-[#FAF8F1] transition hover:bg-[#822021]/70 hover:text-[#FAF8F1]">Batal</a>
                <button class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-4 py-2 font-semibold text-[#FAF8F1] shadow-lg shadow-[#822021]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70 hover:text-[#FAF8F1]">Simpan Portofolio</button>
            </div>
        </form>

        <aside class="space-y-5 rounded-3xl border border-white/60 bg-white/70 p-6 shadow-xl backdrop-blur">
            <div>
                <h2 class="text-sm font-semibold text-slate-700">Standar Kualitas</h2>
                <p class="mt-2 text-sm text-slate-500">Gunakan foto dengan pencahayaan baik, sertakan caption singkat yang menjelaskan highlight kegiatan.</p>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-slate-700">Format URL</h2>
                <p class="mt-2 text-sm text-slate-500">Dukung tautan dari Google Drive, YouTube, atau platform penyimpanan gambar yang dapat diakses publik.</p>
            </div>
            <div class="rounded-2xl bg-gradient-to-br from-sky-500/10 via-indigo-500/10 to-purple-500/10 p-5">
                <h3 class="text-sm font-semibold text-slate-700">Inspirasi Konten</h3>
                <p class="mt-2 text-sm text-slate-500">Pastikan ada kombinasi foto suasana, aktivitas peserta, dan hasil akhir karya.</p>
            </div>
        </aside>
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
                            item.className = 'relative overflow-hidden rounded-2xl border border-indigo-200 bg-white shadow-sm';

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
                            caption.className = 'border-t border-indigo-100 px-3 py-2 text-xs font-medium text-slate-600 truncate';
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
                            item.classList.toggle('ring-indigo-400', checkbox.checked);
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
