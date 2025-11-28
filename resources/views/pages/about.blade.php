<x-layouts.app :title="'Tentang Kami'">
    <!-- Hero Section -->
    <section class="py-20 bg-[#FCF5E6] relative">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl lg:text-5xl mb-6 font-bold text-[#822021]">Tentang Kreasi Hangat</h1>
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
            <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
                <!-- Visi Card -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="{{ asset('images/Konsep Desain KH - 8.png') }}" alt="Visi Icon" class="w-16 h-16 object-contain">
                        <h2 class="text-2xl font-bold text-[#822021]">Visi Kami</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Menjadi komunitas kreatif dan inklusif yang memberikan ruang bagi semua individu untuk berekspresi, belajar, dan berkembang melalui berbagai kegiatan seni dan workshop.
                    </p>
                </div>

                <!-- Misi Card -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
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
        </div>
    </section>

    <!-- Values -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl mb-4 font-bold text-[#822021]">Nilai-Nilai Kami</h2>
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
    </section>

    <!-- Team Section -->
    <section class="py-20 bg-[#FCF5E6]">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl mb-4 font-bold text-[#822021]">Tim Kami</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Para ahli berpengalaman yang siap membimbing perjalanan kreatif Anda
                </p>
            </div>

            <!-- Desktop Grid (6 columns) -->
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
            <div class="lg:hidden relative">
                <button class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white text-[#822021] p-3 rounded-full shadow-lg border border-[#FFB3E1]">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </button>

                <div class="flex overflow-x-auto gap-6 pb-4 px-12" style="scrollbar-width: none; -ms-overflow-style: none;">
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

                <button class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white text-[#822021] p-3 rounded-full shadow-lg border border-[#FFB3E1]">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-20 bg-gradient-to-br from-[#FFB3E1] to-[#FFBE8E] text-white">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl lg:text-4xl mb-4 font-bold">Hubungi Kami</h2>
                <p class="text-lg mb-12 text-white/90">
                    Punya pertanyaan atau ingin tahu lebih lanjut? Kami siap membantu!
                </p>

                <div class="grid sm:grid-cols-2 gap-6">
                    <!-- <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                        <svg class="w-8 h-8 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        <h4 class="mb-2 font-semibold">Alamat</h4>
                        <p class="text-sm text-white/80">
                            Jl. Kreatif No. 123<br>Jakarta Selatan 12345
                        </p>
                    </div> -->

                    <a href="https://wa.me/6281234567890" target="_blank" class="bg-white/30 backdrop-blur-sm rounded-2xl p-6 border border-white/20 block hover:bg-white/40 transition-colors">
                        <svg class="w-8 h-8 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        <h4 class="mb-2 font-semibold">WhatsApp</h4>
                        <p class="text-sm text-white/80">
                            +62 812 3456 7890
                        </p>
                    </a>

                    <a href="mailto:kreasihangat@gmail.com" class="bg-white/30 backdrop-blur-sm rounded-2xl p-6 border border-white/20 block hover:bg-white/40 transition-colors">
                        <svg class="w-8 h-8 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <h4 class="mb-2 font-semibold">Email</h4>
                        <p class="text-sm text-white/80">
                            kreasihangat@gmail.com
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>