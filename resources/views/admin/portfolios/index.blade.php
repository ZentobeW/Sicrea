@php($tabs = [
    ['label' => 'Event', 'route' => route('admin.events.index'), 'active' => request()->routeIs('admin.events.*'), 'icon' => '📅'],
    ['label' => 'Pendaftaran', 'route' => route('admin.registrations.index'), 'active' => request()->routeIs('admin.registrations.*'), 'icon' => '🧾'],
    ['label' => 'Portofolio', 'route' => route('admin.portfolios.index'), 'active' => request()->routeIs('admin.portfolios.*'), 'icon' => '🖼️'],
])

<x-layouts.admin title="Portofolio Workshop" subtitle="Kurasi dokumentasi kegiatan untuk memperkuat storytelling program di halaman publik." :tabs="$tabs">
    <x-slot name="actions">
        <a href="{{ route('admin.portfolios.create') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-lg shadow-indigo-500/20 transition hover:-translate-y-0.5 hover:bg-slate-100">
            <span class="text-lg">＋</span>
            Tambah Portofolio
        </a>
    </x-slot>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-slate-200/60 bg-white/90 p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Portofolio</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $insight['total'] }}</p>
        </div>
        <div class="rounded-2xl border border-indigo-200/70 bg-indigo-50/80 p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">Terhubung ke Event</p>
            <p class="mt-2 text-2xl font-semibold text-indigo-700">{{ $insight['linked'] }}</p>
            <p class="text-xs text-indigo-600/80 mt-1">Menarik data dari event terkait.</p>
        </div>
        <div class="rounded-2xl border border-emerald-200/70 bg-emerald-50/80 p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-emerald-600">Terbaru</p>
            <p class="mt-2 text-base font-semibold text-emerald-700">{{ optional($latestUpdate?->updated_at)->diffForHumans() ?? 'Belum ada' }}</p>
            <p class="text-xs text-emerald-600/80 mt-1">Perbarui konten secara rutin.</p>
        </div>
        <div class="rounded-2xl border border-amber-200/70 bg-amber-50/90 p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-amber-600">Kualitas Visual</p>
            <p class="mt-2 text-sm text-amber-700 leading-relaxed">Unggah dokumentasi resolusi tinggi agar tampil maksimal di landing page.</p>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200/60 bg-white/90 shadow-xl">
        <div class="flex flex-col gap-4 border-b border-slate-200/60 p-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Daftar Portofolio</h2>
                <p class="text-sm text-slate-500">Dokumentasi kegiatan yang tampil pada halaman portfolio publik.</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200/70 text-sm">
                <thead class="bg-slate-50/80 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">Judul</th>
                        <th class="px-6 py-3 text-left">Terkait Event</th>
                        <th class="px-6 py-3 text-left">Diperbarui</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/60 bg-white/60">
                    @forelse ($portfolios as $portfolio)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-6 py-4 align-top">
                                <div class="font-semibold text-slate-900">{{ $portfolio->title }}</div>
                                <div class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $portfolio->description }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 align-top">{{ $portfolio->event?->title ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600 align-top">{{ $portfolio->updated_at->translatedFormat('d M Y H:i') }}</td>
                            <td class="px-6 py-4 text-right align-top">
                                <div class="inline-flex items-center gap-2 text-xs font-medium">
                                    <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="inline-flex items-center gap-1 rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-indigo-600 transition hover:border-indigo-300 hover:bg-indigo-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.portfolios.destroy', $portfolio) }}" onsubmit="return confirm('Hapus portofolio ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center gap-1 rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-rose-600 transition hover:border-rose-300 hover:bg-rose-100">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">Belum ada portofolio.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-between items-center text-sm text-slate-500">
        <div>Menampilkan {{ $portfolios->firstItem() }}-{{ $portfolios->lastItem() }} dari {{ $portfolios->total() }} portofolio</div>
        <div>{{ $portfolios->links() }}</div>
    </div>
</x-layouts.admin>
