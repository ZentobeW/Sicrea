<x-layouts.admin title="Kelola Event" subtitle="Tambahkan, edit, atau hapus event dan workshop.">
    <x-slot name="actions">
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-5 py-3 text-sm font-semibold text-[#FAF8F1] shadow-lg shadow-[#822021]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70 hover:text-[#FAF8F1]">
            <x-heroicon-o-plus class="h-5 w-5" />
            Tambah Event Baru
        </a>
    </x-slot>

    {{-- OVERVIEW CARDS --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl bg-white p-5 shadow-[0_25px_60px_-30px_rgba(243,140,118,0.55)] transition hover:bg-[#822021] hover:shadow-lg cursor-pointer group">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#822021] group-hover:text-[#FCF5E6]">Total Event</p>
            <p class="mt-3 text-4xl font-semibold text-[#822021] group-hover:text-[#FCF5E6]">{{ $overview['total'] }}</p>
            <p class="mt-1 text-base text-[#822021] group-hover:text-[#FCF5E6]">Termasuk semua status.</p>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-[0_25px_60px_-30px_rgba(255,176,130,0.55)] transition hover:bg-[#822021] hover:shadow-lg cursor-pointer group">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#822021] group-hover:text-[#FCF5E6]">Published</p>
            <p class="mt-3 text-4xl font-semibold text-[#822021] group-hover:text-[#FCF5E6]">{{ $overview['published'] }}</p>
            <p class="mt-1 text-base text-[#822021] group-hover:text-[#FCF5E6]">Event yang tampil di katalog.</p>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-[0_25px_60px_-30px_rgba(241,128,128,0.4)] transition hover:bg-[#822021] hover:shadow-lg cursor-pointer group">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#822021] group-hover:text-[#FCF5E6]">Draft</p>
            <p class="mt-3 text-4xl font-semibold text-[#822021] group-hover:text-[#FCF5E6]">{{ $overview['drafts'] }}</p>
            <p class="mt-1 text-base text-[#822021] group-hover:text-[#FCF5E6]">Perlu dipublikasikan.</p>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-[0_25px_60px_-30px_rgba(210,110,86,0.4)] transition hover:bg-[#822021] hover:shadow-lg cursor-pointer group">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#822021] group-hover:text-[#FCF5E6]">Event Terdekat</p>
            @if ($nextEvent)
                <p class="mt-3 text-lg font-semibold text-[#822021] group-hover:text-[#FCF5E6]">{{ $nextEvent->title }}</p>
                <p class="mt-1 text-base text-[#822021] group-hover:text-[#FCF5E6]">{{ $nextEvent->start_at->translatedFormat('d M Y H:i') }}</p>
            @else
                <p class="mt-3 text-lg font-semibold text-[#822021] group-hover:text-[#FCF5E6]">Belum ada jadwal</p>
                <p class="mt-1 text-base text-[#822021] group-hover:text-[#FCF5E6]">Publikasikan event untuk menampilkannya.</p>
            @endif
        </div>
    </div>

    {{-- LIST & SEARCH --}}
    <div class="rounded-3xl bg-white p-6 shadow-[0_35px_90px_-45px_rgba(240,128,128,0.55)]">
        <div class="flex flex-col gap-4 border-b border-[#FFE0D6] pb-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-[#822021]">Daftar Event</h2>
                <p class="text-base text-[#822021]">Kelola event yang sedang berjalan maupun yang akan datang.</p>
            </div>
            
            {{-- FORM PENCARIAN (Perhatikan atribut data-auto-search) --}}
            <form 
                method="GET" 
                action="{{ route('admin.events.index') }}" 
                data-ajax-target="#event-list"
                class="flex w-full max-w-sm items-center rounded-full bg-[#FCF5E6] px-4 py-2 text-sm shadow-inner ring-1 ring-[#F7C8B8]/30 focus-within:ring-[#E77B5F]"
            >
                <x-heroicon-o-magnifying-glass class="h-5 w-5 text-[#FCF5E6]" />
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
                    <a href="{{ route('admin.events.index') }}" class="ml-2 rounded-full bg-[#FCF5E6] p-1 text-[#C16A55] hover:bg-[#822021] hover:text-[#822021]" title="Hapus Filter">
                        <x-heroicon-o-x-mark class="h-4 w-4" />
                    </a>
                @endif
            </form>
        </div>

        <div id="event-list" data-ajax-pagination="true">
            @include('admin.events.partials.table', ['events' => $events, 'filters' => $filters])
        </div>
    </div>
</x-layouts.admin>
