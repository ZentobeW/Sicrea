@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="'Partnership Sicrea'">
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

        /* --- Tambahan CSS untuk Typewriter Effect --- */
        .typing-cursor::after {
            content: '|';
            animation: blink 1s step-end infinite;
            color: #822021;
        }
        
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        /* --- Animated Download Button Styles --- */
        .btn-anim {
            text-decoration: none;
            color: #822021; /* Warna Text Awal (Krem) */
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: inherit;
            font-weight: 600;
            border-radius: 0.5rem; /* rounded-lg */
            border: 2px solid #822021; /* Border Merah */
            padding: 12px 24px; /* Sesuaikan padding */
            overflow: hidden;
            position: relative;
            transition: all .3s ease;
            background: transparent; /* Background transparan, warna diisi oleh ::before */
        }

        .btn-anim:hover {
            background-color: #822021;
            color: #FCF5E6; /* Warna Text saat Hover (Merah) */
        }

        /* Pseudo-element untuk Background Merah */
        .btn-anim::before {
            position: absolute;
            content: "";
            z-index: 0;
            background-color: #FFB3E1; /* Warna Fill (Merah) */
            left: -5px;
            right: -5px;
            bottom: -5px;
            height: 115%; /* Menutupi seluruh tombol awalnya */
            transition: all .3s ease;
        }

        /* Saat Hover, background menyusut ke bawah */
        .btn-anim:hover::before {
            height: 0%; /* Menghilang ke bawah (atau ganti 10% jika ingin sisa garis) */
        }

        /* Wrapper untuk konten (Text & Icon) agar tetap di atas background */
        .btn-anim span {
            position: relative;
            z-index: 2;
            transition: all .3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem; /* Jarak icon dan text */
        }

        /* --- New Liquid Button Styles (Revisi) --- */
        .btn-liquid {
            display: inline-flex;
            align-items: center; /* Vertikal center text */
            transition: all 0.2s ease-in;
            position: relative;
            overflow: hidden;
            z-index: 1;
            color: #090909;
            padding: 0.7em 3.3em 0.7em 1.7em; /* Padding kanan besar untuk Icon */
            font-size: 16px; /* Disesuaikan agar tidak terlalu besar */
            font-weight: 600;
            border-radius: 0.5em;
            background: #FAF8F1;
            border: 1px solid #e8e8e8;
            box-shadow: 6px 6px 12px #c5c5c5, -6px -6px 12px #ffffff;
            text-decoration: none;
            cursor: pointer;
        }

        /* SVG Icon Positioning */
        .btn-liquid > svg {
            height: 24px; /* Ukuran icon disesuaikan */
            width: 24px;
            position: absolute;
            right: 15px; /* Posisi di kanan */
            margin-top: 0; /* Reset margin top */
        }

        .btn-liquid:active {
            color: #666;
            box-shadow: inset 4px 4px 12px #c5c5c5, inset -4px -4px 12px #ffffff;
        }

        .btn-liquid:before {
            content: "";
            position: absolute;
            left: 50%;
            transform: translateX(-50%) scaleY(1) scaleX(1.25);
            top: 100%;
            width: 140%;
            height: 180%;
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 50%;
            display: block;
            transition: all 0.5s 0.1s cubic-bezier(0.55, 0, 0.1, 1);
            z-index: -1;
        }

        .btn-liquid:after {
            content: "";
            position: absolute;
            left: 55%;
            transform: translateX(-50%) scaleY(1) scaleX(1.45);
            top: 180%;
            width: 160%;
            height: 190%;
            background-color: #009087; /* Warna Fill Hover (Merah Site) */
            border-radius: 50%;
            display: block;
            transition: all 0.5s 0.1s cubic-bezier(0.55, 0, 0.1, 1);
            z-index: -1;
        }

        .btn-liquid:hover {
            color: #FAF8F1;
            border: 1px solid #009087; /* Border Hover (Merah Site) */
        }

        .btn-liquid:hover:before {
            top: -35%;
            background-color: #009087;
            transform: translateX(-50%) scaleY(1.3) scaleX(0.8);
        }

        .btn-liquid:hover:after {
            top: -45%;
            background-color: #009087;
            transform: translateX(-50%) scaleY(1.3) scaleX(0.8);
        }

    </style>

    <section class="relative bg-gradient-to-br from-[#FFB3E1] via-[#FFDEF8] to-[#FAF8F1] py-20 lg:py-32">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm mb-6 border border-[#FFB3E1]">
                        <svg class="w-4 h-4 text-[#822021]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-600">Partnership & Kolaborasi</span>
                    </div>
                    
                    <h1 id="typewriter-text" class="text-4xl lg:text-5xl xl:text-6xl mb-6 text-[#822021] font-bold typing-cursor min-h-[1.2em] lg:min-h-[2.4em]">
                        </h1>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Bergabunglah dengan kami untuk menciptakan dampak positif bagi komunitas kreatif Indonesia. 
                        Berbagai model kerjasama yang dapat disesuaikan dengan kebutuhan bisnis Anda.
                    </p>
                    
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ asset('storage/proposal-kemitraan.pdf') }}" target="_blank" class="btn-anim text-base">
                            <span>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                Unduh Proposal
                            </span>
                        </a>

                        <a href="https://wa.me/6285871497367" target="_blank" class="btn-liquid">
                            Diskusi via WhatsApp
                            <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z" fill="#fff"></path>
                                <path d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z" fill="#fff"></path>
                                <path d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z" fill="#cfd8dc"></path>
                                <path d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z" fill="#40c351"></path>
                                <path clip-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" fill-rule="evenodd" fill="#fff"></path>
                            </svg>
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

    <section class="py-20 bg-[#FCF5E6]">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl mb-4 font-bold text-[#822021]">Rencana Kegiatan Kami</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Dapatkan gambaran rencana kegiatan kolaborasi strategis dengan Kreasi Hangat
                </p>
            </div>
            
            <div class="interactive-grid grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="interactive-card border-2 border-[#FFB3E1]/30 hover:border-[#822021] transition-colors rounded-lg bg-white">
                    <div class="p-6">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-4 mx-auto">
                            <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="plan Icon" class="w-14 h-14 object-contain">
                        </div>
                        <h3 class="mb-2 text-center font-semibold text-[#822021]">Tempat</h3>
                        <p class="text-sm text-gray-600 text-center">Bisa diadakan di café, mall, atau studio yang bekerja sama.</p>
                    </div>
                </div>
                
                <div class="interactive-card border-2 border-[#FFB3E1]/30 hover:border-[#822021] transition-colors rounded-lg bg-white">
                    <div class="p-6">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-4 mx-auto">
                            <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="plan Icon" class="w-14 h-14 object-contain">
                        </div>
                        <h3 class="mb-2 text-center font-semibold text-[#822021]">Durasi</h3>
                        <p class="text-sm text-gray-600 text-center">2 - 3 jam per sesi</p>
                    </div>
                </div>
                
                <div class="interactive-card border-2 border-[#FFB3E1]/30 hover:border-[#822021] transition-colors rounded-lg bg-white">
                    <div class="p-6">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-4 mx-auto">
                            <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="plan Icon" class="w-14 h-14 object-contain">
                        </div>
                        <h3 class="mb-2 text-center font-semibold text-[#822021]">Jumlah Peserta</h3>
                        <p class="text-sm text-gray-600 text-center">10 - 20 orang per workshop (dapat disesuaikan).</p>
                    </div>
                </div>
                
                <div class="interactive-card border-2 border-[#FFB3E1]/30 hover:border-[#822021] transition-colors rounded-lg bg-white">
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

    <section class="py-20 bg-[#FFDEF8]">
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
                
                <div class="interactive-card border-2 border-[#FFB3E1]/30 hover:shadow-xl transition-all hover:border-[#822021] rounded-lg bg-white">
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
                
                <div class="interactive-card border-2 border-[#FFB3E1]/30 hover:shadow-xl transition-all hover:border-[#822021] rounded-lg bg-white">
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
                    
                    <a href="{{ asset('storage/proposal-kemitraan.pdf') }}" target="_blank" class="btn-anim text-lg">
                        <span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            Unduh Proposal Partnership
                        </span>
                    </a>

                    <a href="https://wa.me/6285871497367" target="_blank" class="btn-liquid">
                        Hubungi Kami
                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" fill="#090909"/>
                        </svg>
                    </a>
                </div>
                <p class="text-sm text-[#822021] mt-6">
                    Email: kreasihangat@gmail.com | WhatsApp: +62 858 7149 7367
                </p>
            </div>
        </div>
    </section>

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

        // --- TYPEWRITER EFFECT SCRIPT ---
        document.addEventListener('DOMContentLoaded', function() {
            const text = "Mari Berkolaborasi Mengembangkan Ekosistem Kreatif";
            const element = document.getElementById('typewriter-text');
            const speed = 90; // Kecepatan (semakin kecil semakin cepat)
            let i = 0;

            function typeWriter() {
                if (i < text.length) {
                    element.textContent += text.charAt(i);
                    i++;
                    setTimeout(typeWriter, speed);
                }
            }

            // Memulai efek pengetikan
            typeWriter();
        });
    </script>
</x-layouts.app>