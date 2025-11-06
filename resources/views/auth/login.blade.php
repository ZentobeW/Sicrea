<x-layouts.app :title="'Masuk'">
    <section class="bg-gradient-to-b from-[#FFF3E8] via-[#FFE1D0] to-[#F7BFA5] py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-12">
                <div class="text-center space-y-2">
                    <p class="text-sm uppercase tracking-[0.4em] text-[#D97862]">Selamat Datang Kembali</p>
                    <h1 class="text-3xl sm:text-4xl font-semibold text-[#7C3A2D]">Masuk untuk melanjutkan perjalanan kreatifmu</h1>
                </div>

                <div class="w-full max-w-lg rounded-[36px] bg-white/80 backdrop-blur shadow-xl ring-1 ring-[#F7C8B8]/60 p-10">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-semibold text-[#7C3A2D]">Login</h2>
                            <p class="text-sm text-[#9A5A46] mt-1">Masuk ke akun untuk mendaftar event dan workshop.</p>
                        </div>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#FFE3D4] text-[#D97862]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-9A2.25 2.25 0 002.25 5.25v13.5A2.25 2.25 0 004.5 21h9a2.25 2.25 0 002.25-2.25V15M9.75 9l3 3-3 3m6-3H9.75" />
                            </svg>
                        </span>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium text-[#7C3A2D]">Alamat E-mail</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full rounded-2xl border border-[#F7C8B8] bg-white/70 px-4 py-3 text-sm text-[#7C3A2D] placeholder:text-[#D9A497] focus:border-[#D97862] focus:outline-none focus:ring-2 focus:ring-[#F5A38D]">
                        </div>
                        <div class="space-y-2">
                            <label for="password" class="text-sm font-medium text-[#7C3A2D]">Kata Sandi</label>
                            <input id="password" type="password" name="password" required
                                class="w-full rounded-2xl border border-[#F7C8B8] bg-white/70 px-4 py-3 text-sm text-[#7C3A2D] placeholder:text-[#D9A497] focus:border-[#D97862] focus:outline-none focus:ring-2 focus:ring-[#F5A38D]">
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-3 text-sm">
                            <label class="inline-flex items-center gap-2 text-[#9A5A46]">
                                <input type="checkbox" name="remember" class="rounded border-[#F7C8B8] text-[#D97862] focus:ring-[#D97862]">
                                <span>Ingat saya</span>
                            </label>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="font-semibold text-[#D97862] hover:text-[#b9644f]">Belum punya akun? Daftar sekarang</a>
                            @endif
                        </div>
                        <button type="submit"
                            class="w-full rounded-full bg-[#D97862] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#D97862]/30 transition hover:bg-[#b9644f]">
                            Masuk
                        </button>
                    </form>

                    <div class="mt-8 flex flex-col items-center gap-3 text-sm text-[#9A5A46]">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-semibold text-[#7C3A2D] hover:text-[#5c261d]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
