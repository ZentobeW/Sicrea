@php($tabs = [
    ['label' => 'Event', 'route' => route('admin.events.index'), 'active' => request()->routeIs('admin.events.*'), 'icon' => '📅'],
    ['label' => 'Pendaftaran', 'route' => route('admin.registrations.index'), 'active' => request()->routeIs('admin.registrations.*'), 'icon' => '🧾'],
    ['label' => 'Portofolio', 'route' => route('admin.portfolios.index'), 'active' => request()->routeIs('admin.portfolios.*'), 'icon' => '🖼️'],
])

<x-layouts.admin title="Manajemen Event" subtitle="Rencanakan kalender program, publikasikan workshop terbaik, dan pantau statusnya secara real-time." :tabs="$tabs">
    <x-slot name="actions">
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-lg shadow-indigo-500/20 transition hover:-translate-y-0.5 hover:bg-slate-100">
            <span class="text-lg">＋</span>
            Buat Event
        </a>
    </x-slot>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-slate-200/60 bg-white/90 p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Event</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $overview['total'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Termasuk semua status event.</p>
        </div>
        <div class="rounded-2xl border border-emerald-200/70 bg-emerald-50/80 p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-emerald-600">Published</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-700">{{ $overview['published'] }}</p>
            <p class="text-xs text-emerald-600/80 mt-1">Tayang di halaman publik.</p>
        </div>
        <div class="rounded-2xl border border-amber-200/70 bg-amber-50/90 p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-amber-600">Draft</p>
            <p class="mt-2 text-2xl font-semibold text-amber-700">{{ $overview['drafts'] }}</p>
            <p class="text-xs text-amber-600/80 mt-1">Perlu dipublikasikan.</p>
        </div>
        <div class="rounded-2xl border border-indigo-200/70 bg-indigo-50/90 p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">Event Terdekat</p>
            @if ($nextEvent)
                <p class="mt-2 text-base font-semibold text-indigo-700">{{ $nextEvent->title }}</p>
                <p class="text-xs text-indigo-600/80 mt-1">{{ $nextEvent->start_at->translatedFormat('d M Y H:i') }}</p>
            @else
                <p class="mt-2 text-base font-semibold text-indigo-700">Belum ada jadwal</p>
                <p class="text-xs text-indigo-600/80 mt-1">Publikasikan event untuk menjadwalkan.</p>
            @endif
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200/60 bg-white/90 shadow-xl">
        <div class="flex flex-col gap-4 border-b border-slate-200/60 p-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Daftar Event</h2>
                <p class="text-sm text-slate-500">Kelola event yang sedang berjalan maupun yang akan datang.</p>
            </div>
            <div class="flex items-center gap-3 text-sm text-slate-500">
                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    Published
                </span>
                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                    <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                    Draft
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200/70 text-sm">
                <thead class="bg-slate-50/80 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">Judul</th>
                        <th class="px-6 py-3 text-left">Jadwal</th>
                        <th class="px-6 py-3 text-left">Kuota</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/60 bg-white/60">
                    @forelse ($events as $event)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-6 py-4 align-top">
                                <div class="font-semibold text-slate-900">{{ $event->title }}</div>
                                <div class="text-xs text-slate-500 mt-1">Rp{{ number_format($event->price, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 align-top">
                                <div>{{ $event->start_at->translatedFormat('d M Y H:i') }}</div>
                                <div class="text-xs text-slate-400">s/d {{ $event->end_at->translatedFormat('d M Y H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 align-top">
                                {{ $event->available_slots ?? '∞' }}
                            </td>
                            <td class="px-6 py-4 align-top">
                                <span @class([
                                    'inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold transition',
                                    'bg-emerald-100 text-emerald-600 ring-1 ring-emerald-500/20' => $event->status->value === 'published',
                                    'bg-slate-100 text-slate-600 ring-1 ring-slate-500/10' => $event->status->value !== 'published',
                                ])>
                                    <span class="h-2 w-2 rounded-full {{ $event->status->value === 'published' ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ $event->status->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right align-top">
                                <div class="inline-flex items-center gap-2 text-xs font-medium">
                                    <a href="{{ route('admin.events.edit', $event) }}" class="inline-flex items-center gap-1 rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-indigo-600 transition hover:border-indigo-300 hover:bg-indigo-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Hapus event ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center gap-1 rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-rose-600 transition hover:border-rose-300 hover:bg-rose-100">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada data event.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-between items-center text-sm text-slate-500">
        <div>Menampilkan {{ $events->firstItem() }}-{{ $events->lastItem() }} dari {{ $events->total() }} event</div>
        <div>{{ $events->links() }}</div>
    </div>
</x-layouts.admin>
