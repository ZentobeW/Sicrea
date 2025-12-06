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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body, h1, h2, h3, h4, p, a, span, div, button {
            font-family: 'Poppins', sans-serif !important;
        }

        /* --- Button Zoom Effect --- */
        .btn-zoom {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-zoom:hover {
            transform: scale(1.05);
            background-color: #822021 !important;
            color: #FCF5E6 !important;
            border-color: #822021 !important;
        }

        /* --- Event Card Style --- */
        .event-card {
            box-sizing: border-box;
            background: #FCF5E6;
            border: 1px solid #822021;
            box-shadow: 12px 17px 51px rgba(0, 0, 0, 0.22);
            border-radius: 17px;
            cursor: pointer;
            transition: all 0.5s;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            user-select: none;
            color: black;
        }
        .event-card:hover {
            border: 1px solid black;
            transform: scale(1.05);
            z-index: 10;
        }
        .event-card:active {
            transform: scale(0.95) rotateZ(1.7deg);
        }

        /* --- Portfolio & Modal Styles (Sama seperti halaman portfolio) --- */
        .portfolio-card:hover .portfolio-image { transform: scale(1.1); }
        .portfolio-overlay { opacity: 0; transition: opacity 0.3s ease; }
        .portfolio-card:hover .portfolio-overlay { opacity: 1; }
        .portfolio-card.mobile-active .portfolio-image { transform: scale(1.1); }
        .portfolio-card.mobile-active .portfolio-overlay { opacity: 1; }

        /* Modal Styling */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex; justify-content: center; align-items: center;
            z-index: 1000; opacity: 0; visibility: hidden; transition: all 0.3s ease;
        }
        .modal-overlay.active { opacity: 1; visibility: visible; }
        
        .modal-content {
            background-color: #FCF5E6; 
            border: 3px solid #FFBE8E;
            border-radius: 24px;
            max-width: 700px; width: 90%; aspect-ratio: 4/3;
            overflow: hidden; position: relative;
            transform: scale(0.8); transition: transform 0.3s ease;
        }
        .modal-overlay.active .modal-content { transform: scale(1); }

        /* Mobile Modal Styles */
        @media (max-width: 768px) {
            .modal-content {
                width: 95%; max-width: none; aspect-ratio: auto; max-height: 90vh;
                border-radius: 16px; border-width: 2px;
            }
            .modal-content .p-6 { padding: 1rem !important; }
            #modalContent { gap: 0.75rem; }
            #modalTitle { font-size: 1.25rem !important; line-height: 1.4 !important; padding-right: 2rem !important; }
            .modal-content .space-y-2, .modal-content .flex-1 { margin-bottom: 0.75rem !important; }
            .modal-content .aspect-\[16\/9\] { aspect-ratio: 16/10; max-width: none; }
            .modal-content .flex.justify-between { flex-direction: column; gap: 1rem; align-items: stretch; }
            #thumbnailContainer { justify-content: center; max-width: 100%; overflow-x: auto; padding-bottom: 0.25rem; }
            #thumbnailContainer .w-16 { width: 3rem; height: 3rem; flex-shrink: 0; }
            #lihatEventBtn { width: 100%; justify-self: stretch; padding: 0.75rem 1.5rem !important; font-size: 0.875rem !important; }
            .modal-content button[onclick="closeModal()"] { top: 0.75rem; right: 0.75rem; font-size: 1.5rem; }
            
            /* Carousel Mobile Fix */
            #carousel-container { height: auto !important; }
            #img-center { width: 100% !important; height: auto !important; aspect-ratio: 4/3; }
            #center-img { aspect-ratio: 4/3; }
            #img-left-1, #img-left-2, #img-right-1, #img-right-2 { height: auto !important; aspect-ratio: 9/16; }
            #img-left-1 img, #img-left-2 img, #img-right-1 img, #img-right-2 img { aspect-ratio: 9/16; }
            .portfolio-image-container { cursor: pointer; }
        }
        @media (max-width: 480px) {
            .modal-content { width: 98%; border-radius: 12px; }
            #modalTitle { font-size: 1.125rem !important; }
            #thumbnailContainer .w-16 { width: 2.5rem; height: 2.5rem; }
        }

        /* --- New Infinite Slider CSS --- */
        .slider {
            width: 100%;
            height: var(--height);
            overflow: hidden;
            /* Efek fade di pinggir kiri dan kanan */
            mask-image: linear-gradient(to right, transparent, #000 5% 95%, transparent);
        }

        .slider .list {
            display: flex;
            width: 100%;
            min-width: calc(var(--width) * var(--quantity));
            position: relative;
        }

        .slider .list .item {
            width: var(--width);
            height: var(--height);
            position: absolute;
            left: 100%;
            animation: autoRun 30s linear infinite; /* Kecepatan Medium (30s) */
            transition: filter 0.5s;
            animation-delay: calc(
                (30s / var(--quantity)) * (var(--position) - 1) - 30s
            ) !important;
            padding: 0 10px; /* Jarak antar gambar */
        }

        /* Style Gambar di dalam Item */
        .slider .list .item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #822021; /* Border Merah */
            box-shadow: 0 4px 6px rgba(130, 32, 33, 0.2);
            transition: transform 0.3s;
        }

        @keyframes autoRun {
            from { left: 100%; }
            to { left: calc(var(--width) * -1); }
        }

        /* Hover Effect: Pause & Grayscale */
        .slider:hover .item {
            animation-play-state: paused !important;
            filter: grayscale(1);
        }

        .slider .item:hover {
            filter: grayscale(0);
            z-index: 10;
        }
        
        .slider .item:hover img {
            transform: scale(1.05); /* Zoom dikit saat hover gambar spesifik */
        }

        /* Responsif untuk Mobile */
        @media (max-width: 768px) {
            .slider {
                --width: 250px !important; /* Gambar lebih kecil di HP */
                --height: 180px !important;
            }
        }
    </style>

    <section class="relative overflow-hidden bg-[#FFDEF8]">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20">
            <div class="grid gap-10 lg:grid-cols-2 items-center">
                <div class="space-y-8">
                    <div class="space-y-6">
                        <h1 class="text-4xl md:text-6xl font-bold leading-tight text-[#822021]">
                            Wujudkan <br> Kreativitas Anda Bersama Kami
                        </h1>
                        <p class="text-justify text-base md:text-lg leading-relaxed text-[#822021] max-w-2xl">
                            Kreasi Hangat hadir sebagai komunitas yang bergerak di bidang creative class dan workshop...
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('events.index') }}" class="btn-zoom inline-flex items-center rounded-full bg-[#FFDEF8] border border-[#822021] px-6 py-2 text-sm font-semibold text-[#822021] shadow-sm">
                            Lihat Event
                        </a>
                        <a href="{{ route('portfolio.index') }}" class="btn-zoom inline-flex items-center rounded-full bg-[#FFDEF8] border border-[#822021] px-6 py-2 text-sm font-semibold text-[#822021] shadow-sm">
                            Tentang Kami
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/3] overflow-hidden rounded-2xl shadow-lg border-2 border-[#822021]">
                        <img src="https://images.unsplash.com/photo-1757085242669-076c35ff9397?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjcmVhdGl2ZSUyMHdvcmtzaG9wJTIwcGVvcGxlfGVufDF8fHx8MTc1OTI5MTUxOXww&ixlib=rb-4.1.0&q=80&w=1080" alt="Workshop Kreativitas" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div class="w-full h-full bg-[#FAF8F1] flex items-center justify-center text-sm uppercase tracking-[0.35em] text-[#822021]/70" style="display: none;">
                            Foto Workshop
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#FCF5E6] py-16 border-y border-[#822021]/10">
        <div class="max-w-full mx-auto"> <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-[#822021] font-['Cousine']">Galeri Aktivitas</h3>
            </div>

            <div class="slider" style="--width: 350px; --height: 250px; --quantity: 10;">
                <div class="list">
                    
                    <div class="item" style="--position: 1">
                        <img src="https://images.unsplash.com/photo-1758522274463-67ef9e5e88b1?w=800&h=600&fit=crop" alt="Workshop 1">
                    </div>
                    
                    <div class="item" style="--position: 2">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop" alt="Workshop 2">
                    </div>
                    
                    <div class="item" style="--position: 3">
                        <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&h=600&fit=crop" alt="Workshop 3">
                    </div>
                    
                    <div class="item" style="--position: 4">
                        <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?w=800&h=600&fit=crop" alt="Workshop 4">
                    </div>
                    
                    <div class="item" style="--position: 5">
                        <img src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?w=800&h=600&fit=crop" alt="Workshop 5">
                    </div>
                    
                    <div class="item" style="--position: 6">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=600&fit=crop" alt="Workshop 6">
                    </div>
                    
                    <div class="item" style="--position: 7">
                        <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800&h=600&fit=crop" alt="Workshop 7">
                    </div>
                    
                    <div class="item" style="--position: 8">
                        <img src="https://images.unsplash.com/photo-1758522276630-8ebdf55d7619?w=800&h=600&fit=crop" alt="Workshop 8">
                    </div>
                    
                    <div class="item" style="--position: 9">
                        <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=800&h=600&fit=crop" alt="Workshop 9">
                    </div>
                    
                    <div class="item" style="--position: 10">
                        <img src="https://images.unsplash.com/photo-1757085242669-076c35ff9397?w=800&h=600&fit=crop" alt="Workshop 10">
                    </div>

                </div>
            </div>

        </div>
    </section>

    <section class="bg-[#FFDEF8]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-10">
            <div class="text-center space-y-3">
                <h2 class="text-3xl font-bold text-[#822021]">Event Mendatang</h2>
                <p class="text-base text-[#822021] max-w-xl mx-auto">Jangan lewatkan kesempatan untuk mengikuti workshop dan event kreatif sesuai minat dan bakat Anda</p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($upcomingEvents as $event)
                    <article class="event-card h-full">
                        <div class="aspect-[4/3] bg-gray-200 overflow-hidden shrink-0">
                            @if ($event->cover_image_url)
                                <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-[#FAF8F1] flex items-center justify-center">
                                    <span class="text-[#822021]/50 text-sm uppercase tracking-[0.35em]">Event Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6 flex flex-col flex-grow text-left">
                            <div class="h-16 mb-4 flex items-center">
                                <h3 class="text-xl font-bold text-[#822021] line-clamp-2">{{ $event->title }}</h3>
                            </div>
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center gap-3 text-[#822021]">
                                    <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.33331 1.3335V4.00016" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.6667 1.3335V4.00016" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12.6667 2.6665H3.33333C2.59695 2.6665 2 3.26346 2 3.99984V13.3332C2 14.0696 2.59695 14.6665 3.33333 14.6665H12.6667C13.403 14.6665 14 14.0696 14 13.3332V3.99984C14 3.26346 13.403 2.6665 12.6667 2.6665Z" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M2 6.6665H14" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="text-sm font-semibold">{{ $event->start_at->translatedFormat('d M Y') }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-[#822021]">
                                    <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.6666 14V12.6667C10.6666 11.9594 10.3857 11.2811 9.8856 10.781C9.3855 10.281 8.70722 10 7.99998 10H3.99998C3.29274 10 2.61446 10.281 2.11436 10.781C1.61426 11.2811 1.33331 11.9594 1.33331 12.6667V14" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.6667 2.08545C11.2385 2.2337 11.7449 2.56763 12.1065 3.03482C12.468 3.50202 12.6642 4.07604 12.6642 4.66678C12.6642 5.25752 12.468 5.83154 12.1065 6.29874C11.7449 6.76594 11.2385 7.09987 10.6667 7.24812" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.6667 14.0002V12.6669C14.6662 12.0761 14.4696 11.5021 14.1076 11.0351C13.7456 10.5682 13.2388 10.2346 12.6667 10.0869" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.99998 7.33333C7.47274 7.33333 8.66665 6.13943 8.66665 4.66667C8.66665 3.19391 7.47274 2 5.99998 2C4.52722 2 3.33331 3.19391 3.33331 4.66667C3.33331 6.13943 4.52722 7.33333 5.99998 7.33333Z" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="text-sm font-semibold">{{ $event->remainingSlots() ?? 'Tidak terbatas' }} peserta</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-auto">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg font-bold text-[#822021]">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                                </div>
                                <a href="{{ route('events.show', $event) }}" class="bg-[#822021] text-[#FCF5E6] text-sm font-semibold px-6 py-2 rounded-full hover:bg-[#6a1a1b] transition shadow-md">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-16 rounded-[32px] border border-dashed border-[#822021]/30 bg-[#FAF8F1]">
                        <p class="text-[#822021]">Belum ada event yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-[#FFDEF8]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-10">
            <div class="text-center space-y-3">
                <h2 class="text-3xl font-bold text-[#822021]">Portofolio Kegiatan</h2>
                <p class="text-base text-[#822021] max-w-xl mx-auto">Lihat dokumentasi dari berbagai event dan workshop yang telah kami selenggarakan</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($featuredPortfolios as $portfolio)
                    @php($photoCount = $portfolio->images->count())
                    <article class="portfolio-card group cursor-pointer flex flex-col h-full bg-[#FAF8F1] rounded-2xl border border-[#822021] p-4 shadow-md"
                             data-id="{{ $portfolio->id }}" 
                             data-title="{{ $portfolio->title }}" 
                             data-date="{{ $portfolio->created_at->translatedFormat('d M Y') }}" 
                             data-image="{{ $portfolio->cover_image_url }}" 
                             data-images="{{ $portfolio->images->pluck('image_url')->toJson() }}"
                             data-event-id="{{ $portfolio->event_id }}"
                             onclick="openModal(this)">
                        
                        <div class="portfolio-image-container relative overflow-hidden rounded-xl shadow-sm mb-4">
                            @if ($portfolio->cover_image_url)
                                <img src="{{ $portfolio->cover_image_url }}" alt="{{ $portfolio->title }}" class="portfolio-image h-64 w-full object-cover transition-transform duration-500" />
                            @else
                                <div class="portfolio-image flex h-64 w-full items-center justify-center bg-[#FFDEF8] transition-transform duration-500">
                                    <span class="text-[#822021]/50 text-sm">No Image</span>
                                </div>
                            @endif
                            
                            <div class="absolute top-3 right-3 bg-black/60 text-white px-2 py-1 rounded text-sm">
                                +{{ $photoCount }} foto
                            </div>

                            <div class="portfolio-overlay absolute inset-0 bg-gradient-to-t from-[#822021]/90 via-[#822021]/30 to-transparent flex flex-col justify-end p-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                <div class="space-y-2">
                                    <h3 class="font-semibold text-[#FCF5E6] text-lg leading-tight">{{ $portfolio->title }}</h3>
                                    <p class="text-[#FCF5E6]/90 text-sm leading-relaxed">{{ Str::limit($portfolio->description, 100) }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col flex-grow">
                            <div class="h-14 flex items-center">
                                <h4 class="font-semibold text-[#822021] text-lg line-clamp-2">{{ $portfolio->title }}</h4>
                            </div>
                            <div class="flex items-center gap-2 text-[#822021] text-sm mt-2">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.33331 1.3335V4.00016" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10.6667 1.3335V4.00016" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12.6667 2.6665H3.33333C2.59695 2.6665 2 3.26346 2 3.99984V13.3332C2 14.0696 2.59695 14.6665 3.33333 14.6665H12.6667C13.403 14.6665 14 14.0696 14 13.3332V3.99984C14 3.26346 13.403 2.6665 12.6667 2.6665Z" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2 6.6665H14" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>{{ $portfolio->created_at->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-3 text-center py-14 rounded-[32px] border border-dashed border-[#822021]/30 bg-[#FAF8F1]">
                        <p class="text-[#822021]">Belum ada dokumentasi portofolio yang dapat ditampilkan saat ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center">
                <a href="{{ route('portfolio.index') }}" class="btn-zoom inline-flex items-center rounded-full bg-[#FFDEF8] border border-[#822021] px-7 py-3 text-sm font-semibold text-[#822021] shadow-sm">
                    Lihat Semua Portofolio
                </a>
            </div>
        </div>
    </section>

    <div id="portfolioModal" class="modal-overlay">
        <div class="modal-content p-6">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-[#822021] hover:text-black text-2xl font-bold cursor-pointer">
                ×
            </button>
            <div id="modalContent" class="h-full flex flex-col">
                <div class="space-y-2 mb-4">
                    <h2 id="modalTitle" class="font-bold text-2xl text-[#822021] pr-8">Nama Dokumentasi</h2>
                    <div class="flex items-center gap-2 text-[#822021] text-sm">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33331 1.3335V4.00016" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.6667 1.3335V4.00016" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.6667 2.6665H3.33333C2.59695 2.6665 2 3.26346 2 3.99984V13.3332C2 14.0696 2.59695 14.6665 3.33333 14.6665H12.6667C13.403 14.6665 14 14.0696 14 13.3332V3.99984C14 3.26346 13.403 2.6665 12.6667 2.6665Z" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 6.6665H14" stroke="#822021" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span id="modalDate">Tanggal</span>
                    </div>
                </div>
                <div class="flex-1 flex items-center justify-center mb-4">
                    <div class="rounded-2xl overflow-hidden shadow-md aspect-[16/9] w-full max-w-md">
                        <img id="modalImage" src="" alt="Workshop Image" class="w-full h-full object-cover" />
                    </div>
                </div>
                <div class="flex justify-between items-end mt-auto">
                    <div id="thumbnailContainer" class="flex gap-3 flex-wrap"></div>
                    <button id="lihatEventBtn" class="bg-[#822021] text-[#FAF8F1] font-semibold px-6 py-2 rounded-full hover:bg-[#6a1a1b] transition-colors cursor-pointer">
                        Lihat Event
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="bg-[#FAF8F1] border-t border-[#822021]/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <div class="mx-auto space-y-4">
                <h2 class="text-3xl font-bold text-[#822021]">Siap Memulai Perjalanan Kreatif Anda?</h2>
                <p class="text-base text-[#822021] max-w-xl mx-auto">Daftar sekarang dan dapatkan pengalaman belajar yang menyenangkan bersama Tim Kreasi Hangat</p>
                <div class="flex flex-wrap justify-center gap-4 pt-2">
                    <a href="{{ route('events.index') }}" class="btn-zoom inline-flex items-center rounded-full bg-[#FFDEF8] border border-[#822021] px-6 py-2 text-sm font-semibold text-[#822021] shadow-sm">
                        Lihat Event
                    </a>
                    <a href="{{ route('partnership.index') }}" class="btn-zoom inline-flex items-center rounded-full bg-[#FAF8F1] border border-[#822021] px-6 py-2 text-sm font-semibold text-[#822021] shadow-sm">
                        Ajukan Kolaborasi
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>