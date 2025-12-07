@props([
    'title' => null,
    'subtitle' => null,
    'backUrl' => null,
])

@php
    $navigation = [
        [
            'label' => 'Dashboard',
            'route' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
            'icon_path' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25'
        ],
        [
            'label' => 'Kelola Event',
            'route' => route('admin.events.index'),
            'active' => request()->routeIs('admin.events.*'),
            'icon_path' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'
        ],
        [
            'label' => 'Kelola Portofolio',
            'route' => route('admin.portfolios.index'),
            'active' => request()->routeIs('admin.portfolios.*'),
            'icon_path' => 'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z'
        ],
        [
            'label' => 'Kelola Transaksi',
            'route' => route('admin.registrations.index'),
            'active' => request()->routeIs('admin.registrations.*'),
            'icon_path' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z'
        ],
    ];
@endphp

<x-layouts.app :title="$title ?? 'Dashboard Admin'" is-admin="true">
    
    {{-- 
        PERUBAHAN 1:
        Gunakan h-screen (tinggi fix 100% layar) dan overflow-hidden.
        Ini mencegah body/window scroll.
    --}}
    <div class="h-screen flex bg-[#FFDEF8] overflow-hidden">

        {{-- 1. OVERLAY GELAP (Mobile Only) --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden hidden transition-opacity duration-300"></div>

        {{-- 2. SIDEBAR NAVIGATION --}}
        {{-- 
             PERUBAHAN 2:
             - Tambahkan 'overflow-y-auto' agar sidebar bisa discroll sendiri (independent) jika menunya panjang.
             - Logic transisi tetap sama.
        --}}
        <aside id="admin-sidebar" 
               class="fixed inset-y-0 left-0 z-50 w-72 flex flex-col justify-between bg-[#FAF8F1] p-6 text-[#822021] transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 lg:static border-r border-[#822021]/10 shadow-2xl lg:shadow-none h-full overflow-y-auto">
            
            {{-- Wrapper Konten Sidebar (Agar footer tetap di bawah jika konten sedikit) --}}
            <div class="flex flex-col min-h-full justify-between">
                <div class="space-y-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-sm uppercase tracking-[0.4em] text-[#B49F9A]">Kreasi Hangat</span>
                            <h2 class="mt-4 text-2xl font-semibold text-[#822021]">Admin Panel</h2>
                        </div>
                        {{-- Tombol Close Sidebar (Mobile Only) --}}
                        <button id="close-sidebar-btn" class="lg:hidden text-[#822021] hover:text-[#B49F9A] focus:outline-none p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <nav class="space-y-2">
                        @foreach ($navigation as $item)
                            <a href="{{ $item['disabled'] ?? false ? '#' : $item['route'] }}" @class([
                                'group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition',
                                'pointer-events-none opacity-50' => $item['disabled'] ?? false,
                                'bg-[#822021] text-[#FAF8F1] shadow-md shadow-[#B49F9A]/30 hover:bg-[#822021]/70 hover:text-[#FAF8F1]' => $item['active'],
                                'text-[#822021] hover:bg-[#822021]/10 hover:text-[#822021]' => ! ($item['active'] ?? false),
                            ])>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon_path'] }}" />
                                </svg>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </nav>
                </div>

                <div class="space-y-4 text-sm mt-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-2xl bg-[#822021] px-4 py-3 font-semibold text-[#FAF8F1] transition hover:bg-[#822021]/70 hover:text-[#FAF8F1]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S12 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S12 3 12 3m0-6a9 9 0 01-1.172-1.88M12 3a9 9 0 00-1.172 1.88m0 0c.93 1.705 2.128 3.037 3.493 3.652M12 3c-1.365.615-2.563 1.947-3.493 3.652M12 3v18" />
                        </svg>
                        Lihat Website
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex w-full items-center justify-center gap-2 rounded-2xl border-2 border-[#822021] px-4 py-3 font-semibold text-[#822021] transition hover:bg-[#822021] hover:text-[#FAF8F1]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-9A2.25 2.25 0 002.25 5.25v13.5A2.25 2.25 0 004.5 21h9a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- 3. KONTEN UTAMA --}}
        {{-- 
            PERUBAHAN 3:
            Flex-1 dan overflow-hidden pada parent memastikan area ini mengisi sisa layar.
        --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            {{-- Mobile Header Bar --}}
            <div class="lg:hidden flex items-center justify-between bg-[#FAF8F1] px-4 py-3 border-b border-[#822021]/10 sticky top-0 z-30 shadow-sm h-16 shrink-0">
                <span class="font-semibold text-[#822021] uppercase tracking-widest text-xs">Admin Panel</span>
                <button id="open-sidebar-btn" class="p-2 rounded-md text-[#822021] hover:bg-[#822021]/10 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>

            {{-- 
                PERUBAHAN 4:
                Area Scrollable. 
                'flex-1' akan mengisi sisa tinggi dari h-screen.
                'overflow-y-auto' membuat hanya area ini yang scroll.
            --}}
            <main class="flex-1 overflow-y-auto">
                <div class="relative min-h-full pb-10">
                    {{-- Decorative Background --}}
                    <div class="absolute inset-0 -z-10 bg-[#FFDEF8] h-full w-full fixed"></div>
                    <div class="absolute right-12 top-6 -z-10 h-40 w-40 rounded-full bg-[#FFB3E1]/50 blur-2xl"></div>
                    
                    <div class="px-4 py-8 sm:px-10 lg:px-12">
                        
                        {{-- Page Header --}}
                        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between mb-10">
                            <div class="space-y-3 text-[#822021]">
                                <p class="inline-flex items-center rounded-full bg-[#FCF5E6]/70 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-[#822021]">
                                    Dashboard Admin
                                </p>
                                <div class="flex items-center gap-3">
                                    @if ($backUrl)
                                        <a href="{{ $backUrl }}" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-4 py-2 text-sm font-semibold text-[#FAF8F1] shadow-sm transition hover:bg-[#822021]/70 hover:text-[#FAF8F1]">
                                            ← Kembali
                                        </a>
                                    @endif
                                    <h1 class="text-3xl font-semibold tracking-tight text-[#822021]">{{ $title }}</h1>
                                </div>
                                @if ($subtitle)
                                    <p class="max-w-2xl text-sm text-[#822021] leading-relaxed">{{ $subtitle }}</p>
                                @endif
                            </div>
                            <div class="flex flex-wrap items-center gap-3">
                                @isset($actions)
                                    {{ $actions }}
                                @endisset
                            </div>
                        </div>

                        {{-- Main Slot --}}
                        <div class="relative bg-[#FFDEF8] rounded-3xl pt-2">
                            @if (session('status'))
                                <div class="mb-6 rounded-3xl bg-[#FFB3E1] border border-[#822021] shadow-[0_20px_45px_-20px_rgba(180,159,154,0.5)] px-6 py-4 text-sm font-medium text-[#822021]">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="mb-6 rounded-3xl bg-[#FFB3E1] border border-[#822021] shadow-[0_20px_45px_-20px_rgba(180,159,154,0.5)] px-6 py-4 text-sm text-[#822021]">
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
            </main>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT UNTUK SIDEBAR TOGGLE --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const openBtn = document.getElementById('open-sidebar-btn');
            const closeBtn = document.getElementById('close-sidebar-btn');

            function openSidebar() {
                if(sidebar) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                }
                if(overlay) {
                    overlay.classList.remove('hidden');
                }
            }

            function closeSidebar() {
                if(sidebar) {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                }
                if(overlay) {
                    overlay.classList.add('hidden');
                }
            }

            if(openBtn) openBtn.addEventListener('click', openSidebar);
            if(closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if(overlay) overlay.addEventListener('click', closeSidebar);
        });
    </script>
    @endpush

</x-layouts.app>