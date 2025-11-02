@php($tabs = [
    ['label' => 'Event', 'route' => route('admin.events.index'), 'active' => request()->routeIs('admin.events.*'), 'icon' => '📅'],
    ['label' => 'Pendaftaran', 'route' => route('admin.registrations.index'), 'active' => request()->routeIs('admin.registrations.*'), 'icon' => '🧾'],
    ['label' => 'Portofolio', 'route' => route('admin.portfolios.index'), 'active' => request()->routeIs('admin.portfolios.*'), 'icon' => '🖼️'],
])

<x-layouts.admin title="Tambah Portofolio" subtitle="Abadikan momen terbaik dari workshop dan tampilkan pada galeri inspirasi." :tabs="$tabs" :back-url="route('admin.portfolios.index')">
    <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
        <form method="POST" action="{{ route('admin.portfolios.store') }}" class="rounded-3xl border border-slate-200/60 bg-white/95 p-6 sm:p-8 shadow-xl space-y-6">
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
                <a href="{{ route('admin.portfolios.index') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 font-medium text-slate-600 transition hover:border-slate-300">Batal</a>
                <button class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:-translate-y-0.5 hover:bg-indigo-700">Simpan Portofolio</button>
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
</x-layouts.admin>
