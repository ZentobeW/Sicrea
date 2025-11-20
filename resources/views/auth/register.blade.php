<x-layouts.app :title="'Daftar'">
    <section class="bg-gradient-to-b from-[#FFF6ED] via-[#FFE3D4] to-[#F7BFA5] py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-12">
                <div class="text-center space-y-3 max-w-2xl">
                    <p class="text-sm uppercase tracking-[0.4em] text-[#D97862]">Mulai Perjalananmu</p>
                    <h1 class="text-3xl sm:text-4xl font-semibold text-[#7C3A2D]">Buat akun Kreasi Hangat dan ikuti workshop favoritmu</h1>
                    <p class="text-sm text-[#9A5A46]">Daftarkan dirimu untuk mengakses katalog event, kelola portofolio kelas, dan pantau status pembayaran dengan mudah.</p>
                </div>

                <div class="w-full max-w-5xl grid gap-8 lg:grid-cols-[minmax(0,1fr),minmax(0,1.1fr)] items-start">
                    <div class="rounded-[36px] border border-[#F7C8B8] bg-white/60 p-8 shadow-xl shadow-[#FAD6C7]/40 backdrop-blur">
                        <div class="flex items-center justify-between">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-semibold text-[#7C3A2D]">Mengapa bergabung?</h2>
                                <p class="text-sm text-[#9A5A46]">Tingkatkan kemampuan dan perluas jaringan profesionalmu bersama komunitas kreatif kami.</p>
                            </div>
                            <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#FFE8DB] text-[#D97862]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.25 6.75H5.75A2.25 2.25 0 003.5 9v9.75A2.25 2.25 0 005.75 21h12.5A2.25 2.25 0 0020.5 18.75V9a2.25 2.25 0 00-2.25-2.25h-1.5M8.25 6.75V5.25a3 3 0 013-3h1.5a3 3 0 013 3v1.5" />
                                </svg>
                            </span>
                        </div>

                        <ul class="mt-8 space-y-4 text-sm text-[#7C3A2D]">
                            <li class="flex items-start gap-3">
                                <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#FFCCB6] text-[#7C3A2D]">1</span>
                                <span>Telusuri kurasi workshop terbaru dengan detail lengkap jadwal, tutor, dan venue.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#FFCCB6] text-[#7C3A2D]">2</span>
                                <span>Kelola riwayat pendaftaran serta pantau status pembayaranmu dari satu dashboard.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#FFCCB6] text-[#7C3A2D]">3</span>
                                <span>Dapatkan update otomatis melalui email setiap kali pembayaran diverifikasi.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="rounded-[36px] bg-white/80 backdrop-blur shadow-xl ring-1 ring-[#F7C8B8]/60 p-10">
                        <div class="mb-8 space-y-2">
                            <h2 class="text-2xl font-semibold text-[#7C3A2D]">Buat Akun Baru</h2>
                            <p class="text-sm text-[#9A5A46]">Isi data berikut untuk mulai mendaftar workshop Kreasi Hangat.</p>
                        </div>

                        @if ($errors->any())
                            <div class="mb-6 rounded-3xl border border-[#FDE1E7] bg-[#FFF5F7] px-5 py-4 text-sm text-[#BA1B1D]">
                                <p class="font-semibold">Ada data yang perlu diperiksa kembali:</p>
                                <ul class="mt-2 list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" class="space-y-6">
                            @csrf
                            <div class="space-y-2">
                                <label for="name" class="text-sm font-medium text-[#7C3A2D]">Nama Lengkap</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                    class="w-full rounded-2xl border border-[#F7C8B8] bg-white/80 px-4 py-3 text-sm text-[#7C3A2D] placeholder:text-[#D9A497] focus:border-[#D97862] focus:outline-none focus:ring-2 focus:ring-[#F5A38D]">
                            </div>
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-medium text-[#7C3A2D]">Alamat E-mail</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full rounded-2xl border border-[#F7C8B8] bg-white/80 px-4 py-3 text-sm text-[#7C3A2D] placeholder:text-[#D9A497] focus:border-[#D97862] focus:outline-none focus:ring-2 focus:ring-[#F5A38D]">
                            </div>
                            <div class="space-y-2">
                                <label for="password" class="text-sm font-medium text-[#7C3A2D]">Kata Sandi</label>
                                <input id="password" type="password" name="password" required
                                    class="w-full rounded-2xl border border-[#F7C8B8] bg-white/80 px-4 py-3 text-sm text-[#7C3A2D] placeholder:text-[#D9A497] focus:border-[#D97862] focus:outline-none focus:ring-2 focus:ring-[#F5A38D]">
                            </div>
                            <div class="space-y-2">
                                <label for="password_confirmation" class="text-sm font-medium text-[#7C3A2D]">Konfirmasi Kata Sandi</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    class="w-full rounded-2xl border border-[#F7C8B8] bg-white/80 px-4 py-3 text-sm text-[#7C3A2D] placeholder:text-[#D9A497] focus:border-[#D97862] focus:outline-none focus:ring-2 focus:ring-[#F5A38D]">
                            </div>

                            {{-- Add reCAPTCHA v2 checkbox widget --}}
                            <div class="flex">
                                <div class="g-recaptcha" data-sitekey="{{ $recaptcha_site_key }}"></div>
                            </div>

                            <button type="submit" class="w-full rounded-full bg-[#D97862] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#D97862]/30 transition hover:bg-[#b9644f]">
                                Daftar Sekarang
                            </button>
                        </form>

                        {{-- Add Google Sign-up option --}}
                        <div class="mt-6 flex items-center gap-3">
                            <div class="flex-1 border-t border-[#F7C8B8]"></div>
                            <span class="text-xs text-[#9A5A46]">ATAU</span>
                            <div class="flex-1 border-t border-[#F7C8B8]"></div>
                        </div>

                        <a href="{{ route('google.redirect', ['action' => 'register']) }}" class="mt-6 flex w-full items-center justify-center gap-2 rounded-full border border-[#F7C8B8] bg-white/50 px-6 py-3 text-sm font-semibold text-[#7C3A2D] transition hover:bg-white/80">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Daftar dengan Google
                        </a>

                        <div class="mt-8 flex flex-wrap items-center justify-between gap-3 text-sm text-[#9A5A46]">
                            <span>Sudah punya akun?</span>
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="font-semibold text-[#D97862] hover:text-[#b9644f]">Masuk di sini</a>
                            @endif
                        </div>
                    </div>
                </div>

                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#7C3A2D] hover:text-[#5c261d]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </section>

    {{-- Load reCAPTCHA script at end of page --}}
    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endpush
</x-layouts.app>
