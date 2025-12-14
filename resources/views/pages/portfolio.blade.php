@php
    use Illuminate\Pagination\AbstractPaginator;
    use Illuminate\Support\Str;

    $portfolioCollection = $portfolios instanceof AbstractPaginator ? $portfolios->getCollection() : collect($portfolios);
    $totalPortfolios = method_exists($portfolios, 'total') ? $portfolios->total() : $portfolioCollection->count();
    $categoryCount = $portfolioCollection->pluck('event_id')->filter()->unique()->count();
@endphp

<x-layouts.app :title="'Portofolio Sicrea'">
    <style>
        /* 1. Import Font Poppins */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
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
            background-color: #FCF5E6; 
            border: 3px solid #FFBE8E;
            border-radius: 24px;
            max-width: 700px;
            width: 90%;
            /* Ubah height menjadi max-height agar responsif terhadap konten */
            max-height: 90vh; 
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Hide overflow parent, scroll child */
            position: relative;
            transform: scale(0.8);
            transition: transform 0.3s ease;
        }
        
        .modal-overlay.active .modal-content {
            transform: scale(1);
        }
        
        /* Custom Scrollbar untuk Modal Content */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.05);
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #FFBE8E;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #822021;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
                border-width: 2px;
            }
            .modal-content .p-6 {
                padding: 1rem !important;
            }
            #modalTitle {
                font-size: 1.25rem !important;
                padding-right: 2rem !important;
            }
            .modal-content button[onclick="closeModal()"] {
                top: 0.75rem;
                right: 0.75rem;
                font-size: 1.5rem;
            }
            #thumbnailContainer .w-16 {
                width: 3rem;
                height: 3rem;
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

        /* Pagination Styles (Sama seperti sebelumnya) */
        nav[role="navigation"] p.text-sm { color: #822021 !important; }
        nav[role="navigation"] p.text-sm span { color: #822021 !important; font-weight: 700; }
        nav[role="navigation"] > div:last-child > div > span { box-shadow: none !important; }
        nav[role="navigation"] a, 
        nav[role="navigation"] span[aria-current="page"] span,
        nav[role="navigation"] span[aria-disabled="true"] span {
            background-color: #FCF5E6 !important; 
            color: #822021 !important;            
            border: 1px solid #822021 !important;  
            border-radius: 8px;                    
            margin: 0 2px;                         
            display: inline-flex; align-items: center; justify-content: center;
            height: 36px; min-width: 36px; padding: 0 10px;
            font-size: 0.875rem; font-weight: 600; transition: all 0.3s ease;
        }
        nav[role="navigation"] span[aria-disabled="true"] span { opacity: 0.5; cursor: not-allowed; }
        nav[role="navigation"] span[aria-disabled="true"] span svg { color: #822021 !important; fill: currentColor; }
        nav[role="navigation"] span[aria-current="page"] span { background-color: #822021 !important; color: #FCF5E6 !important; border-color: #822021 !important; }
        nav[role="navigation"] a:hover { background-color: #822021 !important; color: #FCF5E6 !important; transform: scale(1.1); z-index: 10; }
        nav[role="navigation"] svg { width: 16px; height: 16px; stroke-width: 2.5; }
        nav[role="navigation"] span.relative.z-0.inline-flex.shadow-sm.rounded-md { box-shadow: none !important; }
        nav[role="navigation"] a.relative.inline-flex.items-center, nav[role="navigation"] span[aria-disabled="true"] span { margin-left: 4px !important; }
    </style>

    <section class="bg-[#FCF5E6] py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-4 mb-12">
                <h1 class="text-4xl md:text-5xl font-poppins font-bold text-[#822021]">Portofolio Kegiatan</h1>
                <p class="text-base font-poppins text-[#46000D] max-w-md mx-auto">Dokumentasi berbagai workshop dan event kreatif yang telah kami selenggarakan</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($portfolios as $portfolio)
                    @php
                        $gallery = $portfolio->images;
                        $firstImage = $gallery->first();
                        $thumbnailUrl = $firstImage ? $firstImage->url : null;
                        $photoCount = $gallery->count();
                        $galleryJson = $gallery->pluck('url')->toJson();
                        $eventTitle = $portfolio->event ? $portfolio->event->title : 'General Event';
                    @endphp

                    <article class="portfolio-card group cursor-pointer" 
                             data-id="{{ $portfolio->id }}" 
                             data-title="{{ $portfolio->title }}" 
                             data-event-title="{{ $eventTitle }}" 
                             data-image="{{ $thumbnailUrl }}" 
                             data-images="{{ $galleryJson }}"
                             /* DATA BARU: Description & Media URL */
                             data-description="{{ $portfolio->description }}"
                             data-media-url="{{ $portfolio->media_url }}"
                             onclick="openModal(this)">
                        
                        <div class="relative overflow-hidden rounded-2xl shadow-md mb-4 transition-transform duration-300 hover:scale-105">
                            @if ($thumbnailUrl)
                                <img src="{{ $thumbnailUrl }}" alt="{{ $portfolio->title }}" class="portfolio-image h-64 w-full object-cover transition-transform duration-500" />
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
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0">
                                    <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="#46000D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="line-clamp-1">{{ $eventTitle }}</span>
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
            <button onclick="closeModal()" class="absolute top-4 right-4 text-[#822021] hover:text-[#46000D] text-2xl font-bold cursor-pointer z-20">
                ×
            </button>
            
            <div id="modalContent" class="h-full flex flex-col overflow-y-auto custom-scrollbar pr-2">
                <div class="space-y-2 mb-4 shrink-0">
                    <h2 id="modalTitle" class="font-poppins font-bold text-2xl text-[#822021] pr-8">Judul Portofolio</h2>
                    
                    <div class="flex items-center gap-2 text-[#46000D] text-sm font-poppins">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0">
                            <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="#46000D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span id="modalEventTitle">Nama Event</span>
                    </div>
                </div>
                
                <div class="flex-shrink-0 mb-6">
                    <div class="flex items-center justify-center mb-4">
                        <div class="rounded-2xl overflow-hidden shadow-md aspect-[16/9] w-full max-w-md bg-gray-100">
                            <img id="modalImage" src="" alt="Portfolio Image" class="w-full h-full object-cover" />
                        </div>
                    </div>
                    
                    <div class="flex justify-center">
                        <div id="thumbnailContainer" class="flex gap-3 flex-wrap justify-center">
                            </div>
                    </div>
                </div>

                <div class="mt-auto border-t border-[#FFBE8E] pt-4 pb-2">
                    <h5 class="font-poppins font-semibold text-[#822021] mb-2 text-sm">Deskripsi</h5>
                    <p id="modalDescription" class="font-poppins text-sm text-[#46000D] leading-relaxed mb-4 whitespace-pre-line">
                        </p>

                    <a id="modalLink" href="#" target="_blank" class="hidden inline-flex items-center gap-2 rounded-full bg-[#822021] px-5 py-2.5 text-sm font-medium text-[#FCF5E6] shadow-md transition hover:bg-[#6A1A1B] hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M15.75 2.25H21a.75.75 0 01.75.75v5.25a.75.75 0 01-1.5 0V4.81L8.03 17.03a.75.75 0 01-1.06-1.06L19.19 3.75h-3.44a.75.75 0 010-1.5zm-10.5 4.5a1.5 1.5 0 00-1.5 1.5v10.5a1.5 1.5 0 001.5 1.5h10.5a1.5 1.5 0 001.5-1.5V10.5a.75.75 0 011.5 0v8.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V8.25a3 3 0 013-3h8.25a.75.75 0 010 1.5H5.25z" clip-rule="evenodd" />
                        </svg>
                        Lihat Dokumentasi Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(element) {
            // Ambil data attributes
            const title = element.getAttribute('data-title');
            const eventTitle = element.getAttribute('data-event-title');
            const coverImage = element.getAttribute('data-image');
            const imagesData = element.getAttribute('data-images');
            // Data baru
            const description = element.getAttribute('data-description');
            const mediaUrl = element.getAttribute('data-media-url');
            
            let images = [];
            try {
                images = JSON.parse(imagesData || '[]');
            } catch (e) {
                images = [];
            }
            
            if (coverImage && !images.includes(coverImage)) {
                images.unshift(coverImage);
            }
            
            // Populate Text Data
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalEventTitle').textContent = eventTitle;
            document.getElementById('modalDescription').textContent = description || 'Tidak ada deskripsi tersedia.';
            
            // Logic Link Dokumen
            const linkBtn = document.getElementById('modalLink');
            if (mediaUrl && mediaUrl.trim() !== "") {
                linkBtn.href = mediaUrl;
                linkBtn.classList.remove('hidden');
                linkBtn.classList.add('inline-flex');
            } else {
                linkBtn.classList.add('hidden');
                linkBtn.classList.remove('inline-flex');
            }
            
            // Logic Images
            const mainImage = coverImage || (images.length > 0 ? images[0] : 'https://via.placeholder.com/600x320');
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
                const allThumbs = thumbnailContainer.querySelectorAll('img');
                allThumbs.forEach(img => {
                    if(img.src === mainImage) {
                         img.parentElement.classList.add('ring-1', 'ring-[#822021]');
                    }
                });
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