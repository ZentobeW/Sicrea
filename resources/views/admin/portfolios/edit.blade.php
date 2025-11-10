@php($tabs = [
    ['label' => 'Event', 'route' => route('admin.events.index'), 'active' => request()->routeIs('admin.events.*'), 'icon' => 'calendar'],
    ['label' => 'Pendaftaran', 'route' => route('admin.registrations.index'), 'active' => request()->routeIs('admin.registrations.*'), 'icon' => 'document-text'],
    ['label' => 'Portofolio', 'route' => route('admin.portfolios.index'), 'active' => request()->routeIs('admin.portfolios.*'), 'icon' => 'photo'],
])

@php($event = $portfolio->event)
@php($previewSlots = collect($portfolio->media_url ? [$portfolio->media_url] : [])->pad(3, null))

<x-layouts.admin :title="'Edit Portofolio: ' . $portfolio->title" subtitle="Sempurnakan cerita visual agar audiens merasakan pengalaman workshop secara utuh." :tabs="$tabs" :back-url="route('admin.portfolios.index')">
    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[32px] bg-gradient-to-br from-[#FFE8D6] via-[#FFF5EC] to-[#FDE5F7] p-6 sm:p-8 shadow-xl">
            <div class="absolute inset-y-0 right-0 hidden h-full w-1/2 translate-x-1/6 rounded-[40px] bg-white/30 blur-3xl lg:block"></div>
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-2xl space-y-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-orange-500">Ringkasan Dokumentasi</p>
                    <h2 class="text-2xl font-semibold text-slate-900 sm:text-3xl">{{ $portfolio->title }}</h2>
                    <p class="text-sm text-slate-600">Pastikan detail dokumentasi selaras dengan identitas event dan pilih foto terbaik yang mampu merepresentasikan cerita kegiatan.</p>
                </div>
                <div class="w-full max-w-xs rounded-3xl border border-orange-200/60 bg-white/80 p-4 shadow-lg backdrop-blur">
                    <p class="text-xs font-semibold uppercase tracking-widest text-orange-500">Event Terkait</p>
                    @if ($event)
                        <h3 class="mt-2 text-base font-semibold text-slate-900">{{ $event->title }}</h3>
                        <dl class="mt-4 space-y-2 text-sm text-slate-600">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-orange-100 text-orange-500">
                                    <x-heroicon-o-calendar class="h-5 w-5" />
                                </span>
                                <span>{{ optional($event->start_at)->translatedFormat('d M Y') }} • {{ optional($event->start_at)->translatedFormat('H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-orange-100 text-orange-500">
                                    <x-heroicon-o-map-pin class="h-5 w-5" />
                                </span>
                                <span class="line-clamp-2">{{ $event->venue_name }}</span>
                            </div>
                            <p class="pl-10 text-xs text-slate-500">{{ $event->venue_address }}</p>
                            <p class="pl-10 text-xs text-slate-500">Tutor: {{ $event->tutor_name }}</p>
                        </dl>
                    @else
                        <p class="mt-2 text-sm text-slate-600">Belum terhubung dengan event mana pun. Pilih event pada formulir di bawah agar portofolio tampil di halaman program terkait.</p>
                    @endif
                </div>
            </div>
        </section>

        <form method="POST" action="{{ route('admin.portfolios.update', $portfolio) }}" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="rounded-[32px] border border-slate-200/70 bg-white/95 p-6 sm:p-8 shadow-xl shadow-orange-100/50 space-y-6">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Informasi Dasar</h3>
                        <p class="text-sm text-slate-500">Perbarui judul, deskripsi, dan keterkaitan event sesuai kebutuhan kampanye.</p>
                    </div>
                    <span class="inline-flex items-center gap-2 rounded-full bg-orange-100 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-orange-600">
                        <x-heroicon-o-photo class="h-4 w-4" />
                        Dokumen Aktif
                    </span>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="flex items-center justify-between text-sm font-semibold text-slate-700">
                            Judul Dokumentasi
                            <span class="text-xs font-normal text-slate-400">Wajib diisi</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $portfolio->title) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-orange-400 focus:ring-orange-400" required>
                        @error('title')
                            <p class="mt-2 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Terkait Event</label>
                        <select name="event_id" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-orange-400 focus:ring-orange-400">
                            <option value="">-- Pilih Event --</option>
                            @foreach ($events as $item)
                                <option value="{{ $item->id }}" @selected(old('event_id', $portfolio->event_id) == $item->id)>{{ $item->title }}</option>
                            @endforeach
                        </select>
                        @error('event_id')
                            <p class="mt-2 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Tanggal Event</label>
                        <div class="mt-2 flex h-[52px] items-center gap-3 rounded-2xl border border-dashed border-orange-200 bg-orange-50/70 px-4 text-sm text-orange-600">
                            <x-heroicon-o-calendar class="h-5 w-5" />
                            <span>{{ $event?->start_at?->translatedFormat('d F Y') ?? 'Pilih event untuk menampilkan jadwal' }}</span>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700">Deskripsi Singkat</label>
                        <textarea name="description" rows="4" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-orange-400 focus:ring-orange-400" placeholder="Ceritakan highlight dokumentasi...">{{ old('description', $portfolio->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="rounded-[32px] border border-slate-200/70 bg-white/95 p-6 sm:p-8 shadow-xl shadow-orange-100/50 space-y-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Dokumentasi Foto</h3>
                        <p class="text-sm text-slate-500">Pilih foto terbaik dengan resolusi tinggi. Anda dapat menyimpan tautan dokumentasi utama di bawah.</p>
                    </div>
                    <button type="button" class="inline-flex items-center gap-2 rounded-full bg-orange-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-orange-300/60 transition hover:-translate-y-0.5 hover:bg-orange-600">
                        <x-heroicon-o-plus class="h-4 w-4" />
                        Tambah Foto
                    </button>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    @foreach ($previewSlots as $url)
                        @if ($url)
                            <a href="{{ $url }}" target="_blank" rel="noopener" class="group relative block overflow-hidden rounded-3xl border border-orange-200/70 bg-orange-50/60 shadow-inner">
                                <img src="{{ $url }}" alt="Dokumentasi portofolio" class="h-40 w-full object-cover transition duration-300 group-hover:scale-105">
                                <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-900/50 via-slate-900/10 to-transparent opacity-0 transition group-hover:opacity-100"></div>
                                <span class="pointer-events-none absolute bottom-3 right-3 inline-flex items-center gap-1 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-slate-600 shadow">
                                    <x-heroicon-o-arrow-up-right class="h-4 w-4" />
                                    Preview
                                </span>
                            </a>
                        @else
                            <div class="flex h-40 flex-col items-center justify-center gap-3 rounded-3xl border border-dashed border-orange-200 bg-orange-50/40 text-slate-400">
                                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/80 text-orange-400 shadow-inner">
                                    <x-heroicon-o-photo class="h-5 w-5" />
                                </span>
                                <p class="px-6 text-center text-xs font-medium text-slate-400">Siapkan dokumentasi tambahan untuk menambah daya tarik portofolio.</p>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700">Tautan Dokumentasi Utama</label>
                    <input type="url" name="media_url" value="{{ old('media_url', $portfolio->media_url) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-inner focus:border-orange-400 focus:ring-orange-400" placeholder="https://drive.google.com/...">
                    @error('media_url')
                        <p class="mt-2 text-xs font-medium text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('admin.portfolios.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:border-orange-300 hover:text-orange-600">Batal</a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold text-white shadow-xl shadow-orange-300/60 transition hover:-translate-y-0.5 hover:bg-orange-600">
                    <x-heroicon-o-arrow-up-right class="h-4 w-4" />
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
