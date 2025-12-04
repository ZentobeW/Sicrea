<x-layouts.app :title="'Tentang Kami'">
    <!-- Hero Section -->
    <section class="py-20 bg-[#FCF5E6] relative">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl lg:text-5xl mb-6 font-bold text-[#822021]">Who is Kreasi Hangat?</h1>
                <p class="text-lg text-gray-600 leading-relaxed mb-8 max-w-3xl mx-auto">
                    Kreasi Hangat adalah platform online yang menghubungkan para pembelajar dengan berbagai 
                    workshop, event, dan kegiatan kreatif. Kami percaya bahwa setiap orang memiliki potensi 
                    kreatif yang dapat dikembangkan melalui pembelajaran yang tepat dan lingkungan yang mendukung.
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
            <!-- Visi dan Misi -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8 max-w-6xl mx-auto mb-12">
                <!-- Visi Card -->
                <div class="md:col-span-2 bg-white rounded-2xl p-8 border-2 border-[#FFB3E1] hover:border-[#FFB3E1] hover:shadow-lg hover:shadow-[#FFB3E1]/30">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="Visi Icon" class="w-16 h-16 object-contain">
                        <h2 class="text-2xl font-bold text-[#822021]">Visi Kami</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Menjadi komunitas kreatif dan inklusif yang memberikan ruang bagi semua individu untuk berekspresi, belajar, dan berkembang melalui berbagai kegiatan seni dan workshop.
                    </p>
                </div>

                <!-- Misi Card -->
                <div class="md:col-span-3 bg-white rounded-2xl p-8 border-2 border-[#FFB3E1] hover:border-[#FFB3E1] hover:shadow-lg hover:shadow-[#FFB3E1]/30">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="Misi Icon" class="w-16 h-16 object-contain">
                        <h2 class="text-2xl font-bold text-[#822021]">Misi Kami</h2>
                    </div>
                    <ul class="list-disc pl-5 text-gray-600 leading-relaxed space-y-2">
                        <li>Menghadirkan <em>workshop</em> kreatif yang inspiratif dan edukatif bagi berbagai kalangan.</li>
                        <li>Membangun komunitas yang mendukung pengembangan keterampilan seni dan kreativitas.</li>
                        <li>Berkolaborasi dengan berbagai pihak untuk menciptakan acara yang bermanfaat dan menarik.</li>
                        <li>Memberikan nilai tambah bagi mitra melalui promosi dan <em>engagement</em> komunitas.</li>
                        <li>Mengembangkan program-program inovatif yang dapat diakses oleh lebih banyak orang.</li>
                    </ul>
                </div>
            </div>

            <!-- Tujuan Card -->
            <div class="max-w-6xl mx-auto">
                <div class="bg-white rounded-2xl p-8 border-2 border-[#FFB3E1] hover:border-[#FFB3E1] hover:shadow-lg hover:shadow-[#FFB3E1]/30">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="Tujuan Icon" class="w-16 h-16 object-contain">
                        <h2 class="text-2xl font-bold text-[#822021]">Tujuan Kami</h2>
                    </div>
                    <ul class="list-disc pl-5 text-gray-600 leading-relaxed space-y-2">
                        <li>Meningkatkan minat dan keterampilan seni serta kreativitas masyarakat.</li>
                        <li>Menyediakan pengalaman workshop yang edukatif dan menyenangkan.</li>
                        <li>Membantu mitra (cafe, mall, dan tutor) mendapatkan exposure dan potensi pelanggan baru.</li>
                        <li>Membangun komunitas kreatif yang aktif dan produktif</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Values
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl mb-4 font-bold text-[#822021]">Tujuan Kami</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Prinsip yang menjadi fondasi dalam setiap kegiatan yang kami selenggarakan
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
                <div class="bg-white border border-[#FFB3E1]/30 rounded-2xl p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-[#FCF5E6] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-[#FFB3E1]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-[#822021]">Fokus pada Kualitas</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Setiap workshop dirancang dengan kurikulum berkualitas dan instruktur berpengalaman
                    </p>
                </div>

                <div class="bg-white border border-[#FFB3E1]/30 rounded-2xl p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-[#FCF5E6] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-[#FFB3E1]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-[#822021]">Lingkungan Supportif</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Menciptakan ruang belajar yang nyaman, ramah, dan mendukung pertumbuhan kreatif
                    </p>
                </div>

                <div class="bg-white border border-[#FFB3E1]/30 rounded-2xl p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-[#FCF5E6] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-[#FFB3E1]" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-[#822021]">Komunitas Kreatif</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Membangun jaringan komunitas yang saling mendukung dan berbagi inspirasi
                    </p>
                </div>

                <div class="bg-white border border-[#FFB3E1]/30 rounded-2xl p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-[#FCF5E6] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-[#FFB3E1]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1zm-3 3a1 1 0 100 2h.01a1 1 0 100-2H10zm-4 1a1 1 0 011-1h.01a1 1 0 110 2H7a1 1 0 01-1-1zm1-4a1 1 0 100 2h.01a1 1 0 100-2H7zm2 0a1 1 0 100 2h.01a1 1 0 100-2H9zm2 0a1 1 0 100 2h.01a1 1 0 100-2H11z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-[#822021]">Pengembangan Berkelanjutan</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Komitmen untuk terus menghadirkan program yang relevan dengan kebutuhan industri
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

            <!-- Desktop Grid -->
            <div class="hidden lg:grid lg:grid-cols-6 gap-6">
                <div class="text-center">
                    <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=300&fit=crop" alt="Adella Marshanda" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-[#822021] mb-1">Adella Marshanda</h3>
                    <p class="text-sm text-gray-500">Founder</p>
                </div>

                <div class="text-center">
                    <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=300&fit=crop" alt="Farkha Mutiara" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-[#822021] mb-1">Farkha Mutiara</h3>
                    <p class="text-sm text-gray-500">Co-Founder</p>
                </div>

                <div class="text-center">
                    <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop" alt="Syehri Reza Dwi A" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-[#822021] mb-1">Syehri Reza Dwi A</h3>
                    <p class="text-sm text-gray-500">Tim Tutor</p>
                </div>

                <div class="text-center">
                    <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=300&fit=crop" alt="Koerunnisa" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-[#822021] mb-1">Koerunnisa</h3>
                    <p class="text-sm text-gray-500">Tim Tutor</p>
                </div>

                <div class="text-center">
                    <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=300&h=300&fit=crop" alt="Syavira" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-[#822021] mb-1">Syavira</h3>
                    <p class="text-sm text-gray-500">Tim Tutor</p>
                </div>

                <div class="text-center">
                    <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=300&fit=crop" alt="Putri Ajeng" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-[#822021] mb-1">Putri Ajeng</h3>
                    <p class="text-sm text-gray-500">Tim Tutor</p>
                </div>
            </div>

            <!-- Mobile Carousel -->
            <div class="lg:hidden">
                <div id="teamCarousel" class="flex overflow-x-auto gap-6 pb-4 px-4" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <div class="min-w-[200px] text-center flex-shrink-0">
                        <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=300&fit=crop" alt="Adella Marshanda" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-[#822021] mb-1">Adella Marshanda</h3>
                        <p class="text-sm text-gray-500">Founder</p>
                    </div>

                    <div class="min-w-[200px] text-center flex-shrink-0">
                        <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=300&fit=crop" alt="Farkha Mutiara" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-[#822021] mb-1">Farkha Mutiara</h3>
                        <p class="text-sm text-gray-500">Co-Founder</p>
                    </div>

                    <div class="min-w-[200px] text-center flex-shrink-0">
                        <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop" alt="Syehri Reza Dwi A" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-[#822021] mb-1">Syehri Reza Dwi A</h3>
                        <p class="text-sm text-gray-500">Tim Tutor</p>
                    </div>

                    <div class="min-w-[200px] text-center flex-shrink-0">
                        <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=300&fit=crop" alt="Koerunnisa" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-[#822021] mb-1">Koerunnisa</h3>
                        <p class="text-sm text-gray-500">Tim Tutor</p>
                    </div>

                    <div class="min-w-[200px] text-center flex-shrink-0">
                        <div class="relative mb-4 overflow-hidden rounded-2xl aspect-square">
                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=300&h=300&fit=crop" alt="Syavira" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-[#822021] mb-1">Syavira</h3>
                        <p class="text-sm text-gray-500">Tim Tutor</p>
                    </div>

                    <div class="min-w-[200px] text-center flex-shrink-0">
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
    <section class="bg-gradient-to-r from-[#FFBE8E] to-[#FCF5E6]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <div class="mx-auto space-y-4">
                <h2 class="text-3xl font-['Cousine'] font-bold text-[#822021]">Hubungi Kami</h2>
                <p class="text-base font-['Open_Sans'] text-[#46000D] max-w-xl mx-auto">Punya pertanyaan atau ingin tahu lebih lanjut? Kami siap membantu!</p>
                <div class="flex flex-wrap justify-center gap-4 pt-2">
                    <a href="https://wa.me/6285871497367" target="_blank" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-7 py-3 text-sm font-['Open_Sans'] font-semibold text-[#FAF8F1] shadow-sm shadow-[#822021]/40 transition hover:bg-[#5c261d]">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.516"/>
                        </svg>
                        WhatsApp
                    </a>
                    <a href="mailto:kreasihangat@gmail.com" class="inline-flex items-center gap-2 rounded-full bg-[#FAF8F1] border border-[#FFBE8E] px-7 py-3 text-sm font-['Open_Sans'] font-semibold text-[#822021] shadow-sm shadow-[#FFBE8E]/40 transition hover:bg-white transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        Email
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
                const scrollLeft = carousel.scrollLeft;
                const scrollWidth = carousel.scrollWidth;
                const clientWidth = carousel.clientWidth;
                const itemWidth = 224; 
                
                let currentIndex;
                
                // Check if at the end
                if (scrollLeft + clientWidth >= scrollWidth - 10) {
                    currentIndex = dots.length - 1;
                } else {
                    currentIndex = Math.round(scrollLeft / itemWidth);
                    currentIndex = Math.min(currentIndex, dots.length - 1);
                }
                
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