<x-layouts.app :title="'About Us'">
    <style>
    /* --- Contact Button Styles --- */
        .contact-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
            padding: 0.8em 1.5em;
            border-radius: 1em;
            background: #FFFFFF;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease-in;
            cursor: pointer;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            height: 80px;
            border: 2px solid transparent;
        }

        .contact-btn .btn-text {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            text-align: left;
            transition: all 0.3s ease-in-out;
            opacity: 1;
            transform: translateX(0);
            z-index: 2; /* Pastikan text di atas background */
        }

        .contact-btn .btn-label {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 2px;
            color: var(--text-color);
        }

        .contact-btn .btn-value {
            font-size: 1rem;
            font-weight: 500;
            color: #555;
        }

        /* --- Style Gambar Logo (IMG) --- */
        .contact-btn .btn-icon {
            height: 38px; /* Ukuran Logo */
            width: 38px;
            object-fit: contain;
            position: absolute;
            right: 24px;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 2; /* Pastikan logo di atas background */
        }

        /* --- Brand Colors --- */
        .contact-btn.whatsapp {
            --text-color: #25D366;
        }

        .contact-btn.email {
            --text-color: #EA4335;
        }

        /* --- Hover Animations --- */
        
        /* 1. Text menghilang ke kiri */
        .contact-btn:hover .btn-text {
            opacity: 0;
            transform: translateX(-30px);
        }
        
        /* 2. Logo bergerak ke tengah & JADI PUTIH */
        .contact-btn:hover .btn-icon {
            right: 50%;
            transform: translateX(50%) scale(1.4); /* Perbesar sedikit */
            
            /* MAGIC TRICK: Ubah logo jadi putih solid saat hover */
            /* filter: brightness(0) invert(1);  */
        }

        /* 3. Liquid Background Effect */
        .contact-btn:before {
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
            z-index: 0;
        }

        .contact-btn:after {
            content: "";
            position: absolute;
            left: 55%;
            transform: translateX(-50%) scaleY(1) scaleX(1.45);
            top: 180%;
            width: 160%;
            height: 190%;
            background-color: var(--hover-color);
            border-radius: 50%;
            display: block;
            transition: all 0.5s 0.1s cubic-bezier(0.55, 0, 0.1, 1);
            z-index: 0;
        }

        .contact-btn:hover:before {
            top: -35%;
            background-color: var(--hover-color);
            transform: translateX(-50%) scaleY(1.3) scaleX(0.8);
        }

        .contact-btn:hover:after {
            top: -45%;
            background-color: var(--hover-color);
            transform: translateX(-50%) scaleY(1.3) scaleX(0.8);
        }
    </style>
    <!-- Hero Section -->
    <section class="py-20 bg-[#FCF5E6] relative">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl lg:text-5xl mb-6 font-bold text-[#822021]">Siapa Kreasi Hangat?</h1>
                <p class="text-lg text-gray-600 leading-relaxed mb-8 max-w-3xl mx-auto">
                    Kreasi Hangat hadir sebagai komunitas yang bergerak di bidang creative class dan workshop, dengan fokus pada kegiatan yang mengembangkan kreativitas serta memberikan pengalaman seni yang menyenangkan.
                    Workshop Kreasi Hangat dirancang untuk semua kalangan, baik pemula maupun yang sudah berpengalaman. 
                    Kegiatan ini tidak hanya bertujuan untuk  memberikan pengalaman seni yang interaktif dan menyenangkan, tetapi juga untuk membuka peluang usaha bagi para peserta. 
                    Dengan adanya Workshop Kreasi Hangat, diharapkan dapat lahir pengrajin-pengrajin baru yang berkontribusi dalam melestarikan budaya serta meningkatkan perekonomian kreatif di Indonesia
                </p>
                <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1758522274463-67ef9e5e88b1?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxhcnQlMjBjbGFzcyUyMGNvbW11bml0eXxlbnwxfHx8fDE3NTkyOTE1MTl8MA&ixlib=rb-4.1.0&q=80&w=1080" alt="About Kreasi Hangat" class="w-full h-96 object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-20 bg-[#FCF5E6]">
        <div class="container mx-auto px-4 lg:px-8">
            
            <div class="interactive-grid grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">
                
                <div class="interactive-card bg-white rounded-2xl p-8 border-2 border-[#FFB3E1] hover:border-[#FFB3E1] hover:shadow-lg hover:shadow-[#FFB3E1]/30 h-full flex flex-col transition-all duration-300">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="Visi Icon" class="w-16 h-16 object-contain">
                        <h2 class="text-2xl font-bold text-[#822021]">Visi Kami</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed flex-grow">
                        Menjadi komunitas kreatif dan inklusif yang memberikan ruang bagi semua individu untuk berekspresi, belajar, dan berkembang melalui berbagai kegiatan seni dan workshop.
                    </p>
                </div>

                <div class="interactive-card bg-white rounded-2xl p-8 border-2 border-[#FFB3E1] hover:border-[#FFB3E1] hover:shadow-lg hover:shadow-[#FFB3E1]/30 h-full flex flex-col transition-all duration-300">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="Misi Icon" class="w-16 h-16 object-contain">
                        <h2 class="text-2xl font-bold text-[#822021]">Misi Kami</h2>
                    </div>
                    <ul class="list-disc pl-5 text-gray-600 leading-relaxed space-y-2 flex-grow">
                        <li>Menghadirkan <em>workshop</em> kreatif yang inspiratif dan edukatif.</li>
                        <li>Membangun komunitas yang mendukung pengembangan keterampilan seni.</li>
                        <li>Berkolaborasi dengan berbagai pihak untuk acara bermanfaat.</li>
                        <li>Memberikan nilai tambah bagi mitra melalui promosi.</li>
                        <li>Mengembangkan program inovatif yang inklusif.</li>
                    </ul>
                </div>

                <div class="interactive-card bg-white rounded-2xl p-8 border-2 border-[#FFB3E1] hover:border-[#FFB3E1] hover:shadow-lg hover:shadow-[#FFB3E1]/30 h-full flex flex-col transition-all duration-300">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="Tujuan Icon" class="w-16 h-16 object-contain">
                        <h2 class="text-2xl font-bold text-[#822021]">Tujuan Kami</h2>
                    </div>
                    <ul class="list-disc pl-5 text-gray-600 leading-relaxed space-y-2 flex-grow">
                        <li>Meningkatkan minat dan keterampilan seni serta kreativitas masyarakat.</li>
                        <li>Menyediakan pengalaman workshop yang edukatif & menyenangkan.</li>
                        <li>Membantu mitra (cafe, mall, dan tutor) mendapatkan exposure dan potensi pelanggan baru.</li>
                        <li>Membangun komunitas kreatif yang aktif dan produktif.</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- Values -->
    <style>
        /* Interactive hover for value cards: hovered card zooms, siblings blur */
        .values-grid{ position: relative; }
        .value-card{ transition: transform .28s cubic-bezier(.2,.8,.2,1), filter .28s ease, box-shadow .28s ease; will-change: transform, filter; }
        .values-grid:hover .value-card{ filter: blur(4px); }
        .value-card:hover{ filter: none !important; transform: translateY(-6px) scale(1.04); box-shadow: 0 18px 40px rgba(0,0,0,0.12); z-index: 10; }

        /* Generic interactive grid/card (for Visi/Misi and Team) */
        .interactive-grid{ position: relative; }
        .interactive-card{ transition: transform .28s cubic-bezier(.2,.8,.2,1), filter .28s ease, box-shadow .28s ease; will-change: transform, filter; }
        .interactive-grid:hover .interactive-card{ filter: blur(4px); }
        .interactive-card:hover{ filter: none !important; transform: translateY(-6px) scale(1.04); box-shadow: 0 18px 40px rgba(0,0,0,0.12); z-index: 10; }

        @media (prefers-reduced-motion: reduce){ .value-card, .interactive-card{ transition: none; } }
    </style>
    <!-- <section class="py-20 bg-[#FFDEF8]">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl mb-4 font-bold text-[#822021]">Our Values</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Prinsip yang menjadi fondasi dalam setiap kegiatan yang kami selenggarakan
                </p>
            </div>
            <div class="values-grid grid sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
                <div class="value-card bg-white border border-[#FFB3E1]/70 rounded-2xl p-6 text-center hover:shadow-lg">
                    <div class="w-16 h-16 bg-[#FCF5E6] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-[#820221]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-[#822021]">Fokus pada Kualitas</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Setiap workshop dirancang dengan kurikulum berkualitas dan instruktur berpengalaman
                    </p>
                </div>
                <div class="value-card bg-white border border-[#FFB3E1]/70 rounded-2xl p-6 text-center hover:shadow-lg">
                    <div class="w-16 h-16 bg-[#FCF5E6] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-[#820221]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-[#822021]">Lingkungan Supportif</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Menciptakan ruang belajar yang nyaman, ramah, dan mendukung pertumbuhan kreatif
                    </p>
                </div>
                <div class="value-card bg-white border border-[#FFB3E1]/70 rounded-2xl p-6 text-center hover:shadow-lg">
                    <div class="w-16 h-16 bg-[#FCF5E6] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-[#820221]" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-[#822021]">Komunitas Kreatif</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Membangun jaringan komunitas yang saling mendukung dan berbagi inspirasi
                    </p>
                </div>
                <div class="value-card bg-white border border-[#FFB3E1]/70 rounded-2xl p-6 text-center hover:shadow-lg">
                    <div class="w-16 h-16 bg-[#FCF5E6] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-[#820221]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1zm-3 3a1 1 0 100 2h.01a1 1 0 100-2H10zm-4 1a1 1 0 011-1h.01a1 1 0 110 2H7a1 1 0 01-1-1zm1-4a1 1 0 100 2h.01a1 1 0 100-2H7zm2 0a1 1 0 100 2h.01a1 1 0 100-2H9zm2 0a1 1 0 100 2h.01a1 1 0 100-2H11z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-[#822021]">Pengembangan Berkelanjutan</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Komitmen untuk terus menghadirkan program yang relevan trend terkini
                    </p>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Team Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl mb-4 font-bold text-[#822021]">Tim Kami</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Para ahli berpengalaman yang siap membimbing perjalanan kreatif Anda
                </p>
            </div>

            <!-- Desktop Grid (6 columns) -->
            <div class="interactive-grid hidden lg:grid lg:grid-cols-6 gap-6">
                <div class="interactive-card text-center">
                    <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=300&fit=crop" alt="Adella Marshanda" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-[#822021] mb-1">Adella Marshanda</h3>
                    <p class="text-sm text-gray-500">Founder</p>
                </div>

                <div class="interactive-card text-center">
                    <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=300&fit=crop" alt="Farkha Mutiara" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-[#822021] mb-1">Farkha Mutiara</h3>
                    <p class="text-sm text-gray-500">Co-Founder</p>
                </div>

                <div class="interactive-card text-center">
                    <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop" alt="Syehri Reza Dwi A" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-[#822021] mb-1">Syehri Reza Dwi A</h3>
                    <p class="text-sm text-gray-500">Tim Tutor</p>
                </div>

                <div class="interactive-card text-center">
                    <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=300&fit=crop" alt="Koerunnisa" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-[#822021] mb-1">Koerunnisa</h3>
                    <p class="text-sm text-gray-500">Tim Tutor</p>
                </div>

                <div class="interactive-card text-center">
                    <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=300&h=300&fit=crop" alt="Syavira" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-[#822021] mb-1">Syavira</h3>
                    <p class="text-sm text-gray-500">Tim Tutor</p>
                </div>

                <div class="interactive-card text-center">
                    <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=300&fit=crop" alt="Putri Ajeng" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-[#822021] mb-1">Putri Ajeng</h3>
                    <p class="text-sm text-gray-500">Tim Tutor</p>
                </div>
            </div>

            <!-- Mobile Carousel -->
            <div class="lg:hidden relative">
                <div id="teamCarousel" class="flex overflow-x-auto gap-6 pb-4 px-4" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <div class="min-w-[200px] text-center flex-shrink-0 interactive-card">
                        <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=300&fit=crop" alt="Adella Marshanda" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-[#822021] mb-1">Adella Marshanda</h3>
                        <p class="text-sm text-gray-500">Founder</p>
                    </div>

                    <div class="min-w-[200px] text-center flex-shrink-0 interactive-card">
                        <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=300&fit=crop" alt="Farkha Mutiara" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-[#822021] mb-1">Farkha Mutiara</h3>
                        <p class="text-sm text-gray-500">Co-Founder</p>
                    </div>

                    <div class="min-w-[200px] text-center flex-shrink-0 interactive-card">
                        <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop" alt="Syehri Reza Dwi A" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-[#822021] mb-1">Syehri Reza Dwi A</h3>
                        <p class="text-sm text-gray-500">Tim Tutor</p>
                    </div>

                    <div class="min-w-[200px] text-center flex-shrink-0 interactive-card">
                        <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=300&fit=crop" alt="Koerunnisa" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-[#822021] mb-1">Koerunnisa</h3>
                        <p class="text-sm text-gray-500">Tim Tutor</p>
                    </div>

                    <div class="min-w-[200px] text-center flex-shrink-0 interactive-card">
                        <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=300&h=300&fit=crop" alt="Syavira" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-[#822021] mb-1">Syavira</h3>
                        <p class="text-sm text-gray-500">Tim Tutor</p>
                    </div>

                    <div class="min-w-[200px] text-center flex-shrink-0 interactive-card">
                        <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=300&fit=crop" alt="Putri Ajeng" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-[#822021] mb-1">Putri Ajeng</h3>
                        <p class="text-sm text-gray-500">Tim Tutor</p>
                    </div>
                </div>
                
                <!-- Dot Indicators -->
                <div class="flex justify-center gap-2 mt-4">
                    <div class="carousel-dot w-2 h-2 rounded-full bg-[#822021] transition-colors duration-300" data-index="0"></div>
                    <div class="carousel-dot w-2 h-2 rounded-full bg-gray-300 transition-colors duration-300" data-index="1"></div>
                    <div class="carousel-dot w-2 h-2 rounded-full bg-gray-300 transition-colors duration-300" data-index="2"></div>
                    <div class="carousel-dot w-2 h-2 rounded-full bg-gray-300 transition-colors duration-300" data-index="3"></div>
                    <div class="carousel-dot w-2 h-2 rounded-full bg-gray-300 transition-colors duration-300" data-index="4"></div>
                    <div class="carousel-dot w-2 h-2 rounded-full bg-gray-300 transition-colors duration-300" data-index="5"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-20 bg-gradient-to-br from-[#FFB3E1] to-[#FFBE8E] text-white">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl lg:text-4xl mb-4 font-bold text-[#822021]">Kontak Kami</h2>
                <p class="text-lg mb-12 text-[#822021]">
                    Punya pertanyaan atau ingin tahu lebih lanjut? Kami siap membantumu.
                </p>

                <div class="grid sm:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    
                    <a href="https://wa.me/6285871497367" target="_blank" class="contact-btn whatsapp">
                        <div class="btn-text">
                            <span class="btn-label">WhatsApp</span>
                            <span class="btn-value">+62 858 7149 7367</span>
                        </div>
                        <img src="https://img.icons8.com/color/48/whatsapp--v1.png" alt="WhatsApp" class="btn-icon">
                    </a>

                    <a href="mailto:kreasihangat@gmail.com" class="contact-btn email">
                        <div class="btn-text">
                            <span class="btn-label">Email</span>
                            <span class="btn-value">kreasihangat@gmail.com</span>
                        </div>
                        <img src="https://img.icons8.com/color/50/gmail-new.png" alt="Gmail" class="btn-icon">
                    </a>

                </div>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('teamCarousel');
        const dots = document.querySelectorAll('.carousel-dot');
        
        if (carousel && dots.length > 0) {
            carousel.addEventListener('scroll', function() {
                const items = carousel.querySelectorAll('.interactive-card');
                let currentIndex = 0;
                let minDistance = Infinity;
                
                items.forEach((item, index) => {
                    const itemLeft = item.offsetLeft;
                    const distance = Math.abs(carousel.scrollLeft - itemLeft);
                    if (distance < minDistance) {
                        minDistance = distance;
                        currentIndex = index;
                    }
                });
                
                dots.forEach((dot, index) => {
                    if (index === currentIndex) {
                        dot.classList.remove('bg-gray-300');
                        dot.classList.add('bg-[#822021]');
                    } else {
                        dot.classList.remove('bg-[#822021]');
                        dot.classList.add('bg-gray-300');
                    }
                });
            });
        }
    });
    </script>
</x-layouts.app>