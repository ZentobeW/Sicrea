<x-layouts.app :title="'Kelola Event'">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Manajemen Event</h1>
            <p class="text-sm text-slate-500">Buat, publikasi, dan kelola jadwal workshop.</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Buat Event</a>
    </div>

    <div class="bg-white border border-slate-100 rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Judul</th>
                    <th class="px-4 py-3 text-left">Jadwal</th>
                    <th class="px-4 py-3 text-left">Kuota</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($events as $event)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <div class="font-medium text-slate-800">{{ $event->title }}</div>
                            <div class="text-xs text-slate-500">Rp{{ number_format($event->price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $event->start_at->translatedFormat('d M Y H:i') }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $event->available_slots ?? '∞' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $event->status->value === 'published' ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-600' }}">{{ $event->status->label() }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.events.edit', $event) }}" class="text-indigo-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Hapus event ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-slate-500">Belum ada data event.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>
</x-layouts.app>
