@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="'Kemitraan Sicrea'">
    <style>
        .interactive-grid{ position: relative; }
        .interactive-card{ transition: transform .28s cubic-bezier(.2,.8,.2,1), filter .28s ease, box-shadow .28s ease; will-change: transform, filter; }
        .interactive-grid:hover .interactive-card{ filter: blur(4px); }
        .interactive-card:hover{ filter: none !important; transform: translateY(-6px) scale(1.04); box-shadow: 0 18px 40px rgba(0,0,0,0.12); z-index: 10; }
        @media (prefers-reduced-motion: reduce){ .interactive-card{ transition: none; } }
        .portfolio-modal{ display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 50; align-items: center; justify-content: center; padding: 1rem; }
        .portfolio-modal.active{ display: flex; }
        .portfolio-modal-content{ background: white; border-radius: 1.5rem; max-width: 600px; width: 100%; max-height: 80vh; overflow-y: auto; animation: slideUp .3s ease-out; }
        @keyframes slideUp{ from{ transform: translateY(2rem); opacity: 0; } to{ transform: translateY(0); opacity: 1; } }
        .portfolio-modal-close{ position: absolute; top: 1.5rem; right: 1.5rem; background: white; border: none; width: 2.5rem; height: 2.5rem; border-radius: 9999px; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15); transition: background .18s ease; z-index: 10; }
        .portfolio-modal-close:hover{ background: #f3f4f6; }
        .btn-download{ transition: transform .28s cubic-bezier(.2,.8,.2,1), background .28s ease, color .28s ease, box-shadow .28s ease; }
        .btn-download:hover{ transform: scale(1.08); box-shadow: 0 12px 24px rgba(0,0,0,0.15); }
    </style>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-[#FCF5E6] via-[#FAF8F1] to-white py-20 lg:py-32">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm mb-6 border border-[#FFB3E1]">
                        <svg class="w-4 h-4 text-[#822021]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-600">Partnership & Kolaborasi</span>
                    </div>
                    
                    <h1 class="text-4xl lg:text-5xl xl:text-6xl mb-6 text-[#822021] font-bold">
                        Mari Berkolaborasi Mengembangkan Ekosistem Kreatif
                    </h1>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Bergabunglah dengan kami untuk menciptakan dampak positif bagi komunitas kreatif Indonesia. 
                        Berbagai model kerjasama yang dapat disesuaikan dengan kebutuhan bisnis Anda.
                    </p>
                    
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ asset('storage/proposal-kemitraan.pdf') }}" target="_blank" class="btn-download inline-flex items-center bg-[#822021] text-[#FCF5E6] px-6 py-3 rounded-lg text-base font-semibold">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            Unduh Proposal
                        </a>
                        <a href="https://wa.me/6285871497367" target="_blank" class="btn-download inline-flex items-center border border-gray-300 text-gray-700 px-6 py-3 rounded-lg text-base font-semibold">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                            </svg>
                            Diskusi via WhatsApp
                        </a>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=600&fit=crop" alt="Partnership" class="w-full h-[500px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-20 bg-[#FCF5E6]">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl mb-4 font-bold text-[#822021]">Mengapa Bermitra dengan Kami?</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Dapatkan berbagai keuntungan dari kolaborasi strategis dengan Kreasi Hangat
                </p>
            </div>
            
            <div class="interactive-grid grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="interactive-card border-2 border-[#FFB3E1]/30 hover:border-[#822021] transition-colors rounded-lg bg-white">
                    <div class="p-6">
                        <div class="bg-gradient-to-br from-[#FCF5E6] to-[#FFDEF8] w-14 h-14 rounded-xl flex items-center justify-center mb-4 border border-[#FFB3E1] mx-auto">
                            <svg class="w-7 h-7 text-[#FFB3E1]" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-center font-semibold text-[#822021]">Jangkauan Luas</h3>
                        <p class="text-sm text-gray-600 text-center">2,500+ peserta aktif dan 50+ instruktur expert di berbagai bidang kreatif</p>
                    </div>
                </div>
                
                <div class="interactive-card border-2 border-[#FFB3E1]/30 hover:border-[#822021] transition-colors rounded-lg bg-white">
                    <div class="p-6">
                        <div class="bg-gradient-to-br from-[#FCF5E6] to-[#FFDEF8] w-14 h-14 rounded-xl flex items-center justify-center mb-4 border border-[#FFB3E1] mx-auto">
                            <svg class="w-7 h-7 text-[#FFB3E1]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-center font-semibold text-[#822021]">Track Record Terbukti</h3>
                        <p class="text-sm text-gray-600 text-center">150+ event terselenggara dengan tingkat kepuasan peserta 95%</p>
                    </div>
                </div>
                
                <div class="interactive-card border-2 border-[#FFB3E1]/30 hover:border-[#822021] transition-colors rounded-lg bg-white">
                    <div class="p-6">
                        <div class="bg-gradient-to-br from-[#FCF5E6] to-[#FFDEF8] w-14 h-14 rounded-xl flex items-center justify-center mb-4 border border-[#FFB3E1] mx-auto">
                            <svg class="w-7 h-7 text-[#FFB3E1]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-center font-semibold text-[#822021]">Kualitas Terjamin</h3>
                        <p class="text-sm text-gray-600 text-center">Standar penyelenggaraan workshop profesional dengan fasilitas lengkap</p>
                    </div>
                </div>
                
                <div class="interactive-card border-2 border-[#FFB3E1]/30 hover:border-[#822021] transition-colors rounded-lg bg-white">
                    <div class="p-6">
                        <div class="bg-gradient-to-br from-[#FCF5E6] to-[#FFDEF8] w-14 h-14 rounded-xl flex items-center justify-center mb-4 border border-[#FFB3E1] mx-auto">
                            <svg class="w-7 h-7 text-[#FFB3E1]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-center font-semibold text-[#822021]">Kolaborasi Fleksibel</h3>
                        <p class="text-sm text-gray-600 text-center">Berbagai model kerjasama yang dapat disesuaikan dengan kebutuhan mitra</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Preview Section -->
    <section class="py-20 bg-gradient-to-b from-white to-[#FCF5E6]/30">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl mb-4 font-bold text-[#822021]">Portfolio Terbaik Kami</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Lihat hasil kolaborasi dan event yang telah kami selenggarakan
                </p>
            </div>
            
            <div class="interactive-grid grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse ($featuredPortfolios as $portfolio)
                    <div class="interactive-card group cursor-pointer" onclick="openPortfolioModal(event, '{{ $portfolio->id }}', '{{ addslashes($portfolio->title) }}', '{{ $portfolio->cover_image_url ?? '' }}', '{{ addslashes($portfolio->event?->title ?? 'Program Internal') }}')">
                        <div class="relative overflow-hidden rounded-xl mb-4 aspect-[4/3]">
                            @if ($portfolio->cover_image_url)
                                <img src="{{ $portfolio->cover_image_url }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-[#FCF5E6] flex items-center justify-center">
                                    <span class="text-gray-400">No Image</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                                <div class="text-white">
                                    <p class="text-sm mb-1">{{ $portfolio->event?->title ?? 'Program Internal' }}</p>
                                    <p class="line-clamp-2">{{ Str::limit($portfolio->description, 80) }}</p>
                                </div>
                            </div>
                            <div class="absolute top-3 right-3">
                                <div class="bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs">
                                    {{ date('Y') }}
                                </div>
                            </div>
                        </div>
                        <h3 class="group-hover:text-[#822021] transition-colors text-center font-semibold">{{ $portfolio->title }}</h3>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">Belum ada portfolio yang tersedia</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center">
                <a href="{{ route('portfolio.index') }}" class="inline-flex items-center bg-[#822021] hover:bg-[#822021]/90 text-white px-7 py-3 rounded-lg font-semibold">
                    Jelajahi Semua Portofolio
                </a>
            </div>
        </div>
    </section>

    <!-- Collaboration Models Section -->
    <section class="py-20 bg-[#FCF5E6]">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl mb-4 font-bold text-[#822021]">Model Kolaborasi</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Berbagai pilihan kerjasama yang dapat disesuaikan dengan kebutuhan Anda
                </p>
            </div>
            
            <div class="interactive-grid grid lg:grid-cols-3 gap-8">
                <div class="interactive-card border-2 border-[#FFB3E1]/30 hover:shadow-xl transition-all hover:border-[#822021] rounded-lg bg-white">
                    <div class="p-8">
                        <div class="bg-gradient-to-br from-[#FFB3E1] to-[#FFBE8E] text-white w-10 h-10 rounded-lg flex items-center justify-center mb-4 mx-auto">
                            <span class="font-semibold">1</span>
                        </div>
                        <h3 class="mb-3 text-center font-semibold text-[#822021]">Maximizing Brand Exposure</h3>
                        <p class="text-gray-600 mb-6 text-justify max-w-sm mx-auto">Jadikan lokasi Anda sebagai pusat kreativitas!</p>
                        <div class="space-y-3 text-left">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-[#FFB3E1] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Akses eksklusif untuk penyediaan tempat workshop.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-[#FFB3E1] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Cafe/mall mendapatkan dukungan promosi masif dari channel kami.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-[#FFB3E1] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Opsi integrasi menu khusus cafe/mall dalam paket pendaftaran workshop.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-[#FFB3E1] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Model bisnis transparan (sistem bagi hasil).</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="interactive-card border-2 border-[#FFB3E1]/30 hover:shadow-xl transition-all hover:border-[#822021] rounded-lg bg-white">
                    <div class="p-8">
                        <div class="bg-gradient-to-br from-[#FFB3E1] to-[#FFBE8E] text-white w-10 h-10 rounded-lg flex items-center justify-center mb-4 mx-auto">
                            <span class="font-semibold">2</span>
                        </div>
                        <h3 class="mb-3 text-center font-semibold text-[#822021]">Empowering Expertise</h3>
                        <p class="text-gray-600 mb-6 text-justify max-w-sm mx-auto">Bergabunglah sebagai Tim Instruktur kami!</p>
                        <div class="space-y-3 text-left">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-[#FFB3E1] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Kesempatan untuk memberikan materi berkualitas dan memandu workshop yang diminati.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-[#FFB3E1] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Honorarium yang fleksibel, dapat disepakati melalui sistem bagi hasil atau fee tetap.</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="interactive-card border-2 border-[#FFB3E1]/30 hover:shadow-xl transition-all hover:border-[#822021] rounded-lg bg-white">
                    <div class="p-8">
                        <div class="bg-gradient-to-br from-[#FFB3E1] to-[#FFBE8E] text-white w-10 h-10 rounded-lg flex items-center justify-center mb-4 mx-auto">
                            <span class="font-semibold">3</span>
                        </div>
                        <h3 class="mb-3 text-center font-semibold text-[#822021]">Strategic Promotion & Media Blitz</h3>
                        <p class="text-gray-600 mb-6 text-justify max-w-sm mx-auto">Pastikan acara Anda dilihat oleh ribuan orang!</p>
                        <div class="space-y-3 text-left">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-[#FFB3E1] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Promosi multi-channel melalui media sosial Kreasi Hangat, partner cafe/mall, dan tutor/instruktur.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-[#FFB3E1] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Pembuatan konten teaser dan dokumentasi acara.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-[#FFB3E1] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Kolaborasi strategis dengan media atau influencer untuk meningkatkan jangkauan.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-[#FFB3E1] to-[#FFBE8E]">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl lg:text-4xl mb-4 font-bold text-[#822021]">
                    Tertarik untuk Berkolaborasi?
                </h2>
                <p class="text-lg text-[#822021] mb-8">
                    Hubungi kami untuk mendiskusikan peluang kerjasama yang saling menguntungkan. 
                    Tim kami siap membantu mewujudkan kolaborasi terbaik.
                </p>
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="{{ asset('storage/proposal-kemitraan.pdf') }}" target="_blank" class="btn-download inline-flex items-center bg-[#822021] text-[#FCF5E6] px-8 py-3 rounded-lg font-semibold">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        Unduh Proposal Partnership
                    </a>
                    <a href="https://wa.me/6285871497367" target="_blank" class="btn-download inline-flex items-center bg-white text-[#822021] px-8 py-3 rounded-lg font-semibold">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                        </svg>
                        Hubungi Kami
                        <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>
                <p class="text-sm text-[#822021] mt-6">
                    Email: kreasihangat@gmail.com | WhatsApp: +62 858 7149 7367
                </p>
            </div>
        </div>
    </section>

    <!-- Portfolio Modal -->
    <div id="portfolioModal" class="portfolio-modal" onclick="if(event.target===this)closePortfolioModal()">
        <div class="portfolio-modal-content relative">
            <button class="portfolio-modal-close" onclick="closePortfolioModal()" aria-label="Close modal"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            <div class="aspect-4/3 bg-gray-200 rounded-t-2xl overflow-hidden">
                <img id="portfolioImage" src="" alt="Portfolio image" class="w-full h-full object-cover">
            </div>
            <div class="p-6">
                <span id="portfolioCategory" class="bg-[#FCF5E6] text-[#822021] text-xs font-semibold px-3 py-1 rounded-full inline-block mb-4"></span>
                <h2 id="portfolioTitle" class="text-2xl font-bold text-[#822021]"></h2>
            </div>
        </div>
    </div>

    <script>
        function openPortfolioModal(e,id,title,img,cat){e.stopPropagation();document.getElementById('portfolioImage').src=img||'';document.getElementById('portfolioTitle').textContent=title;document.getElementById('portfolioCategory').textContent=cat;document.getElementById('portfolioModal').classList.add('active');document.body.style.overflow='hidden'}
        function closePortfolioModal(){document.getElementById('portfolioModal').classList.remove('active');document.body.style.overflow='auto'}
        document.addEventListener('keydown',function(e){if(e.key==='Escape'&&document.getElementById('portfolioModal').classList.contains('active'))closePortfolioModal()})
    </script>
</x-layouts.app>