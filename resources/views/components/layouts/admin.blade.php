@props([
    'title' => null,
    'subtitle' => null,
    'backUrl' => null,
])

@php
    $navigation = [
        [
            'label' => 'Dashboard',
            'icon' => 'home',
            'route' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
        ],
        [
            'label' => 'Kelola Event',
            'icon' => 'calendar',
            'route' => route('admin.events.index'),
            'active' => request()->routeIs('admin.events.*'),
        ],
        [
            'label' => 'Kelola Portofolio',
            'icon' => 'photo',
            'route' => route('admin.portfolios.index'),
            'active' => request()->routeIs('admin.portfolios.*'),
        ],
        [
            'label' => 'Laporan & Analitik',
            'icon' => 'chart-bar-square',
            'route' => route('admin.reports.index'),
            'active' => request()->routeIs('admin.reports.*'),
        ],
        [
            'label' => 'Kelola Transaksi',
            'icon' => 'credit-card',
            'route' => route('admin.registrations.index'),
            'active' => request()->routeIs('admin.registrations.*'),
        ],
    ];
@endphp

<x-layouts.app :title="$title ?? 'Dashboard Admin'" is-admin="true">
    <div class="min-h-screen flex">
        <aside class="hidden lg:flex w-72 flex-col justify-between bg-[#FAF8F1] p-6 text-[#822021]">
            <div class="space-y-8">
                <div>
                    <span class="text-sm uppercase tracking-[0.4em] text-[#B49F9A]">Kreasi Hangat</span>
                    <h2 class="mt-4 text-2xl font-semibold text-[#822021]">Admin Panel</h2>
                </div>
                <nav class="space-y-2">
                    @foreach ($navigation as $item)
                        <a href="{{ $item['disabled'] ?? false ? '#' : $item['route'] }}" @class([
                            'group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition',
                            'pointer-events-none opacity-50' => $item['disabled'] ?? false,
                            // Active: dark background + cream text
                            'bg-[#822021] text-[#FAF8F1] shadow-md shadow-[#B49F9A]/30 hover:bg-[#822021]/70 hover:text-[#FAF8F1]' => $item['active'],
                            // Inactive: same hover but default dark text
                            'text-[#822021] hover:bg-[#822021]/70 hover:text-[#FAF8F1]' => ! ($item['active'] ?? false),
                        ])>
                            <x-dynamic-component :component="'heroicon-o-' . $item['icon']" class="h-5 w-5" />
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="space-y-4 text-sm">
                <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-2xl bg-[#822021] px-4 py-3 font-semibold text-[#FAF8F1] transition hover:bg-[#822021]/70 hover:text-[#FAF8F1]">
                    <x-heroicon-o-globe-alt class="h-5 w-5" />
                    Lihat Website
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex w-full items-center justify-center gap-2 rounded-2xl bg-[#822021] px-4 py-3 font-semibold text-[#FAF8F1] shadow-md shadow-[#822021]/30 transition hover:bg-[#822021]/70 hover:text-[#FAF8F1]">
                        <x-heroicon-o-arrow-left-on-rectangle class="h-5 w-5" />
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1">
            <div class="relative isolate overflow-hidden">
                <div class="absolute inset-0 -z-10 bg-[#FFDEF8]"></div>
                <div class="absolute right-12 top-6 -z-10 h-40 w-40 rounded-full bg-[#FFDEF8]/30 blur-2xl"></div>
                <div class="px-6 py-10 sm:px-10 lg:px-12">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div class="space-y-3 text-[#822021]">
                            <p class="inline-flex items-center rounded-full bg-[#FCF5E6]/70 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-[#822021]">Dashboard Admin</p>
                            <div class="flex items-center gap-3">
                                @if ($backUrl)
                                    <a href="{{ $backUrl }}" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-4 py-2 text-sm font-semibold text-[#FAF8F1] shadow-sm transition hover:bg-[#822021]/70 hover:text-[#FAF8F1]">
                                        ← Kembali
                                    </a>
                                @endif
                                <h1 class="text-3xl font-semibold tracking-tight text-[#822021]">{{ $title }}</h1>
                            </div>
                            @if ($subtitle)
                                <p class="max-w-2xl text-sm text-[#B49F9A] leading-relaxed">{{ $subtitle }}</p>
                            @endif
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            @isset($actions)
                                {{ $actions }}
                            @endisset
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative -mt-10 pb-16">
                <div class="px-4 sm:px-6 lg:px-12">
                    @if (session('status'))
                        <div class="mb-6 rounded-3xl bg-[#FCF5E6] border border-[#822021] shadow-[0_20px_45px_-20px_rgba(180,159,154,0.5)] px-6 py-4 text-sm font-medium text-[#822021]">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 rounded-3xl bg-[#FFDEF8] border border-[#822021] shadow-[0_20px_45px_-20px_rgba(180,159,154,0.5)] px-6 py-4 text-sm text-[#822021]">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
