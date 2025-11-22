<x-layouts.app :title="'Daftar'">

    {{-- Load reCAPTCHA --}}
    {!! NoCaptcha::renderJs() !!}

    <section class="bg-gradient-to-b from-[#FFF6ED] via-[#FFE3D4] to-[#F7BFA5] py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col items-center gap-12">

                {{-- TITLE --}}
                <div class="text-center space-y-3 max-w-2xl">
                    <p class="text-sm uppercase tracking-[0.4em] text-[#D97862]">Mulai Perjalananmu</p>
                    <h1 class="text-3xl sm:text-4xl font-semibold text-[#7C3A2D]">
                        Buat akun Kreasi Hangat dan ikuti workshop favoritmu
                    </h1>
                    <p class="text-sm text-[#9A5A46]">
                        Daftarkan dirimu untuk mengakses katalog event, kelola portofolio kelas, dan pantau status pembayaran.
                    </p>
                </div>

                {{-- TWO COLUMN WRAPPER --}}
                <div class="w-full max-w-5xl grid gap-8 lg:grid-cols-[minmax(0,1fr),minmax(0,1.1fr)]">

                    {{-- LEFT COLUMN --}}
                    <div class="rounded-[36px] border border-[#F7C8B8] bg-white/60 p-8 shadow-xl shadow-[#FAD6C7]/40 backdrop-blur">

                        <div class="flex items-center justify-between">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-semibold text-[#7C3A2D]">Mengapa bergabung?</h2>
                                <p class="text-sm text-[#9A5A46]">Gabung dengan komunitas kreatif kami.</p>
                            </div>
                            <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#FFE8DB] text-[#D97862]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="h-7 w-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.25 6.75H5.75A2.25 2.25 0 003.5 9v9.75A2.25 2.25 0 005.75 21h12.5A2.25 2.25 0 0020.5 18.75V9a2.25 2.25 0 00-2.25-2.25h-1.5M8.25 6.75V5.25a3 3 0 013-3h1.5a3 3 0 013 3v1.5" />
                                </svg>
                            </span>
                        </div>

                        <ul class="mt-8 space-y-4 text-sm text-[#7C3A2D]">
                            <li class="flex items-start gap-3">
                                <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#FFCCB6] text-[#7C3A2D]">1</span>
                                Telusuri kurasi workshop terbaru.
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#FFCCB6] text-[#7C3A2D]">2</span>
                                Kelola riwayat pendaftaran & status pembayaran.
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#FFCCB6] text-[#7C3A2D]">3</span>
                                Dapatkan notifikasi otomatis melalui email.
                            </li>
                        </ul>
                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="rounded-[36px] bg-white/80 backdrop-blur shadow-xl ring-1 ring-[#F7C8B8]/60 p-10">

                        <div class="mb-8 space-y-2">
                            <h2 class="text-2xl font-semibold text-[#7C3A2D]">Buat Akun Baru</h2>
                            <p class="text-sm text-[#9A5A46]">
                                Isi data berikut untuk mulai mendaftar workshop Kreasi Hangat.
                            </p>
                        </div>

                        {{-- VALIDATION ERRORS --}}
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

                        {{-- FORM --}}
                        <form method="POST" action="{{ route('register') }}" class="space-y-6">
                            @csrf

                            {{-- NAME --}}
                            <div class="space-y-2">
                                <label for="name" class="text-sm font-medium text-[#7C3A2D]">Nama Lengkap</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}"
                                       class="w-full rounded-2xl border border-[#F7C8B8] bg-white/80 px-4 py-3 text-sm text-[#7C3A2D]
                                       focus:ring-2 focus:ring-[#F5A38D]" required>
                            </div>

                            {{-- EMAIL --}}
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-medium text-[#7C3A2D]">Alamat E-mail</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                       class="w-full rounded-2xl border border-[#F7C8B8] bg-white/80 px-4 py-3 text-sm text-[#7C3A2D]
                                       focus:ring-2 focus:ring-[#F5A38D]" required>
                            </div>

                            {{-- PASSWORD --}}
                            <div class="space-y-2">
                                <label for="password" class="text-sm font-medium text-[#7C3A2D]">Kata Sandi</label>
                                <input id="password" type="password" name="password"
                                       class="w-full rounded-2xl border border-[#F7C8B8] bg-white/80 px-4 py-3 text-sm text-[#7C3A2D]
                                       focus:ring-2 focus:ring-[#F5A38D]" required>
                            </div>

                            {{-- PASSWORD CONFIRM --}}
                            <div class="space-y-2">
                                <label for="password_confirmation" class="text-sm font-medium text-[#7C3A2D]">Konfirmasi Kata Sandi</label>
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                       class="w-full rounded-2xl border border-[#F7C8B8] bg-white/80 px-4 py-3 text-sm text-[#7C3A2D]
                                       focus:ring-2 focus:ring-[#F5A38D]" required>
                            </div>

                            {{-- RECAPTCHA --}}
                            <div class="mt-2">
                                {!! NoCaptcha::display() !!}
                                @error('g-recaptcha-response')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- SUBMIT --}}
                            <button type="submit"
                                class="w-full rounded-full bg-[#D97862] px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-[#b9644f]">
                                Daftar Sekarang
                            </button>
                        </form>

                        {{-- DIVIDER --}}
                        <div class="mt-6 flex items-center gap-3">
                            <div class="flex-1 border-t border-[#F7C8B8]"></div>
                            <span class="text-xs text-[#9A5A46]">ATAU</span>
                            <div class="flex-1 border-t border-[#F7C8B8]"></div>
                        </div>

                        {{-- SIGN UP WITH GOOGLE --}}
                        <a href="{{ route('google.redirect', ['action' => 'register']) }}"
                           class="mt-6 flex w-full items-center justify-center gap-2 rounded-full border border-[#F7C8B8]
                           bg-white/50 px-6 py-3 text-sm font-semibold text-[#7C3A2D] hover:bg-white/80 transition">

                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="h-5 w-5" />
                            Daftar dengan Google
                        </a>

                        {{-- LOGIN LINK --}}
                        <div class="mt-8 flex items-center justify-between text-sm text-[#9A5A46]">
                            <span>Sudah punya akun?</span>
                            <a href="{{ route('login') }}"
                                class="font-semibold text-[#D97862] hover:text-[#b9644f] transition">
                                Masuk di sini
                            </a>
                        </div>

                    </div>
                </div>

                {{-- BACK TO HOME --}}
                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#7C3A2D] hover:text-[#5c261d] mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                    Kembali ke Beranda
                </a>

            </div>
        </div>
    </section>

</x-layouts.app>
