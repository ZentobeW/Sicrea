<x-layouts.app :title="'Portofolio Workshop'">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Portofolio Workshop</h1>
            <p class="text-sm text-slate-500">Kelola dokumentasi hasil kegiatan untuk publikasi.</p>
        </div>
        <a href="{{ route('admin.portfolios.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Tambah Portofolio</a>
    </div>

    <div class="bg-white border border-slate-100 rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Judul</th>
                    <th class="px-4 py-3 text-left">Terkait Event</th>
                    <th class="px-4 py-3 text-left">Diperbarui</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($portfolios as $portfolio)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <div class="font-medium text-slate-800">{{ $portfolio->title }}</div>
                            <div class="text-xs text-slate-500 line-clamp-1">{{ $portfolio->description }}</div>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $portfolio->event?->title ?? '-' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $portfolio->updated_at->translatedFormat('d M Y H:i') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="text-indigo-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.portfolios.destroy', $portfolio) }}" onsubmit="return confirm('Hapus portofolio ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-10 text-center text-slate-500">Belum ada portofolio.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $portfolios->links() }}
    </div>
</x-layouts.app>
