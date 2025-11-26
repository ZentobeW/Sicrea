<x-layouts.admin title="Kelola Event" subtitle="Tambahkan, edit, atau hapus event dan workshop.">
    <x-slot name="actions">
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-5 py-3 text-sm font-semibold text-[#FAF8F1] shadow-lg shadow-[#822021]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70 hover:text-[#FAF8F1]">
            <x-heroicon-o-plus class="h-5 w-5" />
            Tambah Event Baru
        </a>
    </x-slot>

    {{-- OVERVIEW CARDS --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl bg-white p-5 shadow-[0_25px_60px_-30px_rgba(243,140,118,0.55)]">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#E77B5F]">Total Event</p>
            <p class="mt-3 text-3xl font-semibold text-[#4B2A22]">{{ $overview['total'] }}</p>
            <p class="mt-1 text-xs text-[#9C5A45]">Termasuk semua status.</p>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-[0_25px_60px_-30px_rgba(255,176,130,0.55)]">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#EF935E]">Published</p>
            <p class="mt-3 text-3xl font-semibold text-[#4B2A22]">{{ $overview['published'] }}</p>
            <p class="mt-1 text-xs text-[#9C5A45]">Event yang tampil di katalog.</p>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-[0_25px_60px_-30px_rgba(241,128,128,0.4)]">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#E56D5D]">Draft</p>
            <p class="mt-3 text-3xl font-semibold text-[#4B2A22]">{{ $overview['drafts'] }}</p>
            <p class="mt-1 text-xs text-[#9C5A45]">Perlu dipublikasikan.</p>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-[0_25px_60px_-30px_rgba(210,110,86,0.4)]">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#D2644B]">Event Terdekat</p>
            @if ($nextEvent)
                <p class="mt-3 text-base font-semibold text-[#4B2A22]">{{ $nextEvent->title }}</p>
                <p class="mt-1 text-xs text-[#9C5A45]">{{ $nextEvent->start_at->translatedFormat('d M Y H:i') }}</p>
            @else
                <p class="mt-3 text-base font-semibold text-[#4B2A22]">Belum ada jadwal</p>
                <p class="mt-1 text-xs text-[#9C5A45]">Publikasikan event untuk menampilkannya.</p>
            @endif
        </div>
    </div>

    {{-- LIST & SEARCH --}}
    <div class="rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(240,128,128,0.55)]">
        <div class="flex flex-col gap-4 border-b border-[#FFE0D6] pb-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-[#4B2A22]">Daftar Event</h2>
                <p class="text-sm text-[#A35C45]">Kelola event yang sedang berjalan maupun yang akan datang.</p>
            </div>
            
            {{-- FORM PENCARIAN (Perhatikan atribut data-auto-search) --}}
            <form method="GET" action="{{ route('admin.events.index') }}" class="flex w-full max-w-sm items-center rounded-full bg-[#FFF5F0] px-4 py-2 text-sm shadow-inner ring-1 ring-[#F7C8B8]/30 focus-within:ring-[#E77B5F]">
                <x-heroicon-o-magnifying-glass class="h-5 w-5 text-[#E77B5F]" />
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $filters['search'] }}" 
                    data-auto-search
                    placeholder="Cari judul, venue, atau tutor..." 
                    class="ml-2 flex-1 bg-transparent text-[#4B2A22] placeholder:text-[#D28B7B] focus:outline-none" 
                    autocomplete="off"
                />
                @if ($filters['search'])
                    <a href="{{ route('admin.events.index') }}" class="ml-2 rounded-full bg-[#FFE0D6] p-1 text-[#C16A55] hover:bg-[#FFD1BE] hover:text-[#822021]" title="Hapus Filter">
                        <x-heroicon-o-x-mark class="h-4 w-4" />
                    </a>
                @endif
            </form>
        </div>

        {{-- EXPORT ACTIONS --}}
        <form method="GET" action="{{ route('admin.registrations.export') }}" class="mt-6 space-y-4">
            <div class="flex flex-col gap-3 rounded-2xl bg-[#FFF5F0] px-4 py-3 text-sm text-[#9C5A45] lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-wrap items-center gap-3">
                    <label class="font-semibold text-[#4B2A22]">Jenis Laporan</label>
                    <select name="report" class="rounded-full border border-[#F7C8B8] bg-white px-4 py-2 text-sm font-semibold text-[#4B2A22] focus:border-[#D97862] focus:outline-none">
                        <option value="finance">Laporan Keuangan</option>
                        <option value="participants">Laporan Peserta</option>
                    </select>
                    <span class="text-xs text-[#C16A55]">Centang event yang ingin digabung lalu klik unduh.</span>
                </div>
                <div class="flex flex-wrap items-center gap-4">
                    <label for="select-all-events" class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-2 text-xs font-semibold text-[#822021] shadow-inner shadow-[#F7C8B8]/40">
                        <input id="select-all-events" type="checkbox" class="h-4 w-4 rounded border-[#E77B5F] text-[#822021] focus:ring-[#822021]" checked>
                        <span>Pilih semua event</span>
                    </label>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-5 py-2 text-sm font-semibold text-[#FAF8F1] shadow-md shadow-[#B49F9A]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70">
                        ⇩ Unduh Laporan Terpilih
                    </button>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#FFE0D6] text-sm">
                    <thead class="text-xs uppercase tracking-wide text-[#C16A55]">
                        <tr>
                            <th class="px-5 py-3 text-left">
                                <span class="sr-only">Pilih</span>
                            </th>
                            <th class="px-5 py-3 text-left">Event</th>
                            <th class="px-5 py-3 text-left">Jadwal &amp; Lokasi</th>
                            <th class="px-5 py-3 text-left">Tutor</th>
                            <th class="px-5 py-3 text-left">Kuota</th>
                            <th class="px-5 py-3 text-left">Harga</th>
                            <th class="px-5 py-3 text-left">Status</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#FFE0D6] bg-[#FFF7F3]">
                        @forelse ($events as $event)
                            @php
                                $capacity = $event->capacity ?: null;
                                $filled = $event->confirmed_registrations_count;
                                $quotaLabel = $capacity ? $filled . '/' . $capacity : $filled . ' peserta';
                                $progress = $capacity ? min(100, ($filled / $capacity) * 100) : null;
                            @endphp
                            <tr class="transition hover:bg-white">
                                <td class="px-5 py-4 align-top">
                                    <input type="checkbox" name="event_ids[]" value="{{ $event->id }}" class="event-checkbox h-4 w-4 rounded border-[#E77B5F] text-[#822021] focus:ring-[#822021]" checked />
                                </td>
                                <td class="px-5 py-4 align-top">
                                    <div class="font-semibold text-[#4B2A22]">{{ $event->title }}</div>
                                    <p class="mt-1 text-[11px] text-[#D28B7B]">Diperbarui {{ $event->updated_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-5 py-4 align-top text-[#9C5A45]">
                                    <div>{{ $event->start_at->translatedFormat('d M Y H:i') }}</div>
                                    <div class="text-xs text-[#D28B7B]">s/d {{ $event->end_at->translatedFormat('d M Y H:i') }}</div>
                                    <div class="mt-2 inline-flex items-center gap-2 rounded-full bg-[#FFE8E0] px-3 py-1 text-xs text-[#C16A55]">
                                        <x-heroicon-o-map-pin class="h-4 w-4" />
                                        <span class="font-semibold">{{ $event->venue_name }}</span>
                                    </div>
                                    <p class="mt-1 text-[11px] text-[#D28B7B]">{{ $event->venue_address }}</p>
                                </td>
                                <td class="px-5 py-4 align-top text-[#9C5A45]">
                                    <div class="font-semibold">{{ $event->tutor_name }}</div>
                                    <p class="text-xs text-[#D28B7B]">Instruktur utama</p>
                                </td>
                                <td class="px-5 py-4 align-top text-[#9C5A45]">
                                    <div class="font-semibold">{{ $quotaLabel }}</div>
                                    @if ($progress)
                                        <div class="mt-2 h-1.5 w-28 rounded-full bg-[#FFE0D6]" style="--progress: {{ $progress }};">
                                            <div class="h-full rounded-full bg-[#F68C7B]" style="width: calc(var(--progress) * 1%);"></div>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-5 py-4 align-top text-[#9C5A45]">
                                    <div class="font-semibold">Rp{{ number_format($event->price, 0, ',', '.') }}</div>
                                    <p class="text-xs text-[#D28B7B]">Per peserta</p>
                                </td>
                                <td class="px-5 py-4 align-top">
                                    <span @class([
                                        'inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold',
                                        'bg-[#EAF9F1] text-[#2D8F64]' => $event->status->value === 'published',
                                        'bg-[#FFF0E7] text-[#C16A55]' => $event->status->value !== 'published',
                                    ])>
                                        <span @class([
                                            'block h-2 w-2 rounded-full',
                                            'bg-[#2D8F64]' => $event->status->value === 'published',
                                            'bg-[#E77B5F]' => $event->status->value !== 'published',
                                        ])></span>
                                        {{ $event->status->label() }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 align-top text-right">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.registrations.index', ['event_id' => $event->id]) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#822021] text-[#FAF8F1] shadow-inner transition hover:-translate-y-0.5 hover:bg-[#822021]/70" title="Lihat peserta">
                                            <span class="sr-only">Peserta</span>
                                            <x-heroicon-o-user-group class="h-4 w-4" />
                                        </a>
                                        <a href="{{ route('admin.reports.index', ['event_id' => $event->id, 'report' => 'participants']) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#822021] text-[#FAF8F1] shadow-inner transition hover:-translate-y-0.5 hover:bg-[#822021]/70" title="Laporan peserta">
                                            <span class="sr-only">Laporan Peserta</span>
                                            <x-heroicon-o-presentation-chart-bar class="h-4 w-4" />
                                        </a>
                                        <a href="{{ route('admin.reports.index', ['event_id' => $event->id, 'report' => 'finance']) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#822021] text-[#FAF8F1] shadow-inner transition hover:-translate-y-0.5 hover:bg-[#822021]/70" title="Laporan keuangan">
                                            <span class="sr-only">Laporan Keuangan</span>
                                            <x-heroicon-o-credit-card class="h-4 w-4" />
                                        </a>
                                        <a href="{{ route('admin.events.edit', $event) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#822021] text-[#FAF8F1] shadow-inner transition hover:-translate-y-0.5 hover:bg-[#822021]/70 hover:text-[#FAF8F1]" title="Edit event">
                                            <x-heroicon-o-pencil-square class="h-5 w-5" />
                                        </a>
                                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline-flex" onsubmit="return confirm('Hapus event ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#822021] text-[#FAF8F1] shadow-inner transition hover:-translate-y-0.5 hover:bg-[#822021]/70 hover:text-[#FAF8F1]" title="Hapus event">
                                                <x-heroicon-o-trash class="h-5 w-5" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center text-sm text-[#A35C45]">
                                    @if ($filters['search'])
                                        Tidak ditemukan event dengan kata kunci "<strong>{{ $filters['search'] }}</strong>".
                                        <a href="{{ route('admin.events.index') }}" class="underline hover:text-[#822021]">Reset filter</a>
                                    @else
                                        Belum ada data event.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <div class="mt-6 flex flex-col gap-3 text-sm text-[#A35C45] sm:flex-row sm:items-center sm:justify-between">
            <div>
                @if ($events->count())
                    Menampilkan {{ $events->firstItem() }}-{{ $events->lastItem() }} dari {{ $events->total() }} event
                @else
                    Menampilkan 0 event
                @endif
            </div>
            <div class="sm:ml-auto">{{ $events->links() }}</div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const master = document.getElementById('select-all-events');
                const checkboxes = Array.from(document.querySelectorAll('.event-checkbox'));

                const sync = (checked) => {
                    checkboxes.forEach((cb) => cb.checked = checked);
                };

                if (master) {
                    master.addEventListener('change', (e) => sync(e.target.checked));
                    // default: semua tercentang
                    sync(true);
                }
            });
        </script>
    @endpush
</x-layouts.admin>