@php
    use Illuminate\Pagination\AbstractPaginator;
    use Illuminate\Support\Str;

    $portfolioCollection = $portfolios instanceof AbstractPaginator ? $portfolios->getCollection() : collect($portfolios);
    $totalPortfolios = method_exists($portfolios, 'total') ? $portfolios->total() : $portfolioCollection->count();
    $categoryCount = $portfolioCollection->pluck('event_id')->filter()->unique()->count();
@endphp

<x-layouts.app :title="'Portofolio Sicrea'">
    <style>
        /* 1. Mengubah Import Font ke Poppins */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        /* Class Font Baru */
        .font-poppins { font-family: 'Poppins', sans-serif; }

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
        
        /* Modal Styling */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .modal-content {
            /* 2. Mengubah Background menjadi Solid FCF5E6 */
            background-color: #FCF5E6; 
            border: 3px solid #FFBE8E; /* Border tetap dipertahankan agar rapi */
            border-radius: 24px;
            max-width: 700px;
            width: 90%;
            aspect-ratio: 4/3;
            overflow: hidden;
            position: relative;
            transform: scale(0.8);
            transition: transform 0.3s ease;
        }
        
        .modal-overlay.active .modal-content {
            transform: scale(1);
        }
        
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
                max-width: none;
                aspect-ratio: auto;
                max-height: 90vh;
                border-radius: 16px;
                border-width: 2px;
            }
            
            .modal-content .p-6 {
                padding: 1rem !important;
            }
            
            #modalContent {
                gap: 0.75rem;
            }
            
            #modalTitle {
                font-size: 1.25rem !important;
                line-height: 1.4 !important;
                padding-right: 2rem !important;
            }
            
            .modal-content .space-y-2 {
                margin-bottom: 0.75rem !important;
            }
            
            .modal-content .flex-1 {
                margin-bottom: 0.75rem !important;
            }
            
            .modal-content .aspect-\[16\/9\] {
                aspect-ratio: 16/10;
                max-width: none;
            }
            
            .modal-content .flex.justify-between {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
            
            #thumbnailContainer {
                justify-content: center;
                max-width: 100%;
                overflow-x: auto;
                padding-bottom: 0.25rem;
            }
            
            #thumbnailContainer .w-16 {
                width: 3rem;
                height: 3rem;
                flex-shrink: 0;
            }
            
            #lihatEventBtn {
                width: 100%;
                justify-self: stretch;
                padding: 0.75rem 1.5rem !important;
                font-size: 0.875rem !important;
            }
            
            .modal-content button[onclick="closeModal()"] {
                top: 0.75rem;
                right: 0.75rem;
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .modal-content {
                width: 98%;
                border-radius: 12px;
            }
            
            #modalTitle {
                font-size: 1.125rem !important;
            }
            
            #thumbnailContainer .w-16 {
                width: 2.5rem;
                height: 2.5rem;
            }
        }

        /* --- CUSTOM PAGINATION STYLE --- */

        /* 1. Teks "Showing ... results" */
        nav[role="navigation"] p.text-sm {
            color: #822021 !important; /* Warna Teks Merah */
        }
        nav[role="navigation"] p.text-sm span {
            color: #822021 !important; /* Warna Angka Tebal Merah */
            font-weight: 700;
        }

        /* 2. Container Tombol Pagination (Desktop) */
        nav[role="navigation"] > div:last-child > div > span {
            box-shadow: none !important; /* Hilangkan shadow bawaan */
        }

        /* 3. Semua Tombol (Angka & Panah) - Default State */
        nav[role="navigation"] a, 
        nav[role="navigation"] span[aria-current="page"] span,
        nav[role="navigation"] span[aria-disabled="true"] span {
            background-color: #FCF5E6 !important; /* Background Krem */
            color: #822021 !important;             /* Text Merah */
            border: 1px solid #822021 !important;  /* Border Merah */
            border-radius: 8px;                    /* Sedikit Rounded */
            margin: 0 2px;                         /* Jarak antar tombol */
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 36px;
            min-width: 36px;
            padding: 0 10px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        /* 4. Tombol Disabled / Mentok (Panah Kiri/Kanan saat disable) */
        nav[role="navigation"] span[aria-disabled="true"] span {
            background-color: #FCF5E6 !important; /* Tetap Krem */
            color: #822021 !important;             /* Tetap Merah */
            opacity: 0.5;                          /* Agak transparan agar terlihat non-aktif */
            cursor: not-allowed;
        }
        /* Memastikan icon SVG di dalam tombol disabled juga berwarna merah */
        nav[role="navigation"] span[aria-disabled="true"] span svg {
            color: #822021 !important;
            fill: currentColor;
        }

        /* 5. Tombol Aktif (Halaman saat ini) */
        nav[role="navigation"] span[aria-current="page"] span {
            background-color: #822021 !important; /* Background Merah */
            color: #FCF5E6 !important;            /* Text Krem */
            border-color: #822021 !important;
        }

        /* 6. Efek Hover (Untuk tombol yang bisa diklik) */
        nav[role="navigation"] a:hover {
            background-color: #822021 !important; /* Hover jadi Merah */
            color: #FCF5E6 !important;            /* Text jadi Krem */
            transform: scale(1.1);                /* Efek Zoom */
            z-index: 10;
        }

        /* 7. Icon SVG (Panah Previous/Next) */
        nav[role="navigation"] svg {
            width: 16px;
            height: 16px;
            stroke-width: 2.5; /* Menebalkan panah */
        }
        
        /* Hilangkan style rounded bawaan tailwind yang menyatu */
        nav[role="navigation"] span.relative.z-0.inline-flex.shadow-sm.rounded-md {
            box-shadow: none !important;
        }
        nav[role="navigation"] a.relative.inline-flex.items-center,
        nav[role="navigation"] span[aria-disabled="true"] span {
            margin-left: 4px !important; /* Beri jarak antar tombol */
        }

    </style>

    <section class="bg-[#FCF5E6] py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-4 mb-12">
                <h1 class="text-4xl md:text-5xl font-poppins font-bold text-[#822021]">Portofolio Kegiatan</h1>
                <p class="text-base font-poppins text-[#46000D] max-w-md mx-auto">Dokumentasi berbagai workshop dan event kreatif yang telah kami selenggarakan</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($portfolios as $portfolio)
                    @php($photoCount = $portfolio->images->count())
                    <article class="portfolio-card group cursor-pointer" 
                             data-id="{{ $portfolio->id }}" 
                             data-title="{{ $portfolio->title }}" 
                             data-date="{{ $portfolio->created_at->translatedFormat('d M Y') }}" 
                             data-image="{{ $portfolio->cover_image_url }}" 
                             data-images="{{ $portfolio->images->pluck('image_url')->toJson() }}"
                             onclick="openModal(this)">
                        <div class="relative overflow-hidden rounded-2xl shadow-md mb-4 transition-transform duration-300 hover:scale-105">
                            @if ($portfolio->cover_image_url)
                                <img src="{{ $portfolio->cover_image_url }}" alt="{{ $portfolio->title }}" class="portfolio-image h-64 w-full object-cover transition-transform duration-500" />
                            @else
                                <div class="portfolio-image flex h-64 w-full items-center justify-center bg-gray-200 transition-transform duration-500">
                                    <span class="text-gray-500 font-poppins">No Image</span>
                                </div>
                            @endif
                            
                            <div class="absolute top-3 right-3 bg-black/60 text-white px-2 py-1 rounded text-sm font-poppins">
                                +{{ $photoCount }} foto
                            </div>
                            
                            <div class="portfolio-overlay absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                <div class="space-y-3">
                                    <h3 class="font-poppins font-semibold text-white text-lg leading-tight">{{ $portfolio->title }}</h3>
                                    <p class="font-poppins text-white text-sm leading-relaxed">{{ Str::limit($portfolio->description, 100) }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <h4 class="font-poppins font-semibold text-[#822021] text-lg">{{ $portfolio->title }}</h4>
                            <div class="flex items-center gap-2 text-[#46000D] text-sm font-poppins">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0">
                                    <path d="M5.33331 1.3335V4.00016" stroke="#46000D" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10.6667 1.3335V4.00016" stroke="#46000D" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12.6667 2.6665H3.33333C2.59695 2.6665 2 3.26346 2 3.99984V13.3332C2 14.0696 2.59695 14.6665 3.33333 14.6665H12.6667C13.403 14.6665 14 14.0696 14 13.3332V3.99984C14 3.26346 13.403 2.6665 12.6667 2.6665Z" stroke="#46000D" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2 6.6665H14" stroke="#46000D" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>{{ $portfolio->created_at->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-16">
                        <p class="font-poppins text-[#46000D]">Belum ada portofolio yang dapat ditampilkan saat ini.</p>
                    </div>
                @endforelse
            </div>

            @if ($portfolios->hasPages())
                <div class="pt-6 pagination-wrapper">
                    <div style="font-family: 'Poppins', sans-serif; color: #46000D;">
                        {{ $portfolios->links() }}
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div id="portfolioModal" class="modal-overlay">
        <div class="modal-content p-6">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-[#822021] hover:text-[#46000D] text-2xl font-bold cursor-pointer">
                ×
            </button>
            
            <div id="modalContent" class="h-full flex flex-col">
                <div class="space-y-2 mb-4">
                    <h2 id="modalTitle" class="font-poppins font-bold text-2xl text-[#822021] pr-8">Nama Dokumentasi Workshop</h2>
                    <div class="flex items-center gap-2 text-[#46000D] text-sm font-poppins">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.33331 1.3335V4.00016" stroke="#46000D" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.6667 1.3335V4.00016" stroke="#46000D" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.6667 2.6665H3.33333C2.59695 2.6665 2 3.26346 2 3.99984V13.3332C2 14.0696 2.59695 14.6665 3.33333 14.6665H12.6667C13.403 14.6665 14 14.0696 14 13.3332V3.99984C14 3.26346 13.403 2.6665 12.6667 2.6665Z" stroke="#46000D" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 6.6665H14" stroke="#46000D" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span id="modalDate">Tanggal Workshop</span>
                    </div>
                </div>
                
                <div class="flex-1 flex items-center justify-center mb-4">
                    <div class="rounded-2xl overflow-hidden shadow-md aspect-[16/9] w-full max-w-md">
                        <img id="modalImage" src="https://via.placeholder.com/600x320" alt="Workshop Image" class="w-full h-full object-cover" />
                    </div>
                </div>
                
                <div class="flex justify-between items-end mt-auto">
                    <div id="thumbnailContainer" class="flex gap-3 flex-wrap justify-center">
                        </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ... (Script JavaScript di bawah ini sama persis dengan yang lama, tidak perlu diubah) ...
        function openModal(element) {
            const title = element.getAttribute('data-title');
            const date = element.getAttribute('data-date');
            const coverImage = element.getAttribute('data-image');
            const imagesData = element.getAttribute('data-images');
            const eventId = element.getAttribute('data-event-id');
            
            let images = [];
            try {
                images = JSON.parse(imagesData || '[]');
            } catch (e) {
                images = [];
            }
            
            if (coverImage && !images.includes(coverImage)) {
                images.unshift(coverImage);
            }
            
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalDate').textContent = date;
            
            const mainImage = images.length > 0 ? images[0] : 'https://via.placeholder.com/600x320';
            document.getElementById('modalImage').src = mainImage;
            
            const thumbnailContainer = document.getElementById('thumbnailContainer');
            thumbnailContainer.innerHTML = '';
            
            images.forEach((imageUrl, index) => {
                const thumbnailDiv = document.createElement('div');
                thumbnailDiv.className = 'w-20 h-13 rounded-xl overflow-hidden cursor-pointer transition hover:opacity-90 shadow-md hover:shadow-lg hover:scale-105 transition-transform duration-200';
                thumbnailDiv.innerHTML = '<img src="' + imageUrl + '" alt="Thumbnail" class="w-full h-full object-cover" />';
                thumbnailDiv.onclick = function() {
                    document.getElementById('modalImage').src = imageUrl;
                    document.querySelectorAll('#thumbnailContainer div').forEach(div => {
                        div.classList.remove('ring-1', 'ring-[#822021]');
                    });
                    thumbnailDiv.classList.add('ring-1', 'ring-[#822021]');
                };
                thumbnailContainer.appendChild(thumbnailDiv);
            });

            const firstThumb = thumbnailContainer.querySelector('div');
            if (firstThumb) {
                firstThumb.classList.add('ring-1', 'ring-[#822021]');
            }
                        
            document.getElementById('portfolioModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('portfolioModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('portfolioModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</x-layouts.app>