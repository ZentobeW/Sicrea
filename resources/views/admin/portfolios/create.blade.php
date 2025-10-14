<x-layouts.app :title="'Tambah Portofolio'">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-semibold text-slate-800 mb-6">Tambah Portofolio</h1>

        <form method="POST" action="{{ route('admin.portfolios.store') }}" class="bg-white border border-slate-100 rounded-xl shadow-sm p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700">Judul</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Deskripsi</label>
                <textarea name="description" rows="4"
                    class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">URL Dokumentasi (opsional)</label>
                <input type="url" name="media_url" value="{{ old('media_url') }}"
                    class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Terkait Event</label>
                <select name="event_id"
                    class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- Pilih Event --</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" @selected(old('event_id') == $event->id)>{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.portfolios.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Batal</a>
                <button class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Simpan</button>
            </div>
        </form>
    </div>
</x-layouts.app>
