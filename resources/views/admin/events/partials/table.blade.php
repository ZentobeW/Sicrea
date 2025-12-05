<form method="GET" action="{{ route('admin.registrations.export') }}" class="mt-6 space-y-4">
    <div class="flex flex-col gap-3 rounded-2xl bg-[#FCF5E6] px-4 py-3 text-base text-[#822021] lg:flex-row lg:items-center lg:justify-between">
        <div class="flex flex-wrap items-center gap-3">
            <label class="font-semibold text-[#822021]">Jenis Laporan</label>
            <select name="report" class="rounded-full border border-[#F7C8B8] bg-white px-4 py-2 text-sm font-semibold text-[#822021] focus:border-[#822021] focus:outline-none">
                <option value="finance">Laporan Keuangan</option>
                <option value="participants">Laporan Peserta</option>
            </select>
            <span class="text-sm text-[#822021]">Centang event yang ingin digabung lalu klik unduh.</span>
        </div>
        <div class="flex flex-wrap items-center gap-4">
            <label for="select-all-events" class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-2 text-sm font-semibold text-[#822021] shadow-inner shadow-[#F7C8B8]/40">
                <input id="select-all-events" type="checkbox" class="h-4 w-4 rounded border-[#822021] text-[#822021] focus:ring-[#822021]" checked>
                <span>Pilih semua event</span>
            </label>
            <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-5 py-2 text-sm font-semibold text-[#FCF5E6] shadow-md shadow-[#B49F9A]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70">
                ⇩ Unduh Laporan Terpilih
            </button>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-[#FFE0D6] text-base">
            <thead class="text-sm uppercase tracking-wide text-[#822021]">
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
            <tbody class="divide-y divide-[#FFE0D6] bg-[#FCF5E6]">
                @forelse ($events as $event)
                    @php
                        $capacity = $event->capacity ?: null;
                        $filled = $event->confirmed_registrations_count;
                        $quotaLabel = $capacity ? $filled . '/' . $capacity : $filled . ' peserta';
                        $progress = $capacity ? min(100, ($filled / $capacity) * 100) : null;
                    @endphp
                    <tr class="transition hover:bg-white">
                        <td class="px-5 py-4 align-top">
                            <input type="checkbox" name="event_ids[]" value="{{ $event->id }}" class="event-checkbox h-4 w-4 rounded border-[#822021] text-[#822021] focus:ring-[#822021]" checked />
                        </td>
                        <td class="px-5 py-4 align-top">
                            <div class="font-semibold text-[#822021]">{{ $event->title }}</div>
                            <p class="mt-1 text-sm text-[#822021]">Diperbarui {{ $event->updated_at->diffForHumans() }}</p>
                        </td>
                        <td class="px-5 py-4 align-top text-[#822021]">
                            <div class="text-base">{{ $event->start_at->translatedFormat('d M Y H:i') }}</div>
                            <div class="text-sm text-[#822021]">s/d {{ $event->end_at->translatedFormat('d M Y H:i') }}</div>
                            <div class="mt-2 inline-flex items-center gap-2 rounded-full bg-[#FCF5E6] px-3 py-1 text-sm text-[#822021]">
                                <x-heroicon-o-map-pin class="h-4 w-4" />
                                <span class="font-semibold">{{ $event->venue_name }}</span>
                            </div>
                            <p class="mt-1 text-sm text-[#822021]">{{ $event->venue_address }}</p>
                        </td>
                        <td class="px-5 py-4 align-top text-[#822021]">
                            <div class="font-semibold text-base">{{ $event->tutor_name }}</div>
                            <p class="text-sm text-[#822021]">Instruktur utama</p>
                        </td>
                        <td class="px-5 py-4 align-top text-[#822021]">
                            <div class="font-semibold text-base">{{ $quotaLabel }}</div>
                            @if ($progress)
                                <div class="mt-2 h-1.5 w-28 rounded-full bg-[#FCF5E6]" style="--progress: {{ $progress }};">
                                    <div class="h-full rounded-full bg-[#F68C7B]" style="width: calc(var(--progress) * 1%);"></div>
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-4 align-top text-[#822021]">
                            <div class="font-semibold text-base">Rp{{ number_format($event->price, 0, ',', '.') }}</div>
                            <p class="text-sm text-[#822021]">Per peserta</p>
                        </td>
                        <td class="px-5 py-4 align-top">
                            <span @class([
                                'inline-flex items-center gap-2 rounded-full px-3 py-1 text-sm font-semibold',
                                'bg-[#EAF9F1] text-[#2D8F64]' => $event->status->value === 'published',
                                'bg-[#FFF0E7] text-[#822021]' => $event->status->value !== 'published',
                            ])>
                                <span @class([
                                    'block h-2 w-2 rounded-full',
                                    'bg-[#2D8F64]' => $event->status->value === 'published',
                                    'bg-[#822021]' => $event->status->value !== 'published',
                                ])></span>
                                {{ $event->status->label() }}
                            </span>
                        </td>
                        <td class="px-5 py-4 align-top text-right">
                            <div class="inline-flex items-center justify-end gap-2">
                                <a href="{{ route('admin.registrations.index', ['event_id' => $event->id]) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#822021] text-[#FCF5E6] shadow-inner transition hover:-translate-y-0.5 hover:bg-[#822021]/70" title="Lihat peserta">
                                    <span class="sr-only">Peserta</span>
                                    <x-heroicon-o-user-group class="h-4 w-4" />
                                </a>
                                <a href="{{ route('admin.reports.index', ['event_id' => $event->id, 'report' => 'participants']) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#822021] text-[#FCF5E6] shadow-inner transition hover:-translate-y-0.5 hover:bg-[#822021]/70" title="Laporan peserta">
                                    <span class="sr-only">Laporan Peserta</span>
                                    <x-heroicon-o-presentation-chart-bar class="h-4 w-4" />
                                </a>
                                <a href="{{ route('admin.reports.index', ['event_id' => $event->id, 'report' => 'finance']) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#822021] text-[#FCF5E6] shadow-inner transition hover:-translate-y-0.5 hover:bg-[#822021]/70" title="Laporan keuangan">
                                    <span class="sr-only">Laporan Keuangan</span>
                                    <x-heroicon-o-credit-card class="h-4 w-4" />
                                </a>
                                <a href="{{ route('admin.events.edit', $event) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#822021] text-[#FCF5E6] shadow-inner transition hover:-translate-y-0.5 hover:bg-[#822021]/70 hover:text-[#FCF5E6]" title="Edit event">
                                    <x-heroicon-o-pencil-square class="h-5 w-5" />
                                </a>
                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline-flex" onsubmit="return confirm('Hapus event ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#822021] text-[#FCF5E6] shadow-inner transition hover:-translate-y-0.5 hover:bg-[#822021]/70 hover:text-[#FCF5E6]" title="Hapus event">
                                        <x-heroicon-o-trash class="h-5 w-5" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-12 text-center text-base text-[#822021]">
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

<div class="mt-6 flex flex-col gap-3 text-base text-[#822021] sm:flex-row sm:items-center sm:justify-between">
    <div>
        @if ($events->count())
            Menampilkan {{ $events->firstItem() }}-{{ $events->lastItem() }} dari {{ $events->total() }} event
        @else
            Menampilkan 0 event
        @endif
    </div>
    <div class="sm:ml-auto pagination-links">{{ $events->links() }}</div>
</div>
