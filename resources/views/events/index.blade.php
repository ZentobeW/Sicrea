@php use Illuminate\Support\Str; @endphp
<x-layouts.app :title="'Daftar Event'">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Event & Workshop</h1>
            <p class="text-sm text-slate-500">Pilih kegiatan terbaik dari Kreasi Hangat.</p>
        </div>
        <form method="GET" class="flex items-center gap-2">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari event"
                class="rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <button class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Cari</button>
        </form>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($events as $event)
            <div class="rounded-xl bg-white shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between text-xs text-slate-500 uppercase">
                        <span>{{ $event->start_at->translatedFormat('d M Y H:i') }}</span>
                        <span class="font-medium text-indigo-600">Rp{{ number_format($event->price, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">{{ $event->title }}</h2>
                        <p class="mt-2 text-sm text-slate-500 line-clamp-3">{{ Str::limit(strip_tags($event->description), 120) }}</p>
                    </div>
                    <div class="text-sm text-slate-500 flex items-center gap-2">
                        <svg class="h-4 w-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c.828 0 1.5-.672 1.5-1.5S12.828 8 12 8s-1.5.672-1.5 1.5S11.172 11 12 11z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 10.5c0 7.5-8.25 11.25-8.25 11.25S3.75 18 3.75 10.5a8.25 8.25 0 1116.5 0z" />
                        </svg>
                        <span>{{ $event->location }}</span>
                    </div>
                </div>
                <div class="bg-slate-50 px-6 py-4 flex items-center justify-between">
                    <span class="text-xs text-slate-500">Kuota tersisa: {{ $event->available_slots ?? 'Tidak terbatas' }}</span>
                    <a href="{{ route('events.show', $event->slug) }}"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white hover:bg-indigo-700">Detail</a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-white rounded-xl border border-dashed border-slate-200">
                <p class="text-slate-500">Belum ada event yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>
</x-layouts.app>
