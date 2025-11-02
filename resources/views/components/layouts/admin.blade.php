@props([
    'title' => null,
    'subtitle' => null,
    'backUrl' => null,
])

@php
    $navigation = [
        [
            'label' => 'Dashboard',
            'icon' => '🏠',
            'route' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
        ],
        [
            'label' => 'Kelola Event',
            'icon' => '📅',
            'route' => route('admin.events.index'),
            'active' => request()->routeIs('admin.events.*'),
        ],
        [
            'label' => 'Kelola Portofolio',
            'icon' => '🖼️',
            'route' => route('admin.portfolios.index'),
            'active' => request()->routeIs('admin.portfolios.*'),
        ],
        [
            'label' => 'Laporan & Analitik',
            'icon' => '📊',
            'route' => '#',
            'active' => false,
            'disabled' => true,
        ],
        [
            'label' => 'Kelola Transaksi',
            'icon' => '💳',
            'route' => route('admin.registrations.index'),
            'active' => request()->routeIs('admin.registrations.*'),
        ],
    ];
@endphp

<x-layouts.app :title="$title ?? 'Dashboard Admin'" is-admin="true">
    <div class="min-h-screen flex">
        <aside class="hidden lg:flex w-72 flex-col justify-between bg-gradient-to-b from-[#FFBDAA] via-[#FFCBB6] to-[#FFE3D2] p-6 text-[#6B3021]">
            <div class="space-y-8">
                <div>
                    <span class="text-sm uppercase tracking-[0.4em] text-[#A3563F]">Kreasi Hangat</span>
                    <h2 class="mt-4 text-2xl font-semibold text-[#5C2518]">Admin Panel</h2>
                </div>
                <nav class="space-y-2">
                    @foreach ($navigation as $item)
                        <a href="{{ $item['disabled'] ?? false ? '#' : $item['route'] }}" @class([
                            'group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition',
                            'pointer-events-none opacity-50' => $item['disabled'] ?? false,
                            'bg-white/70 text-[#5C2518] shadow-md shadow-[#FF9F80]/20' => $item['active'],
                            'text-[#874532] hover:bg-white/40 hover:text-[#5C2518]' => ! ($item['active'] ?? false),
                        ])>
                            <span class="text-lg">{{ $item['icon'] }}</span>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="space-y-4 text-sm">
                <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-2xl bg-white/40 px-4 py-3 font-semibold text-[#6B3021] transition hover:bg-white/60">
                    <span>🌐</span>
                    Lihat Website
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex w-full items-center justify-center gap-2 rounded-2xl bg-[#F68C7B] px-4 py-3 font-semibold text-white shadow-md shadow-[#E86A54]/30 transition hover:bg-[#e37b69]">
                        <span>↩</span>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1">
            <div class="relative isolate overflow-hidden">
                <div class="absolute inset-0 -z-10 bg-gradient-to-r from-[#FFE4D7] via-[#FFD1BE] to-[#FFC3B0]"></div>
                <div class="absolute right-12 top-6 -z-10 h-40 w-40 rounded-full bg-[#FF9D7A]/30 blur-2xl"></div>
                <div class="px-6 py-10 sm:px-10 lg:px-12">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div class="space-y-3 text-[#6B3021]">
                            <p class="inline-flex items-center rounded-full bg-white/60 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-[#AD5D41]">Dashboard Admin</p>
                            <div class="flex items-center gap-3">
                                @if ($backUrl)
                                    <a href="{{ $backUrl }}" class="inline-flex items-center gap-2 rounded-full bg-white/80 px-4 py-2 text-sm font-semibold text-[#874532] shadow-sm transition hover:bg-white">
                                        ← Kembali
                                    </a>
                                @endif
                                <h1 class="text-3xl font-semibold tracking-tight text-[#4B2A22]">{{ $title }}</h1>
                            </div>
                            @if ($subtitle)
                                <p class="max-w-2xl text-sm text-[#874532] leading-relaxed">{{ $subtitle }}</p>
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
                        <div class="mb-6 rounded-3xl bg-white shadow-[0_20px_45px_-20px_rgba(255,138,101,0.55)] px-6 py-4 text-sm font-medium text-[#874532]">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 rounded-3xl bg-[#FFE6E2] border border-[#FFB9AA] px-6 py-4 text-sm text-[#B94A3F]">
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
