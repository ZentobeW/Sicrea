@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="'Semua Event & Workshop'">
    {{-- SECTION HERO & SEARCH --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-[#FDE8D5] via-[#FFF4EC] to-white pb-16 pt-24">
        {{-- Dekorasi Background --}}
        <div class="absolute -top-16 -right-10 h-60 w-60 rounded-full bg-white/40 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-10 h-72 w-72 rounded-full bg-[#F7D6E0]/40 blur-3xl"></div>

        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold tracking-tight text-[#5A3D31] sm:text-4xl md:text-5xl">
                    Temukan Inspirasi
                </h1>
                <p class="mx-auto mt-3 max-w-2xl text-base text-slate-600 sm:text-lg">
                    Cari workshop kreatif, tutor favorit, atau lokasi terdekat secara langsung.
                </p>
            </div>

            {{-- FORM PENCARIAN (Floating Style ala Canva) --}}
            <form method="GET" action="{{ route('events.index') }}" class="mt-10">
                <div class="relative mx-auto max-w-2xl transition-transform duration-300 hover:-translate-y-1">
                    <div class="relative overflow-hidden rounded-full bg-white shadow-[0_8px_30px_rgb(0,0,0,0.08)] ring-1 ring-slate-900/5 transition focus-within:shadow-[0_8px_30px_rgb(176,90,98,0.2)] focus-within:ring-[#B05A62]/50">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-5">
                            {{-- Icon Search --}}
                            <svg class="h-6 w-6 text-[#B05A62]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        
                        {{-- INPUT PENCARIAN (LIVE SEARCH) --}}
                        {{-- Perhatikan atribut: data-auto-search --}}
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ request('q') }}"
                            data-auto-search 
                            class="block w-full border-0 bg-transparent py-4 pl-14 pr-14 text-slate-900 placeholder:text-slate-400 focus:ring-0 sm:text-lg"
                            placeholder="Ketik 'Melukis', 'Jakarta', atau nama tutor..."
                            autocomplete="off"
                        >

                        {{-- Tombol Reset (Muncul otomatis jika ada pencarian) --}}
                        @if(request('q'))
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <a href="{{ route('events.index') }}" class="rounded-full p-2 text-slate-400 hover:bg-slate-100 hover:text-[#B05A62]" title="Hapus Pencarian">
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
    <section class="min-h-[500px] bg-white">
        <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
            
            {{-- Header Hasil --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-xl font-semibold text-[#5A3D31]">
                    @if(request('q'))
                        Menampilkan hasil: "<span class="text-[#B05A62]">{{ request('q') }}</span>"
                    @else
                        Jadwal Terbaru
                    @endif
                </h2>
                <span class="inline-flex items-center rounded-full bg-[#FFF4EC] px-4 py-1.5 text-xs font-semibold text-[#B05A62]">
                    {{ $events->total() }} Event Ditemukan
                </span>
            </div>

            {{-- Grid Event --}}
            <div class="mt-8 grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($events as $event)
                    <article class="group relative flex h-full flex-col overflow-hidden rounded-[24px] border border-slate-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)]">
                        {{-- Gambar / Placeholder --}}
                        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-[#FCE3E5] to-[#FAD5B7]">
                            <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center">
                                <span class="text-xs font-bold uppercase tracking-widest text-[#B05A62]/60">{{ $event->venue_name }}</span>
                                <h3 class="mt-1 text-2xl font-bold text-[#5A3D31] line-clamp-2">{{ $event->title }}</h3>
                            </div>
                            {{-- Badge Tanggal --}}
                            <div class="absolute bottom-4 left-4 rounded-full bg-white/90 px-3 py-1 text-xs font-bold text-[#B05A62] backdrop-blur-sm shadow-sm">
                                {{ $event->start_at->translatedFormat('d M Y') }}
                            </div>
                        </div>

                        {{-- Konten Card --}}
                        <div class="flex flex-1 flex-col p-6">
                            <div class="mb-4 flex items-start gap-3">
                                <div class="flex h-10 w-10 flex-none items-center justify-center rounded-full bg-[#FFF4EC] text-[#B05A62] font-bold">
                                    {{ Str::substr($event->tutor_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">{{ $event->tutor_name }}</p>
                                    <p class="text-xs text-slate-500">Instruktur</p>
                                </div>
                            </div>

                            <p class="mb-6 flex-1 text-sm leading-relaxed text-slate-600">
                                {{ Str::limit(strip_tags($event->description), 100) }}
                            </p>

                            <div class="mt-auto flex items-center justify-between border-t border-slate-100 pt-4">
                                <div>
                                    <p class="text-xs text-slate-400">Harga Tiket</p>
                                    <p class="text-base font-bold text-[#5A3D31]">
                                        @if ($event->price > 0) Rp{{ number_format($event->price, 0, ',', '.') }} @else Gratis @endif
                                    </p>
                                </div>
                                <a href="{{ route('events.show', $event) }}" class="rounded-full bg-[#B05A62] px-5 py-2 text-sm font-medium text-white transition hover:bg-[#9A4750] shadow-md shadow-[#B05A62]/20">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center rounded-[32px] border border-dashed border-slate-200 bg-slate-50 py-20 text-center">
                        <div class="rounded-full bg-white p-4 shadow-sm">
                            <svg class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900">Tidak ada hasil ditemukan</h3>
                        <p class="mt-2 text-slate-500">Coba gunakan kata kunci lain seperti nama kota atau kategori.</p>
                        <a href="{{ route('events.index') }}" class="mt-6 rounded-full border border-slate-300 bg-white px-6 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                            Reset Pencarian
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $events->links() }}
            </div>
        </div>
    </section>
</x-layouts.app>