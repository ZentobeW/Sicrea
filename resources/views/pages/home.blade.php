@php
    use Illuminate\Support\Str;

    $formatStat = static function (int $value): string {
        if ($value >= 1000) {
            return rtrim(number_format($value / 1000, 1), '.0') . 'K+';
        }

        return $value . ($value > 0 ? '+' : '');
    };
@endphp

<x-layouts.app :title="'Kreasi Hangat'">
    <!--Section Hero-->
    <section class="relative overflow-hidden bg-gradient-to-br from-[#FFBE8E] to-[#FCF5E6]">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20">
            <div class="grid gap-10 lg:grid-cols-2 items-center">
                <div class="space-y-8">
                    <div class="space-y-6">
                        <h1 class="text-4xl md:text-6xl font-bold font-['Cousine'] leading-tight text-[#822021]">
                            <br> Wujudkan </br> 
                            Kreativitas Anda Bersama Kami
                        </h1>
                        <p class="text-justify text-base md:text-lg leading-relaxed text-[#46000D] max-w-2xl">
                            Kreasi Hangat hadir sebagai komunitas yang bergerak di bidang creative class dan workshop, dengan fokus pada kegiatan yang mengembangkan kreativitas serta memberikan pengalaman seni yang menyenangkan
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-full bg-[#822021] px-6 py-2 text-sm font-['Open_Sans'] font-semibold text-[#FAF8F1] shadow-sm shadow-[#822021]/40 transition hover:bg-[#5c261d]">
                            Lihat Event
                        </a>
                        <a href="{{ route('portfolio.index') }}" class="inline-flex items-center rounded-full bg-[#FAF8F1] border border-[#FFBE8E] px-6 py-2 text-sm font-['Open_Sans'] font-semibold text-[#822021] shadow-sm shadow-[#FFBE8E]/40 transition hover:bg-white transition">
                            Tentang Kami
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/3] overflow-hidden rounded-2xl shadow-lg">
                        <img src="https://images.unsplash.com/photo-1757085242669-076c35ff9397?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjcmVhdGl2ZSUyMHdvcmtzaG9wJTIwcGVvcGxlfGVufDF8fHx8MTc1OTI5MTUxOXww&ixlib=rb-4.1.0&q=80&w=1080" alt="Workshop Kreativitas" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div class="w-full h-full bg-[#FCD9CA] flex items-center justify-center text-sm uppercase tracking-[0.35em] text-[#C65B74]/70" style="display: none;">
                            Foto Workshop
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carousel Section -->
    <section class="bg-[#FCF5E6] py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative">
                <!-- Carousel Container -->
                <div class="flex items-center justify-center h-96 relative overflow-hidden" id="carousel-container">
                    <!-- Left images -->
                    <div class="w-20 h-64 opacity-20 z-10 transition-all duration-500 ease-out" id="img-left-2" style="display: none;">
                        <img src="" alt="Workshop" class="w-full h-full object-cover rounded-lg shadow-lg">
                    </div>
                    <div class="w-30 h-80 opacity-40 z-20 transition-all duration-500 ease-out" id="img-left-1" style="display: none;">
                        <img src="" alt="Workshop" class="w-full h-full object-cover rounded-lg shadow-lg">
                    </div>
                    
                    <!-- Center image -->
                    <div class="w-[40rem] h-96 z-30 transition-all duration-300 ease-out" id="img-center">
                        <img src="" alt="Workshop" class="w-full h-full object-cover rounded-lg shadow-xl" id="center-img">
                    </div>
                    
                    <!-- Right images -->
                    <div class="w-30 h-80 opacity-40 z-20 transition-all duration-500 ease-out" id="img-right-1" style="display: none;">
                        <img src="" alt="Workshop" class="w-full h-full object-cover rounded-lg shadow-lg">
                    </div>
                    <div class="w-20 h-64 opacity-20 z-10 transition-all duration-500 ease-out" id="img-right-2" style="display: none;">
                        <img src="" alt="Workshop" class="w-full h-full object-cover rounded-lg shadow-lg">
                    </div>
                </div>
                
                <!-- Navigation Buttons -->
                <button class="absolute left-4 top-1/2 -translate-y-1/2 bg-[#822021] text-white p-3 rounded-full hover:bg-[#5c261d] transition z-40" onclick="prevSlide()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="absolute right-4 top-1/2 -translate-y-1/2 bg-[#822021] text-white p-3 rounded-full hover:bg-[#5c261d] transition z-40" onclick="nextSlide()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <!-- Dots Indicator -->
                <div class="flex justify-center mt-8 space-x-2">
                    <button class="w-2 h-2 rounded-full bg-[#822021] transition" onclick="goToSlide(0)" id="dot-0"></button>
                    <button class="w-2 h-2 rounded-full bg-[#822021] opacity-50 transition" onclick="goToSlide(1)" id="dot-1"></button>
                    <button class="w-2 h-2 rounded-full bg-[#822021] opacity-50 transition" onclick="goToSlide(2)" id="dot-2"></button>
                    <button class="w-2 h-2 rounded-full bg-[#822021] opacity-50 transition" onclick="goToSlide(3)" id="dot-3"></button>
                    <button class="w-2 h-2 rounded-full bg-[#822021] opacity-50 transition" onclick="goToSlide(4)" id="dot-4"></button>
                    <button class="w-2 h-2 rounded-full bg-[#822021] opacity-50 transition" onclick="goToSlide(5)" id="dot-5"></button>
                    <button class="w-2 h-2 rounded-full bg-[#822021] opacity-50 transition" onclick="goToSlide(6)" id="dot-6"></button>
                    <button class="w-2 h-2 rounded-full bg-[#822021] opacity-50 transition" onclick="goToSlide(7)" id="dot-7"></button>
                    <button class="w-2 h-2 rounded-full bg-[#822021] opacity-50 transition" onclick="goToSlide(8)" id="dot-8"></button>
                    <button class="w-2 h-2 rounded-full bg-[#822021] opacity-50 transition" onclick="goToSlide(9)" id="dot-9"></button>
                </div>
            </div>
        </div>
    </section>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cousine:wght@400;700&family=Open+Sans:wght@400;600&display=swap');
        .font-cousine { font-family: 'Cousine', monospace; }
        .font-open-sans { font-family: 'Open Sans', sans-serif; }
        .portfolio-card:hover .portfolio-image {
            transform: scale(1.1);
        }
        .portfolio-overlay {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .portfolio-card:hover .portfolio-overlay {
            opacity: 1;
        }
        .portfolio-card.mobile-active .portfolio-image {
            transform: scale(1.1);
        }
        .portfolio-card.mobile-active .portfolio-overlay {
            opacity: 1;
        }
        
        @media (max-width: 768px) {
            #carousel-container {
                height: auto !important;
            }
            #img-center {
                width: 100% !important;
                height: auto !important;
                aspect-ratio: 4/3;
            }
            #center-img {
                aspect-ratio: 4/3;
            }
            #img-left-1, #img-left-2, #img-right-1, #img-right-2 {
                height: auto !important;
                aspect-ratio: 9/16;
            }
            #img-left-1 img, #img-left-2 img, #img-right-1 img, #img-right-2 img {
                aspect-ratio: 9/16;
            }
            .portfolio-image-container {
                cursor: pointer;
            }
        }
    </style>

    <script>
        let currentSlide = 0;
        const totalSlides = 10;
        const images = [
            'https://images.unsplash.com/photo-1758522274463-67ef9e5e88b1?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxhcnQlMjBjbGFzcyUyMGNvbW11bml0eXxlbnwxfHx8fDE3NTkyOTE1MTl8MA&ixlib=rb-4.1.0&q=80&?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1556761175-b413da4baf72?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1758522276630-8ebdf55d7619?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxwYWludGluZyUyMGNsYXNzJTIwc3R1ZGlvfGVufDF8fHx8MTc1OTI5MTUyMHww&ixlib=rb-4.1.0&q=80&?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1757085242669-076c35ff9397?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjcmVhdGl2ZSUyMHdvcmtzaG9wJTIwcGVvcGxlfGVufDF8fHx8MTc1OTI5MTUxOXww&ixlib=rb-4.1.0&q=80&?w=800&h=600&fit=crop'
        ];
        
        function updateCarousel() {
            // Pop-up effect for center image
            const centerImg = document.getElementById('img-center');
            centerImg.style.transform = 'scale(0.9)';
            
            setTimeout(() => {
                // Update center image
                document.querySelector('#img-center img').src = images[currentSlide];
                centerImg.style.transform = 'scale(1)';
            }, 150);
            
            // Show/hide and update left images based on availability
            const imgLeft2 = document.getElementById('img-left-2');
            const imgLeft1 = document.getElementById('img-left-1');
            const imgRight1 = document.getElementById('img-right-1');
            const imgRight2 = document.getElementById('img-right-2');
            
            // Left side images with slide effect
            if (currentSlide >= 2) {
                imgLeft2.style.display = 'block';
                imgLeft2.querySelector('img').src = images[currentSlide - 2];
                imgLeft2.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    imgLeft2.style.transform = 'translateX(0)';
                }, 100);
            } else {
                imgLeft2.style.display = 'none';
            }
            
            if (currentSlide >= 1) {
                imgLeft1.style.display = 'block';
                imgLeft1.querySelector('img').src = images[currentSlide - 1];
                imgLeft1.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    imgLeft1.style.transform = 'translateX(0)';
                }, 100);
            } else {
                imgLeft1.style.display = 'none';
            }
            
            // Right side images with slide effect
            if (currentSlide < totalSlides - 1) {
                imgRight1.style.display = 'block';
                imgRight1.querySelector('img').src = images[currentSlide + 1];
                imgRight1.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    imgRight1.style.transform = 'translateX(0)';
                }, 100);
            } else {
                imgRight1.style.display = 'none';
            }
            
            if (currentSlide < totalSlides - 2) {
                imgRight2.style.display = 'block';
                imgRight2.querySelector('img').src = images[currentSlide + 2];
                imgRight2.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    imgRight2.style.transform = 'translateX(0)';
                }, 100);
            } else {
                imgRight2.style.display = 'none';
            }
            
            // Update dots
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.getElementById(`dot-${i}`);
                if (i === currentSlide) {
                    dot.classList.remove('opacity-50');
                } else {
                    dot.classList.add('opacity-50');
                }
            }
        }
        
        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateCarousel();
        }
        
        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateCarousel();
        }
        
        function goToSlide(index) {
            currentSlide = index;
            updateCarousel();
        }
        
        // Initialize carousel
        updateCarousel();
        
        // Auto-play carousel
        setInterval(nextSlide, 2500);
        
        // Mobile portfolio overlay toggle
        function toggleMobileOverlay(element) {
            if (window.innerWidth <= 768) {
                const portfolioCard = element.closest('.portfolio-card');
                portfolioCard.classList.toggle('mobile-active');
                
                // Remove active class from other cards
                document.querySelectorAll('.portfolio-card').forEach(card => {
                    if (card !== portfolioCard) {
                        card.classList.remove('mobile-active');
                    }
                });
            }
        }
    </script>

    <section class="bg-[#FAF8F1]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-10">
            <div class="text-center space-y-3">
                <h2 class="text-3xl font-['Cousine'] font-bold text-[#822021]">Event Mendatang</h2>
                <p class="text-base font-['Open_Sans'] text-[#46000D] max-w-xl mx-auto">Jangan lewatkan kesempatan untuk mengikuti workshop dan event kreatif sesuai minat dan bakat Anda</p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($upcomingEvents as $event)
                    <article class="bg-white border-2 border-[#FFB3E1] rounded-[24px] overflow-hidden flex flex-col h-full shadow-lg shadow-[#FFB3E1]/40 transition hover:-translate-y-1 hover:shadow-xl flex flex-col">
                        <div class="aspect-[4/3] bg-gray-200 overflow-hidden">
                            @if ($event->cover_image_url)
                                <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-[#FFD4B6] via-[#FFE9DC] to-white flex items-center justify-center">
                                    <span class="text-[#C65B74]/70 text-sm uppercase tracking-[0.35em]">Event Image</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="h-16 mb-4 flex items-center">
                                <h3 class="text-xl font-['Cousine'] font-bold text-[#822021] line-clamp-2">{{ $event->title }}</h3>
                            </div>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center gap-3 text-[#46000D] font-['Open_Sans']">
                                    <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.33331 1.3335V4.00016" stroke="#FFB3E1" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.6667 1.3335V4.00016" stroke="#FFB3E1" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12.6667 2.6665H3.33333C2.59695 2.6665 2 3.26346 2 3.99984V13.3332C2 14.0696 2.59695 14.6665 3.33333 14.6665H12.6667C13.403 14.6665 14 14.0696 14 13.3332V3.99984C14 3.26346 13.403 2.6665 12.6667 2.6665Z" stroke="#FFB3E1" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M2 6.6665H14" stroke="#FFB3E1" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="text-sm">{{ $event->start_at->translatedFormat('d M Y') }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-[#46000D] font-['Open_Sans']">
                                    <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.3334 6.66683C13.3334 9.9955 9.64069 13.4622 8.40069 14.5328C8.28517 14.6197 8.14455 14.6667 8.00002 14.6667C7.85549 14.6667 7.71487 14.6197 7.59935 14.5328C6.35935 13.4622 2.66669 9.9955 2.66669 6.66683C2.66669 5.25234 3.22859 3.89579 4.22878 2.89559C5.22898 1.8954 6.58553 1.3335 8.00002 1.3335C9.41451 1.3335 10.7711 1.8954 11.7713 2.89559C12.7715 3.89579 13.3334 5.25234 13.3334 6.66683Z" stroke="#FFB3E1" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 8.6665C9.10457 8.6665 10 7.77107 10 6.6665C10 5.56193 9.10457 4.6665 8 4.6665C6.89543 4.6665 6 5.56193 6 6.6665C6 7.77107 6.89543 8.6665 8 8.6665Z" stroke="#FFB3E1" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="text-sm">{{ $event->venue_name }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-[#46000D] font-['Open_Sans']">
                                    <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.6666 14V12.6667C10.6666 11.9594 10.3857 11.2811 9.8856 10.781C9.3855 10.281 8.70722 10 7.99998 10H3.99998C3.29274 10 2.61446 10.281 2.11436 10.781C1.61426 11.2811 1.33331 11.9594 1.33331 12.6667V14" stroke="#FFB3E1" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.6667 2.08545C11.2385 2.2337 11.7449 2.56763 12.1065 3.03482C12.468 3.50202 12.6642 4.07604 12.6642 4.66678C12.6642 5.25752 12.468 5.83154 12.1065 6.29874C11.7449 6.76594 11.2385 7.09987 10.6667 7.24812" stroke="#FFB3E1" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.6667 14.0002V12.6669C14.6662 12.0761 14.4696 11.5021 14.1076 11.0351C13.7456 10.5682 13.2388 10.2346 12.6667 10.0869" stroke="#FFB3E1" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.99998 7.33333C7.47274 7.33333 8.66665 6.13943 8.66665 4.66667C8.66665 3.19391 7.47274 2 5.99998 2C4.52722 2 3.33331 3.19391 3.33331 4.66667C3.33331 6.13943 4.52722 7.33333 5.99998 7.33333Z" stroke="#FFB3E1" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="text-sm">{{ $event->remainingSlots() ?? 'Tidak terbatas' }} peserta</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mt-auto">
                                <div class="flex items-center gap-2">
                                    <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_2083_468)">
                                        <path d="M8.39071 1.72416C8.14072 1.4741 7.80163 1.33357 7.44804 1.3335H2.66671C2.31309 1.3335 1.97395 1.47397 1.7239 1.72402C1.47385 1.97407 1.33337 2.31321 1.33337 2.66683V7.44816C1.33345 7.80176 1.47397 8.14084 1.72404 8.39083L7.52671 14.1935C7.82972 14.4946 8.23954 14.6636 8.66671 14.6636C9.09388 14.6636 9.5037 14.4946 9.80671 14.1935L14.1934 9.80683C14.4945 9.50382 14.6635 9.094 14.6635 8.66683C14.6635 8.23966 14.4945 7.82984 14.1934 7.52683L8.39071 1.72416Z" stroke="#FFB3E1" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.99996 5.33317C5.18405 5.33317 5.33329 5.18393 5.33329 4.99984C5.33329 4.81574 5.18405 4.6665 4.99996 4.6665C4.81586 4.6665 4.66663 4.81574 4.66663 4.99984C4.66663 5.18393 4.81586 5.33317 4.99996 5.33317Z" fill="#FFB3E1" stroke="#FFB3E1" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_2083_468">
                                        <rect width="16" height="16" fill="white"/>
                                        </clipPath>
                                        </defs>
                                    </svg>

                                    <span class="text-lg font-['Open_Sans'] font-bold text-[#822021]">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                                </div>
                                <a href="{{ route('events.show', $event) }}" class="bg-[#FFB3E1] text-[#822021] text-sm font-['Open_Sans'] font-semibold px-6 py-2 rounded-full hover:bg-[#FFB3E1]/80 transition">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-16 rounded-[32px] border border-dashed border-[#FAD6C7] bg-white/80">
                        <p class="text-[#5F4C4C]">Belum ada event yang tersedia saat ini. Nantikan pengumuman berikutnya!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-[#FCF5E6]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-10">
            <div class="text-center space-y-3">
                <h2 class="text-3xl font-['Cousine'] font-bold text-[#822021]">Portofolio Kegiatan</h2>
                <p class="text-base font-['Open_Sans'] text-[#46000D] max-w-xl mx-auto">Lihat dokumentasi dari berbagai event dan workshop yang telah kami selenggarakan bersama komunitas dan mitra</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($featuredPortfolios as $portfolio)
                    <article class="portfolio-card group cursor-pointer flex flex-col h-full">
                        <div class="portfolio-image-container relative overflow-hidden rounded-2xl shadow-md mb-4 transition-transform duration-300 hover:scale-105" onclick="toggleMobileOverlay(this)">
                            @if ($portfolio->cover_image_url)
                                <img src="{{ $portfolio->cover_image_url }}" alt="{{ $portfolio->title }}" class="portfolio-image h-64 w-full object-cover transition-transform duration-500" />
                            @else
                                <div class="portfolio-image flex h-64 w-full items-center justify-center bg-gray-200 transition-transform duration-500">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif
                            
                            <!-- Content overlay - only visible on hover -->
                            <div class="portfolio-overlay absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                <div class="space-y-3">
                                    <h3 class="font-open-sans font-semibold text-white text-lg leading-tight">{{ $portfolio->title }}</h3>
                                    <p class="font-open-sans text-white text-sm leading-relaxed">{{ Str::limit($portfolio->description, 100) }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col flex-grow">
                            <div class="h-16 flex items-center">
                                <h4 class="font-open-sans font-semibold text-[#822021] text-lg line-clamp-2">{{ $portfolio->title }}</h4>
                            </div>
                            @if ($portfolio->event)
                                <div class="mt-auto">
                                    <a href="{{ route('events.show', $portfolio->event) }}" class="inline-flex items-center gap-1 text-sm font-['Open_Sans'] text-[#B49F9A]">
                                        Lihat Event
                                        <svg width="5" height="10" viewBox="0 0 5 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.8012 5.55547L0.960104 10L0 8.88906L3.36104 5L0 1.11094L0.960104 0L4.8012 4.44453C4.92849 4.59187 5 4.79167 5 5C5 5.20833 4.92849 5.40813 4.8012 5.55547Z" fill="#B49F9A"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-3 text-center py-14 rounded-[32px] border border-dashed border-[#FAD6C7] bg-white/80">
                        <p class="text-[#5F4C4C]">Belum ada dokumentasi portofolio yang dapat ditampilkan saat ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center">
                <a href="{{ route('portfolio.index') }}" class="inline-flex items-center rounded-full bg-[#822021] px-7 py-3 text-sm font-semibold text-[#FAF8F1] shadow-sm shadow-[#822021]/40 transition hover:bg-[#5c261d]">
                    Lihat Semua Portofolio
                </a>
            </div>
        </div>
    </section>

    <section class="bg-gradient-to-r from-[#FFBE8E] to-[#FCF5E6]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <div class="mx-auto space-y-4">
                <h2 class="text-3xl font-['Cousine'] font-bold text-[#822021]">Siap Memulai Perjalanan Kreatif Anda?</h2>
                <p class="text-base font-['Open_Sans'] text-[#46000D] max-w-xl mx-auto">Daftar sekarang dan dapatkan pengalaman belajar yang menyenangkan bersama Tim Kreasi Hangat</p>
                <div class="flex flex-wrap justify-center gap-4 pt-2">
                    <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-full bg-[#822021] px-6 py-2 text-sm font-['Open_Sans'] font-semibold text-[#FAF8F1] shadow-sm shadow-[#822021]/40 transition hover:bg-[#5c261d]">
                        Lihat Event
                    </a>
                    <a href="{{ route('partnership.index') }}" class="inline-flex items-center rounded-full bg-[#FAF8F1] border border-[#FFBE8E] px-6 py-2 text-sm font-['Open_Sans'] font-semibold text-[#822021] shadow-sm shadow-[#FFBE8E]/40 transition hover:bg-white transition">
                        Ajukan Kolaborasi
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
