@php($tabs = [
    ['label' => 'Event', 'route' => route('admin.events.index'), 'active' => request()->routeIs('admin.events.*'), 'icon' => 'calendar'],
    ['label' => 'Pendaftaran', 'route' => route('admin.registrations.index'), 'active' => request()->routeIs('admin.registrations.*'), 'icon' => 'document-text'],
    ['label' => 'Portofolio', 'route' => route('admin.portfolios.index'), 'active' => request()->routeIs('admin.portfolios.*'), 'icon' => 'photo'],
])

<x-layouts.admin title="Kelola Portofolio" subtitle="Upload dan kelola dokumentasi kegiatan agar publik dapat merasakan energi workshop secara visual." :tabs="$tabs">
    <x-slot name="actions">
        <a href="{{ route('admin.portfolios.create') }}" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-5 py-3 text-sm font-semibold text-[#FAF8F1] shadow-lg shadow-[#822021]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70 hover:text-[#FAF8F1]">
            <x-heroicon-o-plus class="h-5 w-5" />
            Tambah Portofolio
        </a>
    </x-slot>

    <section class="relative overflow-hidden rounded-[36px] bg-gradient-to-r from-[#FFBDAA] via-[#FFC9BB] to-[#FFE3D2] p-8 text-[#5C2518]">
        <div class="absolute inset-y-0 right-0 hidden w-1/2 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.45),transparent_65%)] lg:block"></div>
        <div class="relative z-10">
            <h2 class="text-xl font-semibold">Kurasi Dokumentasi Terbaik</h2>
            <p class="mt-2 max-w-2xl text-sm text-[#7A3D2A]">Gunakan pencarian untuk menemukan portofolio tertentu atau filter berdasarkan event agar mudah mengatur konten landing page.</p>

            {{-- SEARCH & FILTER FORM --}}
            <form method="GET" action="{{ route('admin.portfolios.index') }}" class="mt-6 grid gap-4 rounded-[28px] bg-white/80 p-6 shadow-lg shadow-[#FF9F80]/20 md:grid-cols-[minmax(0,1.2fr)_minmax(0,0.8fr)]">
                
                {{-- 1. SEARCH INPUT (Auto Search) --}}
                <div>
                    <label for="search" class="text-xs font-semibold uppercase tracking-wide text-[#A3563F]">Cari Portofolio</label>
                    <div class="mt-2 flex items-center gap-3 rounded-2xl border border-[#FFD1BE] bg-white px-4 py-2.5 shadow-inner ring-1 ring-transparent focus-within:ring-[#FF8A65]">
                        <x-heroicon-o-magnifying-glass class="h-5 w-5 text-[#FF8A65]" />
                        <input 
                            id="search" 
                            type="text" 
                            name="q" 
                            value="{{ $filters['q'] }}" 
                            data-auto-search 
                            placeholder="Cari judul atau nama event..." 
                            class="w-full border-0 bg-transparent text-sm text-[#5C2518] placeholder:text-[#C97A64] focus:ring-0" 
                            autocomplete="off"
                        />
                        @if ($filters['q'])
                            <a href="{{ route('admin.portfolios.index', ['event_id' => $filters['event_id']]) }}" class="ml-1 rounded-full p-1 text-[#C97A64] hover:bg-[#FFE3D2] hover:text-[#822021]" title="Hapus Pencarian">
                                <x-heroicon-o-x-mark class="h-4 w-4" />
                            </a>
                        @endif
                    </div>
                </div>

                {{-- 2. EVENT FILTER (Auto Submit on Change) --}}
                <div>
                    <label for="event" class="text-xs font-semibold uppercase tracking-wide text-[#A3563F]">Filter Event</label>
                    <div class="mt-2 rounded-2xl border border-[#FFD1BE] bg-white px-4 py-2.5 shadow-inner ring-1 ring-transparent focus-within:ring-[#FF8A65]">
                        <select 
                            id="event" 
                            name="event_id" 
                            data-auto-submit 
                            class="w-full border-0 bg-transparent text-sm text-[#5C2518] focus:ring-0 cursor-pointer"
                        >
                            <option value="">Semua Event</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}" @selected($filters['event_id'] == $event->id)>{{ $event->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Tombol "Terapkan" Dihapus karena sudah otomatis --}}
            </form>

            <dl class="mt-6 grid gap-4 text-sm text-[#6B3021] sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-3xl bg-white/70 p-5 shadow-sm shadow-[#FFBFA8]/30">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-[#C06245]">Total Portofolio</dt>
                    <dd class="mt-2 text-2xl font-semibold">{{ $insight['total'] }}</dd>
                </div>
                <div class="rounded-3xl bg-white/70 p-5 shadow-sm shadow-[#FFBFA8]/30">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-[#C06245]">Terhubung ke Event</dt>
                    <dd class="mt-2 text-2xl font-semibold">{{ $insight['linked'] }}</dd>
                    <p class="mt-1 text-xs text-[#A3563F]">Pastikan setiap dokumentasi memiliki konteks kegiatan.</p>
                </div>
                <div class="rounded-3xl bg-white/70 p-5 shadow-sm shadow-[#FFBFA8]/30">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-[#C06245]">Pembaruan Terakhir</dt>
                    <dd class="mt-2 text-base font-semibold">{{ optional($latestUpdate?->updated_at)->diffForHumans() ?? 'Belum ada' }}</dd>
                    <p class="mt-1 text-xs text-[#A3563F]">Jaga rutinitas update agar konten selalu relevan.</p>
                </div>
                <div class="rounded-3xl bg-white/70 p-5 shadow-sm shadow-[#FFBFA8]/30">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-[#C06245]">Tips Kurasi</dt>
                    <dd class="mt-2 text-sm leading-relaxed">Gunakan foto resolusi tinggi dan deskripsi singkat penuh emosi.</dd>
                </div>
            </dl>
        </div>
    </section>

    <section>
        <div class="mb-6 flex flex-col gap-3 text-sm text-[#874532] sm:flex-row sm:items-center sm:justify-between">
            <span>
                @if ($portfolios->total())
                    Menampilkan {{ $portfolios->firstItem() }}–{{ $portfolios->lastItem() }} dari {{ $portfolios->total() }} portofolio
                @else
                    Belum ada portofolio yang sesuai dengan filter saat ini.
                @endif
            </span>
            <div class="sm:ml-auto sm:block">{!! $portfolios->links() !!}</div>
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

        <div class="mt-8 flex justify-center sm:hidden">
            {!! $portfolios->links() !!}
        </div>
    </section>
</x-layouts.admin>