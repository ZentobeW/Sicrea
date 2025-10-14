<x-layouts.app :title="'Buat Event'">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-semibold text-slate-800 mb-6">Buat Event Baru</h1>

        <form method="POST" action="{{ route('admin.events.store') }}" class="bg-white border border-slate-100 rounded-xl shadow-sm p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700">Judul Event</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Slug (opsional)</label>
                <input type="text" name="slug" value="{{ old('slug') }}"
                    class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Mulai</label>
                    <input type="datetime-local" name="start_at" value="{{ old('start_at') }}"
                        class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Selesai</label>
                    <input type="datetime-local" name="end_at" value="{{ old('end_at') }}"
                        class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Lokasi</label>
                <input type="text" name="location" value="{{ old('location') }}"
                    class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Kuota (opsional)</label>
                    <input type="number" name="capacity" value="{{ old('capacity') }}" min="1"
                        class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Harga</label>
                    <input type="number" name="price" value="{{ old('price', 0) }}" min="0"
                        class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Deskripsi</label>
                <textarea name="description" rows="5"
                    class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="hidden" name="publish" value="0">
                <input type="checkbox" name="publish" value="1" id="publish" {{ old('publish') ? 'checked' : '' }}>
                <label for="publish" class="text-sm text-slate-600">Publikasikan setelah disimpan</label>
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.events.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Batal</a>
                <button class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Simpan Event</button>
            </div>
        </form>
    </div>
</x-layouts.app>
