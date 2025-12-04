@php
    use Illuminate\Support\Str;

    $existingRegistration ??= null;
@endphp

<x-layouts.app :title="$event->title">
    <section class="relative overflow-hidden bg-gradient-to-b from-[#FCF5E6] to-[#FFBE8E] min-h-screen">
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
            <div class="flex items-center gap-3 text-sm">
                <svg class="h-4 w-4 text-[#822021]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                <a href="{{ route('events.index') }}" class="font-semibold text-[#822021]" style="font-family: 'Open Sans', sans-serif;">Kembali ke Events</a>
            </div>

            @if ($event->portfolios?->count())
                <div class="relative mb-6 max-w-2xl mx-auto">
                    <div class="relative overflow-hidden rounded-2xl shadow-lg" style="aspect-ratio: 16/9;">
                        <div id="carousel" class="flex transition-transform duration-300 ease-in-out h-full">
                            @foreach ($event->portfolios as $index => $portfolio)
                                <div class="w-full flex-shrink-0 h-full">
                                    @if ($portfolio->cover_image_url)
                                        <img src="{{ $portfolio->cover_image_url }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover" />
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500">{{ $portfolio->title }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <button id="prevBtn" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-[#822021] hover:bg-[#6a1a1b] rounded-full p-2 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button id="nextBtn" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-[#822021] hover:bg-[#6a1a1b] rounded-full p-2 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <h1 class="text-2xl font-bold text-[#822021] mb-6" style="font-family: 'Cousine', monospace;">{{ $event->title }}</h1>
            
            <!-- Deskripsi Full Width -->
            <div class="bg-white rounded-2xl p-6 border-2 border-[#FFB3E1] mb-4 shadow-md">
                <h3 class="font-bold text-[#822021] mb-4" style="font-family: 'Cousine', monospace;">Deskripsi</h3>
                <p class="font-['Open_Sans'] text-justify text-sm text-[#46000D] leading-relaxed px-1">
                    {{ strip_tags($event->description) }}
                </p>
            </div>
            
            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 items-start">
                <!-- Left Column - Detail Event -->
                <div>
                    <div class="bg-white rounded-2xl p-4 md:p-5 border-2 border-[#FFB3E1] shadow-md md:h-[392px] overflow-hidden">
                        <h3 class="font-bold text-[#822021] text-base md:text-lg mb-3 md:mb-4" style="font-family: 'Cousine', monospace;">Detail Event</h3>
                        <div class="space-y-3 md:space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-[#FAF8F1] border border-[#FFB3E1] rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-[#FFB3E1]" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-['Open_Sans'] text-xs text-[#B49F9A] mb-1">Tanggal</p>
                                    <p class="font-['Open_Sans'] text-xs font-semibold text-[#46000D]">{{ $event->start_at->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-[#FAF8F1] border border-[#FFB3E1] rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-[#FFB3E1]" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-['Open_Sans'] text-xs text-[#B49F9A] mb-1">Waktu</p>
                                    <p class="font-['Open_Sans'] text-xs font-semibold text-[#46000D]">{{ $event->start_at->translatedFormat('H.i') }} - {{ $event->end_at->translatedFormat('H.i') }} WIB</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-[#FAF8F1] border border-[#FFB3E1] rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-[#FFB3E1]" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-['Open_Sans'] text-xs text-[#B49F9A] mb-1">Lokasi</p>
                                    <p class="font-['Open_Sans'] text-xs font-semibold text-[#46000D]">{{ $event->venue_name }}, {{ $event->venue_address }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-[#FAF8F1] border border-[#FFB3E1] rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-[#FFB3E1]" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-['Open_Sans'] text-xs text-[#B49F9A] mb-1">Kuota Peserta</p>
                                    <p class="font-['Open_Sans'] text-xs font-semibold text-[#46000D]">{{ $event->registrations_count }}/{{ $event->remainingSlots() ?? '∞' }} peserta terdaftar</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 md:mt-6 flex gap-2 md:gap-3 justify-center">
                            <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="Design" class="w-12 h-12 md:w-16 md:h-16 object-contain" />
                            <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="Design" class="w-12 h-12 md:w-16 md:h-16 object-contain" />
                            <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="Design" class="w-12 h-12 md:w-16 md:h-16 object-contain" />
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Harga and Mentor -->
                <div class="space-y-4">
                    <div class="bg-white rounded-2xl p-4 md:p-5 border-2 border-[#FFB3E1] shadow-md">
                        <h3 class="font-bold text-[#822021] text-base md:text-lg mb-3" style="font-family: 'Cousine', monospace;">Harga</h3>
                        <p class="text-xl md:text-2xl font-semibold text-[#822021] mb-3 md:mb-4">
                            @if ($event->price > 0)
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            @else
                                Gratis
                            @endif
                        </p>
                        <div class="space-y-2 text-sm mb-6">
                            <div class="flex justify-between font-['Open_Sans'] text-xs text-[#46000D]">
                                <span>Total Pendaftar</span>
                                <span>{{ $event->registrations_count }} peserta</span>
                            </div>
                            <div class="flex justify-between font-['Open_Sans'] text-xs text-[#46000D]">
                                <span>Kuota Tersisa</span>
                                <span>{{ $event->remainingSlots() ?? '∞' }} kuota</span>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            @auth
                                @if ($existingRegistration)
                                    <a href="{{ route('registrations.show', $existingRegistration) }}#tiket" class="inline-flex w-full items-center justify-center rounded-full bg-[#0F766E] px-6 py-2 font-['Open_Sans'] text-sm font-semibold text-white transition hover:bg-[#0B5F59]">
                                        Lihat Tiket Saya
                                    </a>
                                    <p class="font-['Open_Sans'] text-center text-xs text-[#B49F9A]">Anda sudah terdaftar untuk event ini</p>
                                @else
                                    <a href="{{ route('events.register', $event) }}" class="inline-flex w-full items-center justify-center rounded-full bg-[#FFB3E1] px-6 py-2 font-semibold text-sm text-[#822021] transition hover:bg-[#FF9FD8]" style="font-family: 'Open Sans', sans-serif;">
                                        Daftar Sekarang
                                    </a>
                                    <p class="font-['Open_Sans'] text-center text-xs text-[#B49F9A]">Anda harus login terlebih dahulu untuk mendaftar</p>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="inline-flex w-full items-center justify-center rounded-full bg-[#FFB3E1] px-6 py-2 font-semibold text-sm text-[#822021] transition hover:bg-[#FF9FD8]" style="font-family: 'Open Sans', sans-serif;">
                                    Login untuk Daftar
                                </a>
                                <p class="font-['Open_Sans'] text-center text-xs text-[#B49F9A]">Anda harus login terlebih dahulu untuk mendaftar</p>
                            @endauth
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-3 md:px-4 py-3 border-2 border-[#FFB3E1] shadow-md">
                        <h3 class="font-bold text-[#822021] text-base md:text-lg mb-2 md:mb-3" style="font-family: 'Cousine', monospace;">Mentor</h3>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                <span class="text-base md:text-lg font-semibold">{{ Str::substr($event->tutor_name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-semibold font-['Open_Sans'] text-[#46000D]">{{ $event->tutor_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-5 border-2 border-[#FFB3E1] mt-4 shadow-md">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-red-600 text-sm font-bold">!</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#822021] mb-2" style="font-family: 'Cousine', monospace;">Catatan</h3>
                        <p class="font-['Open_Sans'] text-justify text-sm text-[#46000D] leading-relaxed">
                            Pastikan hadir 15 menit sebelum sesi dimulai. Perlengkapan yang diperlukan akan diinformasikan melalui email setelah pembayaran terkonfirmasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

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