@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="'Kemitraan Sicrea'">
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
                        <a href="https://wa.me/6285871497367" target="_blank" class="inline-flex items-center border border-gray-300 hover:border-gray-400 text-gray-700 px-6 py-3 rounded-full text-base font-semibold bg-white">
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

    <!-- Plan Section -->
    <section class="py-20 bg-[#FCF5E6]">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl mb-4 font-bold text-[#822021]">Rencana Kegiatan Kami</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Dapatkan gambaran rencana kegiatan kolaborasi strategis dengan Kreasi Hangat
                </p>
            </div>
            
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="border-2 border-[#FFB3E1] hover:border-[#FFB3E1] hover:shadow-lg hover:shadow-[#FFB3E1]/30 transition-all rounded-[24px] bg-white">
                    <div class="p-6">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-4 mx-auto">
                            <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="plan Icon" class="w-14 h-14 object-contain">
                        </div>
                        <h3 class="mb-2 text-center font-semibold text-[#822021]">Tempat</h3>
                        <p class="text-sm text-gray-600 text-center">Bisa diadakan di café, mall, atau studio yang bekerja sama.</p>
                    </div>
                </div>
                
                <div class="border-2 border-[#FFB3E1] hover:border-[#FFB3E1] hover:shadow-lg hover:shadow-[#FFB3E1]/30 transition-all rounded-[24px] bg-white">
                    <div class="p-6">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-4 mx-auto">
                            <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="plan Icon" class="w-14 h-14 object-contain">
                        </div>
                        <h3 class="mb-2 text-center font-semibold text-[#822021]">Durasi</h3>
                        <p class="text-sm text-gray-600 text-center">2 - 3 jam per sesi</p>
                    </div>
                </div>
                
                <div class="border-2 border-[#FFB3E1] hover:border-[#FFB3E1] hover:shadow-lg hover:shadow-[#FFB3E1]/30 transition-all rounded-[24px] bg-white">
                    <div class="p-6">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-4 mx-auto">
                            <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="plan Icon" class="w-14 h-14 object-contain">
                        </div>
                        <h3 class="mb-2 text-center font-semibold text-[#822021]">Jumlah Peserta</h3>
                        <p class="text-sm text-gray-600 text-center">10 - 20 orang per workshop (dapat disesuaikan).</p>
                    </div>
                </div>
                
                <div class="border-2 border-[#FFB3E1] hover:border-[#FFB3E1] hover:shadow-lg hover:shadow-[#FFB3E1]/30 transition-all rounded-[24px] bg-white">
                    <div class="p-6">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-4 mx-auto">
                            <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="plan Icon" class="w-14 h-14 object-contain">
                        </div>
                        <h3 class="mb-2 text-center font-semibold text-[#822021]">Peralatan dan Material </h3>
                        <p class="text-sm text-gray-600 text-center">Disediakan oleh <em>Kreasi Hangat</em> atau dapat bekerja sama dengan mitra.</p>
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
            
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse ($featuredPortfolios as $portfolio)
                    <div class="group cursor-pointer">
                        <div class="relative overflow-hidden rounded-2xl shadow-md mb-4 aspect-[4/3] transition-transform duration-300 hover:scale-105">
                            @if ($portfolio->cover_image_url)
                                <img src="{{ $portfolio->cover_image_url }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
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
                <a href="{{ route('portfolio.index') }}" class="inline-flex items-center bg-[#822021] hover:bg-[#822021]/90 text-white px-7 py-3 rounded-full font-semibold">
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
            
            <div class="grid lg:grid-cols-3 gap-8">
                <div class="border-2 border-[#FFB3E1] hover:border-[#FFB3E1] hover:shadow-lg hover:shadow-[#FFB3E1]/30 transition-all rounded-[24px] bg-white">
                    <div class="p-8">
                        <div class="bg-gradient-to-br from-[#FFB3E1] to-[#FFBE8E] text-white w-10 h-10 rounded-[24px] flex items-center justify-center mb-4 mx-auto">
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
                
                <div class="border-2 border-[#FFB3E1] hover:border-[#FFB3E1] hover:shadow-lg hover:shadow-[#FFB3E1]/30 transition-all rounded-[24px] bg-white">
                    <div class="p-8">
                        <div class="bg-gradient-to-br from-[#FFB3E1] to-[#FFBE8E] text-white w-10 h-10 rounded-[24px] flex items-center justify-center mb-4 mx-auto">
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
                
                <div class="border-2 border-[#FFB3E1] hover:border-[#FFB3E1] hover:shadow-lg hover:shadow-[#FFB3E1]/30 transition-all rounded-[24px] bg-white">
                    <div class="p-8">
                        <div class="bg-gradient-to-br from-[#FFB3E1] to-[#FFBE8E] text-white w-10 h-10 rounded-[24px] flex items-center justify-center mb-4 mx-auto">
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

    <section class="bg-gradient-to-r from-[#FFBE8E] to-[#FCF5E6]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <div class="mx-auto space-y-4">
                <h2 class="text-3xl font-['Cousine'] font-bold text-[#822021]">Tertarik untuk Berkolaborasi?</h2>
                <p class="text-base font-['Open_Sans'] text-[#46000D] max-w-xl mx-auto">Hubungi kami untuk mendiskusikan peluang kerjasama yang saling menguntungkan. 
                    Tim kami siap membantu mewujudkan kolaborasi terbaik.</p>
                <div class="flex flex-wrap justify-center gap-4 pt-2">
                    <a href="https://wa.me/6285871497367" target="_blank" class="inline-flex items-center rounded-full bg-[#FAF8F1] border border-[#FFBE8E] px-7 py-3 text-sm font-['Open_Sans'] font-semibold text-[#822021] shadow-sm shadow-[#FFBE8E]/40 transition hover:bg-white transition">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>