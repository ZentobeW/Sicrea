@php
    use Illuminate\Support\Str;
    $existingRegistration ??= null;
@endphp

<x-layouts.app :title="$event->title">
    
    {{-- Import Font Poppins --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        /* Set Default Font */
        body, h1, h2, h3, p, a, span, div {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Custom Button Hover Effect */
        .btn-register {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-register:hover {
            transform: scale(1.05); /* Zoom In effect */
            background-color: #822021;
            color: #FCF5E6;
            border-color: #822021;
        }
    </style>

    {{-- Main Background: FFDEF8 --}}
    <section class="relative overflow-hidden bg-[#FFDEF8] min-h-screen">
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
            
            {{-- Breadcrumb --}}
            <div class="flex items-center gap-3 text-sm">
                <svg class="h-4 w-4 text-[#822021]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                <a href="{{ route('events.index') }}" class="font-semibold text-[#822021] hover:underline">Kembali ke Events</a>
            </div>

            {{-- Carousel Image (Logic Tetap Sama) --}}
            @if ($event->portfolios?->count())
                <div class="relative mb-6 max-w-2xl mx-auto">
                    <div class="relative overflow-hidden rounded-2xl shadow-lg border-2 border-[#822021]" style="aspect-ratio: 16/9;">
                        <div id="carousel" class="flex transition-transform duration-300 ease-in-out h-full">
                            @foreach ($event->portfolios as $index => $portfolio)
                                <div class="w-full flex-shrink-0 h-full">
                                    @if ($portfolio->cover_image_url)
                                        <img src="{{ $portfolio->cover_image_url }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover" />
                                    @else
                                        <div class="w-full h-full bg-[#FAF8F1] flex items-center justify-center">
                                            <span class="text-[#822021]">{{ $portfolio->title }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <button id="prevBtn" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-[#822021]/80 hover:bg-[#822021] rounded-full p-2 shadow-lg transition">
                            <svg class="w-6 h-6 text-[#FCF5E6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button id="nextBtn" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-[#822021]/80 hover:bg-[#822021] rounded-full p-2 shadow-lg transition">
                            <svg class="w-6 h-6 text-[#FCF5E6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            {{-- Judul Event --}}
            <h1 class="text-3xl font-bold text-[#822021] mb-6">{{ $event->title }}</h1>
            
            {{-- BOX: Deskripsi --}}
            <div class="bg-[#FAF8F1] rounded-2xl p-6 border border-[#822021] mb-4 shadow-md">
                <h3 class="font-bold text-[#822021] text-lg mb-4">Deskripsi</h3>
                <p class="text-justify text-sm text-[#822021] leading-relaxed px-1">
                    {{ strip_tags($event->description) }}
                </p>
            </div>
            
            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 items-start">
                
                {{-- BOX: Detail Event (Kiri) --}}
                <div>
                    <div class="bg-[#FAF8F1] rounded-2xl p-4 md:p-5 border border-[#822021] shadow-md md:h-[392px] overflow-hidden">
                        <h3 class="font-bold text-[#822021] text-base md:text-lg mb-3 md:mb-4">Detail Event</h3>
                        <div class="space-y-3 md:space-y-4">
                            
                            {{-- Item: Tanggal --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-[#FFDEF8] border border-[#822021] rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-[#822021]" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-[#822021]/70 mb-1">Tanggal</p>
                                    <p class="text-xs font-semibold text-[#822021]">{{ $event->start_at->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>

                            {{-- Item: Waktu --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-[#FFDEF8] border border-[#822021] rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-[#822021]" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-[#822021]/70 mb-1">Waktu</p>
                                    <p class="text-xs font-semibold text-[#822021]">{{ $event->start_at->translatedFormat('H.i') }} - {{ $event->end_at->translatedFormat('H.i') }} WIB</p>
                                </div>
                            </div>

                            {{-- Item: Lokasi --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-[#FFDEF8] border border-[#822021] rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-[#822021]" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-[#822021]/70 mb-1">Lokasi</p>
                                    <p class="text-xs font-semibold text-[#822021]">{{ $event->venue_name }}, {{ $event->venue_address }}</p>
                                </div>
                            </div>

                            {{-- Item: Kuota --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-[#FFDEF8] border border-[#822021] rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-[#822021]" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-[#822021]/70 mb-1">Kuota Peserta</p>
                                    <p class="text-xs font-semibold text-[#822021]">{{ $event->registrations_count }}/{{ $event->remainingSlots() ?? '∞' }} peserta terdaftar</p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Dekorasi Bawah --}}
                        <div class="mt-4 md:mt-6 flex gap-2 md:gap-3 justify-center opacity-80">
                            <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="Design" class="w-10 h-10 object-contain" />
                            <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="Design" class="w-10 h-10 object-contain" />
                            <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="Design" class="w-10 h-10 object-contain" />
                        </div>
                    </div>
                </div>
                
                {{-- Right Column - Harga and Mentor --}}
                <div class="space-y-4">
                    
                    {{-- BOX: Harga --}}
                    <div class="bg-[#FAF8F1] rounded-2xl p-4 md:p-5 border border-[#822021] shadow-md">
                        <h3 class="font-bold text-[#822021] text-base md:text-lg mb-3">Harga</h3>
                        <p class="text-xl md:text-2xl font-bold text-[#822021] mb-3 md:mb-4">
                            @if ($event->price > 0)
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            @else
                                Gratis
                            @endif
                        </p>
                        
                        <div class="space-y-2 text-sm mb-6 border-b border-[#822021]/20 pb-4">
                            <div class="flex justify-between text-xs text-[#822021]">
                                <span>Total Pendaftar</span>
                                <span class="font-semibold">{{ $event->registrations_count }} peserta</span>
                            </div>
                            <div class="flex justify-between text-xs text-[#822021]">
                                <span>Kuota Tersisa</span>
                                <span class="font-semibold">{{ $event->remainingSlots() ?? '∞' }} kuota</span>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            @auth
                                @if ($existingRegistration)
                                    <a href="{{ route('registrations.show', $existingRegistration) }}#tiket" class="btn-register inline-flex w-full items-center justify-center rounded-full bg-[#822021] border border-[#822021] px-6 py-3 text-sm font-bold text-[#FCF5E6] shadow-md">
                                        Lihat Tiket Saya
                                    </a>
                                    <p class="text-center text-xs text-[#822021]/70">Anda sudah terdaftar</p>
                                @else
                                    {{-- BUTTON REGISTER --}}
                                    {{-- Default: BG FFDEF8, Text 822021 --}}
                                    {{-- Hover: Zoom, BG 822021, Text FCF5E6 --}}
                                    <a href="{{ route('events.register', $event) }}" class="btn-register inline-flex w-full items-center justify-center rounded-full bg-[#FFDEF8] border border-[#822021] px-6 py-3 font-bold text-sm text-[#822021] shadow-md">
                                        Daftar Sekarang
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-register inline-flex w-full items-center justify-center rounded-full bg-[#FFDEF8] border border-[#822021] px-6 py-3 font-bold text-sm text-[#822021] shadow-md">
                                    Login untuk Daftar
                                </a>
                                <p class="text-center text-xs text-[#822021]/70">Anda harus login terlebih dahulu</p>
                            @endauth
                        </div>
                    </div>
                    
                    {{-- BOX: Mentor --}}
                    <div class="bg-[#FAF8F1] rounded-2xl p-3 md:px-4 py-3 border border-[#822021] shadow-md">
                        <h3 class="font-bold text-[#822021] text-base md:text-lg mb-2 md:mb-3">Mentor</h3>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-[#FFDEF8] border border-[#822021] rounded-full flex items-center justify-center">
                                <span class="text-base md:text-lg font-bold text-[#822021]">{{ Str::substr($event->tutor_name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-bold text-[#822021]">{{ $event->tutor_name }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- BOX: Catatan --}}
                    <div class="bg-[#FAF8F1] rounded-2xl p-5 border border-[#822021] shadow-md">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-red-600 text-sm font-bold">!</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#822021] mb-2 text-sm">Catatan</h3>
                                <p class="text-justify text-xs text-[#822021] leading-relaxed">
                                    Pastikan hadir 15 menit sebelum sesi dimulai.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- Script Carousel (Tidak Berubah) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('carousel');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            
            if (carousel && prevBtn && nextBtn) {
                let currentIndex = 0;
                const totalSlides = carousel.children.length;
                
                function updateCarousel() {
                    const translateX = -currentIndex * 100;
                    carousel.style.transform = `translateX(${translateX}%)`;
                }
                
                prevBtn.addEventListener('click', function() {
                    currentIndex = currentIndex > 0 ? currentIndex - 1 : totalSlides - 1;
                    updateCarousel();
                });
                
                nextBtn.addEventListener('click', function() {
                    currentIndex = currentIndex < totalSlides - 1 ? currentIndex + 1 : 0;
                    updateCarousel();
                });
            }
        });
    </script>
</x-layouts.app>