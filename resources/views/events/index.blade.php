@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="'Event & Workshop'">
    {{-- Style Tambahan untuk Font Poppins --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        /* ... Style lama biarkan ... */

        /* --- Custom Event Card Style (Sesuai Request) --- */
        .event-card {
            box-sizing: border-box;
            /* Width & Height diatur oleh Grid Layout Tailwind, jadi property width/height dihapus agar responsif */
            background-color: #FCF5E6; /* Background FCF5E6 */
            border: 1px solid #822021; /* Border 822021 */
            box-shadow: 12px 17px 51px rgba(0, 0, 0, 0.22);
            border-radius: 17px;
            cursor: pointer;
            transition: all 0.5s;
            display: flex;
            flex-direction: column; /* Penting agar layout dalam card tetap rapi */
            overflow: hidden; /* Agar gambar tidak keluar dari border-radius */
        }

        .event-card:hover {
            border: 1px solid black;
            transform: scale(1.05);
            z-index: 10; /* Agar saat zoom posisinya di atas card lain */
        }

        .event-card:active {
            transform: scale(0.95) rotateZ(1.7deg);
        }

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

    {{-- SECTION HERO & SEARCH --}}
    <section class="relative overflow-hidden bg-[#FCF5E6] pb-10 pt-16">
        {{-- Dekorasi Background --}}
        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                {{-- Font diubah ke Poppins, Warna #822021 --}}
                <h1 class="text-3xl font-bold font-['Poppins'] tracking-tight text-[#822021] sm:text-4xl md:text-5xl">
                    Event & Workshop
                </h1>
                <p class="mx-auto mt-3 max-w-lg text-base sm:text-lg text-[#822021] font-['Poppins']">
                    Temukan workshop dan kelas kreatif yang sesuai dengan minat dan bakat Anda
                </p>
            </div>

            {{-- FORM PENCARIAN --}}
            <form method="GET" action="{{ route('events.index') }}" class="mt-10">
                <div class="relative mx-auto max-w-2xl">
                    <div class="relative overflow-hidden rounded-full bg-[#FAF8F1] border-2 border-[#FFB3E1] focus-within:border-[#822021] focus-within:ring-2 focus-within:ring-[#FFB3E1]/20">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            {{-- Icon Search --}}
                            <svg class="h-5 w-5 text-[#822021]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        
                        {{-- INPUT PENCARIAN (LIVE SEARCH) --}}
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ request('q') }}"
                            data-auto-search 
                            class="block w-full border-0 bg-transparent py-2 pl-12 pr-12 text-[#822021] placeholder:text-[#822021]/50 focus:ring-0 focus:outline-none text-base font-['Poppins']"
                            placeholder="Cari event atau workshop..."
                            autocomplete="off"
                        >

                        {{-- Tombol Reset --}}
                        @if(request('q'))
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <a href="{{ route('events.index') }}" class="rounded-full p-2 text-[#FFB3E1] hover:bg-[#822021] hover:text-[#FFB3E1]" title="Hapus Pencarian">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 6L6 18M6 6l12 12"></path>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </section>

    {{-- HASIL PENCARIAN --}}
    <section class="min-h-[500px] bg-[#FCF5E6]">
        <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">
            
            {{-- Header Hasil --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-xl font-semibold font-['Poppins'] text-[#822021]">
                    @if(request('q'))
                        Menampilkan hasil: "<span class="text-[#B05A62]">{{ request('q') }}</span>"
                    @else
                        Event Mendatang
                    @endif
                </h2>
                <span class="inline-flex items-center rounded-full bg-white border border-[#FFBE8E] px-4 py-1.5 text-xs font-['Poppins'] font-semibold text-[#822021]">
                    {{ $events->total() }} Event Ditemukan
                </span>
            </div>

            {{-- Grid Event --}}
            <div class="mt-8 grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($events as $event)
                    <article class="event-card h-full">
                        
                        <div class="aspect-[4/3] bg-gray-200 overflow-hidden shrink-0">
                            @if ($event->image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-[#FFD4B6] via-[#FFE9DC] to-white flex items-center justify-center">
                                    <span class="text-[#822021]/50 text-sm uppercase tracking-[0.35em] font-['Poppins']">Event Image</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-6 flex flex-col flex-grow text-left"> <div class="h-16 mb-4 flex items-center">
                                <h3 class="text-xl font-['Poppins'] font-bold text-[#822021] line-clamp-2 leading-tight">
                                    {{ $event->title }}
                                </h3>
                            </div>
                            
                            <div class="space-y-3 mb-6">
                                {{-- Tanggal (Icon color diubah jadi #822021) --}}
                                <div class="flex items-center gap-3 text-[#822021] font-['Poppins']">
                                    <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.33331 1.3335V4.00016" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.6667 1.3335V4.00016" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12.6667 2.6665H3.33333C2.59695 2.6665 2 3.26346 2 3.99984V13.3332C2 14.0696 2.59695 14.6665 3.33333 14.6665H12.6667C13.403 14.6665 14 14.0696 14 13.3332V3.99984C14 3.26346 13.403 2.6665 12.6667 2.6665Z" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M2 6.6665H14" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="text-sm font-semibold">{{ $event->start_at->translatedFormat('d M Y') }}</span>
                                </div>
                                
                                {{-- Venue (Icon color diubah jadi #822021) --}}
                                <div class="flex items-center gap-3 text-[#822021] font-['Poppins']">
                                    <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.3334 6.66683C13.3334 9.9955 9.64069 13.4622 8.40069 14.5328C8.28517 14.6197 8.14455 14.6667 8.00002 14.6667C7.85549 14.6667 7.71487 14.6197 7.59935 14.5328C6.35935 13.4622 2.66669 9.9955 2.66669 6.66683C2.66669 5.25234 3.22859 3.89579 4.22878 2.89559C5.22898 1.8954 6.58553 1.3335 8.00002 1.3335C9.41451 1.3335 10.7711 1.8954 11.7713 2.89559C12.7715 3.89579 13.3334 5.25234 13.3334 6.66683Z" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 8.6665C9.10457 8.6665 10 7.77107 10 6.6665C10 5.56193 9.10457 4.6665 8 4.6665C6.89543 4.6665 6 5.56193 6 6.6665C6 7.77107 6.89543 8.6665 8 8.6665Z" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="text-sm font-medium">{{ $event->venue_name }}</span>
                                </div>

                                {{-- Peserta (Icon color diubah jadi #822021) --}}
                                <div class="flex items-center gap-3 text-[#822021] font-['Poppins']">
                                    <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.6666 14V12.6667C10.6666 11.9594 10.3857 11.2811 9.8856 10.781C9.3855 10.281 8.70722 10 7.99998 10H3.99998C3.29274 10 2.61446 10.281 2.11436 10.781C1.61426 11.2811 1.33331 11.9594 1.33331 12.6667V14" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.6667 2.08545C11.2385 2.2337 11.7449 2.56763 12.1065 3.03482C12.468 3.50202 12.6642 4.07604 12.6642 4.66678C12.6642 5.25752 12.468 5.83154 12.1065 6.29874C11.7449 6.76594 11.2385 7.09987 10.6667 7.24812" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.6667 14.0002V12.6669C14.6662 12.0761 14.4696 11.5021 14.1076 11.0351C13.7456 10.5682 13.2388 10.2346 12.6667 10.0869" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.99998 7.33333C7.47274 7.33333 8.66665 6.13943 8.66665 4.66667C8.66665 3.19391 7.47274 2 5.99998 2C4.52722 2 3.33331 3.19391 3.33331 4.66667C3.33331 6.13943 4.52722 7.33333 5.99998 7.33333Z" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="text-sm font-medium">
                                        {{ $event->verified_registrations_count ?? 0 }}/{{ $event->capacity ?? 'Tidak terbatas' }} peserta
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mt-auto">
                                {{-- Harga (Icon color #822021) --}}
                                <div class="flex items-center gap-2">
                                    <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_2083_468)">
                                        <path d="M8.39071 1.72416C8.14072 1.4741 7.80163 1.33357 7.44804 1.3335H2.66671C2.31309 1.3335 1.97395 1.47397 1.7239 1.72402C1.47385 1.97407 1.33337 2.31321 1.33337 2.66683V7.44816C1.33345 7.80176 1.47397 8.14084 1.72404 8.39083L7.52671 14.1935C7.82972 14.4946 8.23954 14.6636 8.66671 14.6636C9.09388 14.6636 9.5037 14.4946 9.80671 14.1935L14.1934 9.80683C14.4945 9.50382 14.6635 9.094 14.6635 8.66683C14.6635 8.23966 14.4945 7.82984 14.1934 7.52683L8.39071 1.72416Z" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.99996 5.33317C5.18405 5.33317 5.33329 5.18393 5.33329 4.99984C5.33329 4.81574 5.18405 4.6665 4.99996 4.6665C4.81586 4.6665 4.66663 4.81574 4.66663 4.99984C4.66663 5.18393 4.81586 5.33317 4.99996 5.33317Z" fill="#822021" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_2083_468">
                                        <rect width="16" height="16" fill="white"/>
                                        </clipPath>
                                        </defs>
                                    </svg>

                                    <span class="text-lg font-['Poppins'] font-bold text-[#822021]">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                                </div>

                                {{-- Button Lihat Detail (BG #822021, Text #FCF5E6) --}}
                                <a href="{{ route('events.show', $event) }}" class="bg-[#822021] text-[#FCF5E6] font-['Poppins'] font-semibold py-2 px-6 rounded-full hover:bg-[#6a1a1b] transition shadow-md">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center rounded-[32px] border border-dashed border-[#822021]/30 bg-slate-50 py-20 text-center">
                        <div class="rounded-full bg-white p-4 shadow-sm border border-[#FFB3E1]">
                            <svg class="h-8 w-8 text-[#822021]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-[#822021] font-['Poppins']">Tidak ada hasil ditemukan</h3>
                        <p class="mt-2 text-[#822021]/70 font-['Poppins']">Coba gunakan kata kunci lain seperti nama kota atau kategori.</p>
                        <a href="{{ route('events.index') }}" class="mt-6 rounded-full border border-[#822021]/20 bg-white px-6 py-2 text-sm font-medium text-[#822021] hover:bg-[#822021]/5 transition font-['Poppins']">
                            Reset Pencarian
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12 font-['Poppins'] text-[#822021]">
                {{ $events->links() }}
            </div>
        </div>
    </section>
</x-layouts.app>
