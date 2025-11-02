@php($tabs = [
    ['label' => 'Event', 'route' => route('admin.events.index'), 'active' => request()->routeIs('admin.events.*'), 'icon' => '📅'],
    ['label' => 'Pendaftaran', 'route' => route('admin.registrations.index'), 'active' => request()->routeIs('admin.registrations.*'), 'icon' => '🧾'],
    ['label' => 'Portofolio', 'route' => route('admin.portfolios.index'), 'active' => request()->routeIs('admin.portfolios.*'), 'icon' => '🖼️'],
])

<x-layouts.admin :title="'Edit Event: ' . $event->title" subtitle="Perbarui detail workshop agar peserta mendapatkan informasi paling relevan." :tabs="$tabs" :back-url="route('admin.events.index')">
    <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
        <form method="POST" action="{{ route('admin.events.update', $event) }}" class="rounded-3xl border border-slate-200/60 bg-white/95 p-6 sm:p-8 shadow-xl space-y-6">
            @csrf
            @method('PUT')
            <div class="grid gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Judul Event</label>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $event->slug) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Mulai</label>
                        <input type="datetime-local" name="start_at" value="{{ old('start_at', $event->start_at->format('Y-m-d\TH:i')) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Selesai</label>
                        <input type="datetime-local" name="end_at" value="{{ old('end_at', $event->end_at->format('Y-m-d\TH:i')) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location', $event->location) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Kuota (opsional)</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $event->capacity) }}" min="1" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Harga</label>
                        <div class="mt-2 flex rounded-2xl border border-slate-200 bg-white shadow-inner focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                            <span class="inline-flex items-center px-4 text-sm text-slate-400">Rp</span>
                            <input type="number" name="price" value="{{ old('price', $event->price) }}" min="0" class="flex-1 rounded-2xl border-0 bg-transparent px-2 py-3 text-sm focus:ring-0" required>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea name="description" rows="6" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $event->description) }}</textarea>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4">
                <label class="inline-flex items-center gap-3 text-sm font-medium text-slate-600">
                    <input type="hidden" name="publish" value="0">
                    <input type="checkbox" name="publish" value="1" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" {{ old('publish', $event->status->value === 'published') ? 'checked' : '' }}>
                    Publikasikan setelah disimpan
                </label>
                <div class="flex items-center gap-3 text-sm">
                    <a href="{{ route('admin.events.index') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 font-medium text-slate-600 transition hover:border-slate-300">Batal</a>
                    <button class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:-translate-y-0.5 hover:bg-indigo-700">Perbarui Event</button>
                </div>
            </div>
        </form>

        <aside class="space-y-5 rounded-3xl border border-white/60 bg-white/70 p-6 shadow-xl backdrop-blur">
            <div>
                <h2 class="text-sm font-semibold text-slate-700">Status Publikasi</h2>
                <p class="mt-2 text-sm text-slate-500 leading-relaxed">Aktifkan opsi publikasi untuk menampilkan event di halaman publik. Draft tersimpan tetap bisa diedit kapan saja.</p>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-slate-700">Catatan Internal</h2>
                <ul class="mt-3 space-y-2 text-sm text-slate-500">
                    <li class="flex items-center gap-2"><span class="text-indigo-500">•</span> Perbarui narahubung jika ada pergantian PIC</li>
                    <li class="flex items-center gap-2"><span class="text-indigo-500">•</span> Pastikan stok materi modul telah siap</li>
                    <li class="flex items-center gap-2"><span class="text-indigo-500">•</span> Reviu ulang harga sesuai segmentasi peserta</li>
                </ul>
            </div>
            <div class="rounded-2xl bg-gradient-to-br from-emerald-500/10 via-indigo-500/10 to-purple-500/10 p-5">
                <h3 class="text-sm font-semibold text-slate-700">Lihat Halaman Publik</h3>
                <p class="mt-2 text-sm text-slate-500">{{ $event->status->value === 'published' ? 'Event ini sudah tampil di katalog peserta.' : 'Publikasikan event untuk menampilkannya di katalog.' }}</p>
                <a href="{{ route('events.show', $event) }}" class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700">Buka Preview →</a>
            </div>
        </aside>
    </div>
</x-layouts.admin>
