@php($tabs = [
    ['label' => 'Event', 'route' => route('admin.events.index'), 'active' => request()->routeIs('admin.events.*'), 'icon' => 'calendar'],
    ['label' => 'Pendaftaran', 'route' => route('admin.registrations.index'), 'active' => request()->routeIs('admin.registrations.*'), 'icon' => 'document-text'],
    ['label' => 'Portofolio', 'route' => route('admin.portfolios.index'), 'active' => request()->routeIs('admin.portfolios.*'), 'icon' => 'photo'],
])

<x-layouts.admin :title="'Edit Portofolio: ' . $portfolio->title" subtitle="Sempurnakan cerita visual agar audiens merasakan pengalaman workshop secara utuh." :tabs="$tabs" :back-url="route('admin.portfolios.index')">
    <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
        <form method="POST" action="{{ route('admin.portfolios.update', $portfolio) }}" class="rounded-3xl border border-slate-200/60 bg-white/95 p-6 sm:p-8 shadow-xl space-y-6">
            @csrf
            @method('PUT')
            <div class="grid gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Judul Dokumentasi</label>
                    <input type="text" name="title" value="{{ old('title', $portfolio->title) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea name="description" rows="4" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $portfolio->description) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700">URL Dokumentasi</label>
                    <input type="url" name="media_url" value="{{ old('media_url', $portfolio->media_url) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500" placeholder="https://...">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700">Terkait Event</label>
                    <select name="event_id" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Pilih Event --</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}" @selected(old('event_id', $portfolio->event_id) == $event->id)>{{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 text-sm">
                <a href="{{ route('admin.portfolios.index') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 font-medium text-slate-600 transition hover:border-slate-300">Batal</a>
                <button class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:-translate-y-0.5 hover:bg-indigo-700">Perbarui Portofolio</button>
            </div>
        </form>

        <aside class="space-y-5 rounded-3xl border border-white/60 bg-white/70 p-6 shadow-xl backdrop-blur">
            <div>
                <h2 class="text-sm font-semibold text-slate-700">Catatan Revisi</h2>
                <p class="mt-2 text-sm text-slate-500">Selaraskan deskripsi dengan tema event dan tambahkan insight menarik dari peserta atau mentor.</p>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-slate-700">Kualitas Media</h2>
                <p class="mt-2 text-sm text-slate-500">Gunakan tautan permanen agar asset tidak mudah kedaluwarsa dan pastikan permission publik.</p>
            </div>
            <div class="rounded-2xl bg-gradient-to-br from-emerald-500/10 via-indigo-500/10 to-purple-500/10 p-5">
                <h3 class="text-sm font-semibold text-slate-700">Tautan Publik</h3>
                <a href="{{ $portfolio->media_url ?? '#' }}" class="mt-2 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700" target="_blank" rel="noopener">Lihat Dokumentasi →</a>
            </div>
        </aside>
    </div>
</x-layouts.admin>
