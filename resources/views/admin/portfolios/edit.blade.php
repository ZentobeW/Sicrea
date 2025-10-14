<x-layouts.app :title="'Edit Portofolio'">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-semibold text-slate-800 mb-6">Edit Portofolio</h1>

        <form method="POST" action="{{ route('admin.portfolios.update', $portfolio) }}" class="bg-white border border-slate-100 rounded-xl shadow-sm p-6 space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-slate-700">Judul</label>
                <input type="text" name="title" value="{{ old('title', $portfolio->title) }}"
                    class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Deskripsi</label>
                <textarea name="description" rows="4"
                    class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $portfolio->description) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">URL Dokumentasi</label>
                <input type="url" name="media_url" value="{{ old('media_url', $portfolio->media_url) }}"
                    class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Terkait Event</label>
                <select name="event_id"
                    class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- Pilih Event --</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" @selected(old('event_id', $portfolio->event_id) == $event->id)>{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.portfolios.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Batal</a>
                <button class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-layouts.app>
