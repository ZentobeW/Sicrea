@props([
    'title' => null,
    'subtitle' => null,
    'backUrl' => null,
    'tabs' => [],
])

<x-layouts.app :title="$title">
    <section class="relative isolate overflow-hidden">
        <div class="absolute inset-0 -z-20 bg-slate-950"></div>
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-indigo-600 via-purple-600 to-sky-500 opacity-95"></div>
        <div class="absolute inset-y-0 right-0 -z-10 hidden lg:block">
            <div class="h-full w-96 bg-gradient-to-b from-white/20 via-white/5 to-transparent blur-3xl"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 text-white">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8">
                <div class="space-y-3">
                    <p class="inline-flex items-center rounded-full bg-white/15 px-4 py-1 text-xs uppercase tracking-[0.2em] text-white/80">Dashboard Admin</p>
                    <h1 class="text-3xl sm:text-4xl font-semibold leading-tight">{{ $title }}</h1>
                    @if ($subtitle)
                        <p class="max-w-2xl text-sm sm:text-base text-white/80 leading-relaxed">{{ $subtitle }}</p>
                    @endif
                </div>
                <div class="flex flex-wrap items-center justify-end gap-3">
                    @if ($backUrl)
                        <a href="{{ $backUrl }}" class="inline-flex items-center rounded-full border border-white/30 bg-white/10 px-4 py-2 text-sm font-medium text-white hover:bg-white/20 transition">Kembali</a>
                    @endif
                    @isset($actions)
                        {{ $actions }}
                    @endisset
                </div>
            </div>
        </div>
    </section>

    <div class="relative -mt-16 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-6">
                @if ($tabs)
                    <nav class="relative rounded-2xl border border-white/60 bg-white/80 backdrop-blur shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500/20 via-purple-500/10 to-sky-500/20 absolute inset-y-0 left-0 w-24 pointer-events-none"></div>
                        <ul class="relative flex flex-wrap gap-1 p-2 text-sm font-medium text-slate-600">
                            @foreach ($tabs as $tab)
                                <li>
                                    <a href="{{ $tab['route'] }}" @class([
                                        'inline-flex items-center gap-2 rounded-xl px-4 py-2 transition',
                                        'bg-white shadow-md text-indigo-600' => $tab['active'],
                                        'text-slate-600 hover:text-indigo-600 hover:bg-white/70' => ! $tab['active'],
                                    ])>
                                        @if (! empty($tab['icon']))
                                            <span class="text-lg">{!! $tab['icon'] !!}</span>
                                        @endif
                                        {{ $tab['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                @endif

                <div class="space-y-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
