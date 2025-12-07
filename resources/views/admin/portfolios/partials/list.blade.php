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

<div class="mb-6 flex flex-col gap-3 text-sm text-[#874532] sm:flex-row sm:items-center sm:justify-between">
    <span>
        @if ($portfolios->total())
            Menampilkan {{ $portfolios->firstItem() }}–{{ $portfolios->lastItem() }} dari {{ $portfolios->total() }} portofolio
        @else
            Belum ada portofolio yang sesuai dengan filter saat ini.
        @endif
    </span>
    <div class="sm:ml-auto sm:block pagination-links">{!! $portfolios->links() !!}</div>
</div>

<div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
    @forelse ($portfolios as $portfolio)
        <article class="group relative flex h-full flex-col overflow-hidden rounded-[32px] border border-[#FFD1BE] bg-white/90 shadow-lg shadow-[#FFBFA8]/40 transition hover:-translate-y-1 hover:shadow-xl">
            <div class="relative aspect-[4/3] overflow-hidden">
                @if ($portfolio->cover_image_url)
                    <img src="{{ $portfolio->cover_image_url }}" alt="{{ $portfolio->title }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105" />
                @else
                    <div class="h-full w-full bg-gradient-to-br from-[#FFD7C7] via-[#FFC4B4] to-[#FFAE96]"></div>
                @endif
                <div class="absolute inset-x-4 top-4 flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-[#F17259] shadow">Portfolio</span>
                    @if ($portfolio->event)
                        <span class="inline-flex items-center gap-2 rounded-full bg-[#FFEDE5]/90 px-3 py-1 text-xs font-medium text-[#A3563F]">{{ $portfolio->event->title }}</span>
                    @endif
                </div>
            </div>

            <div class="flex flex-1 flex-col gap-5 p-6 text-[#5C2518]">
                <div>
                    <h3 class="text-lg font-semibold leading-tight">{{ $portfolio->title }}</h3>
                    @if ($portfolio->description)
                        <p class="mt-2 text-sm text-[#874532] line-clamp-3">{{ $portfolio->description }}</p>
                    @endif
                    @if ($portfolio->event)
                        <p class="mt-2 text-xs text-[#A3563F]">{{ $portfolio->event->venue_name }} • {{ $portfolio->event->tutor_name }}</p>
                        <p class="text-[11px] text-[#A3563F]">{{ $portfolio->event->venue_address }}</p>
                    @endif
                </div>

                <div class="mt-auto flex items-center justify-between text-xs text-[#A3563F]">
                    <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF3EC] px-3 py-1 font-medium">
                        <span class="h-2 w-2 rounded-full bg-[#F17259]"></span>
                        Diperbarui {{ $portfolio->updated_at->translatedFormat('d M Y H:i') }}
                    </span>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="inline-flex items-center gap-2 rounded-full bg-[#FCE0D4] px-3 py-1 font-semibold text-[#A3563F] transition hover:bg-[#f9d4c4]">Edit</a>
                        <form method="POST" action="{{ route('admin.portfolios.destroy', $portfolio) }}" onsubmit="return confirm('Hapus portofolio ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="inline-flex items-center gap-2 rounded-full bg-[#FDE7DC] px-3 py-1 font-semibold text-[#D05240] transition hover:bg-[#fcd9cc]">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    @empty
        <div class="col-span-full rounded-[32px] border border-dashed border-[#FFBFA8] bg-[#FFF5EF] p-12 text-center text-[#A3563F]">
            Belum ada portofolio yang ditambahkan. Mulai unggah dokumentasi terbaik Anda!
        </div>
    @endforelse
</div>

<div class="mt-8 flex justify-center sm:hidden pagination-links">
    {!! $portfolios->links() !!}
</div>
