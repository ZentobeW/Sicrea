<style>
    /* --- CUSTOM PAGINATION STYLE --- */

    /* 1. Teks "Showing ... results" */
    nav[role="navigation"] p.text-sm {
        color: #822021 !important; /* Warna Teks Merah */
    }
    nav[role="navigation"] p.text-sm span {
        color: #822021 !important; /* Warna Angka Tebal Merah */
        font-weight: 700;
    }

    /* 2. Container Tombol Pagination (Desktop) */
    nav[role="navigation"] > div:last-child > div > span {
        box-shadow: none !important; /* Hilangkan shadow bawaan */
    }

    /* 3. Semua Tombol (Angka & Panah) - Default State */
    nav[role="navigation"] a, 
    nav[role="navigation"] span[aria-current="page"] span,
    nav[role="navigation"] span[aria-disabled="true"] span {
        background-color: #FCF5E6 !important; /* Background Krem */
        color: #822021 !important;             /* Text Merah */
        border: 1px solid #822021 !important;  /* Border Merah */
        border-radius: 8px;                    /* Sedikit Rounded */
        margin: 0 2px;                         /* Jarak antar tombol */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 36px;
        min-width: 36px;
        padding: 0 10px;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    /* 4. Tombol Disabled / Mentok (Panah Kiri/Kanan saat disable) */
    nav[role="navigation"] span[aria-disabled="true"] span {
        background-color: #FCF5E6 !important; /* Tetap Krem */
        color: #822021 !important;             /* Tetap Merah */
        opacity: 0.5;                          /* Agak transparan agar terlihat non-aktif */
        cursor: not-allowed;
    }
    /* Memastikan icon SVG di dalam tombol disabled juga berwarna merah */
    nav[role="navigation"] span[aria-disabled="true"] span svg {
        color: #822021 !important;
        fill: currentColor;
    }

    /* 5. Tombol Aktif (Halaman saat ini) */
    nav[role="navigation"] span[aria-current="page"] span {
        background-color: #822021 !important; /* Background Merah */
        color: #FCF5E6 !important;            /* Text Krem */
        border-color: #822021 !important;
    }

    /* 6. Efek Hover (Untuk tombol yang bisa diklik) */
    nav[role="navigation"] a:hover {
        background-color: #822021 !important; /* Hover jadi Merah */
        color: #FCF5E6 !important;            /* Text jadi Krem */
        transform: scale(1.1);                /* Efek Zoom */
        z-index: 10;
    }

    /* 7. Icon SVG (Panah Previous/Next) */
    nav[role="navigation"] svg {
        width: 16px;
        height: 16px;
        stroke-width: 2.5; /* Menebalkan panah */
    }
    
    /* Hilangkan style rounded bawaan tailwind yang menyatu */
    nav[role="navigation"] span.relative.z-0.inline-flex.shadow-sm.rounded-md {
        box-shadow: none !important;
    }
    nav[role="navigation"] a.relative.inline-flex.items-center,
    nav[role="navigation"] span[aria-disabled="true"] span {
        margin-left: 4px !important; /* Beri jarak antar tombol */
    }
</style>

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
            <label for="select-all-events" class="inline-flex items-center gap-2  px-3 py-2 text-sm font-semibold text-[#822021] shadow-inner shadow-[#F7C8B8]/40 cursor-pointer">
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
                            <div class="mt-2 inline-flex items-center gap-2  px-3 py-1 text-sm text-[#822021]">
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
                                <div class="mt-2 h-1.5 w-28 " style="--progress: {{ $progress }};">
                                    <div class="h-full rounded-full bg-[#822021]" style="width: calc(var(--progress) * 1%);"></div>
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

{{-- PAGINATION --}}
<div class="mt-6 flex flex-col gap-3 text-base text-[#822021] sm:flex-row sm:items-center sm:justify-between">
    <div>
        @if ($events->count())
            Menampilkan {{ $events->firstItem() }}-{{ $events->lastItem() }} dari {{ $events->total() }} event
        @else
            Menampilkan 0 event
        @endif
    </div>
    <div class="sm:ml-auto pagination-links">
        {{ $events->links() }}
    </div>
</div>