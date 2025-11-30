@php
    use Illuminate\Support\Facades\Route;
@endphp

<x-layouts.app :title="'Masuk'">

    {{-- Load NoCaptcha JS --}}
    {!! NoCaptcha::renderJs() !!}

    <section class="bg-[#FCF5E6] py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-12">

                {{-- TITLE --}}
                <div class="text-center space-y-2">
                    <p class="text-sm uppercase tracking-[0.4em] text-[#B49F9A]">Selamat Datang Kembali</p>
                    <h1 class="text-3xl sm:text-4xl font-semibold text-[#822021]">
                        Masuk untuk melanjutkan perjalanan kreatifmu
                    </h1>
                </div>

                {{-- CARD --}}
                <div class="w-full max-w-lg rounded-[36px] bg-white/80 backdrop-blur shadow-xl ring-1 ring-[#FFBE8E]/60 p-10">

                    {{-- GOOGLE LOGIN ERROR --}}
                    @if ($errors->has('oauth'))
                        <div class="mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first('oauth') }}
                        </div>
                    @endif

                    {{-- HEADER --}}
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-semibold text-[#822021]">Login</h2>
                            <p class="text-sm text-[#B49F9A] mt-1">
                                Masuk ke akun untuk mendaftar event dan workshop.
                            </p>
                        </div>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#FFB3E1] text-[#822021]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-9A2.25 2.25 0 002.25 5.25v13.5A2.25 2.25 0 004.5 21h9a2.25 2.25 0 002.25-2.25V15M9.75 9l3 3-3 3m6-3H9.75" />
                            </svg>
                        </span>
                    </div>

                    {{-- LOGIN FORM --}}
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        {{-- EMAIL --}}
                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium text-[#822021]">Alamat E-mail</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full rounded-2xl border border-[#FFBE8E] bg-white/70 px-4 py-3 text-sm text-[#822021]
                                placeholder:text-[#B49F9A] focus:border-[#FFB3E1] focus:outline-none focus:ring-2 focus:ring-[#FFB3E1]">
                        </div>

                        {{-- PASSWORD --}}
                        <div class="space-y-2">
                            <label for="password" class="text-sm font-medium text-[#822021]">Kata Sandi</label>
                            <input id="password" type="password" name="password" required
                                class="w-full rounded-2xl border border-[#FFBE8E] bg-white/70 px-4 py-3 text-sm text-[#822021]
                                placeholder:text-[#B49F9A] focus:border-[#FFB3E1] focus:outline-none focus:ring-2 focus:ring-[#FFB3E1]">

                            {{-- FORGOT PASSWORD --}}
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="block text-right text-sm font-semibold text-[#FFB3E1] hover:text-[#e89dd1] transition">
                                    Lupa kata sandi?
                                </a>
                            @endif
                        </div>

                        {{-- RECAPTCHA --}}
                        <div class="mt-4 flex justify-center">
                            {!! NoCaptcha::display() !!}
                        </div>

                        {{-- REMEMBER + REGISTER --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 text-sm">
                            <label class="inline-flex items-center gap-2 text-[#B49F9A]">
                                <input type="checkbox" name="remember"
                                    class="rounded border-[#FFBE8E] text-[#FFB3E1] focus:ring-[#FFB3E1]">
                                <span>Ingat saya</span>
                            </label>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="font-semibold text-[#FFB3E1] hover:text-[#e89dd1] transition">
                                    Belum punya akun? Daftar sekarang
                                </a>
                            @endif
                        </div>

                        {{-- SUBMIT --}}
                        <button type="submit"
                            class="w-full rounded-full bg-[#FFB3E1] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#FFB3E1]/30
                            transition hover:bg-[#e89dd1] hover:scale-[1.02] active:scale-[0.98]">
                            Masuk
                        </button>
                    </form>

                    {{-- DIVIDER (DIPERBAIKI) --}}
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-[#FFBE8E]"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="bg-white/80 px-3 text-[#B49F9A]">atau</span>
                        </div>
                    </div>

                    {{-- SIGN IN WITH GOOGLE --}}
                    <a href="{{ route('google.redirect', ['action' => 'login']) }}"
                        class="w-full flex items-center justify-center gap-3 rounded-full border border-[#FFBE8E]/40 bg-white px-6 py-3
                        text-sm font-medium text-[#822021] shadow-sm hover:bg-[#FCF5E6] hover:scale-[1.02] active:scale-[0.98] transition">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="h-5 w-5" />
                        Masuk dengan Google
                    </a>

                    {{-- BACK TO HOME --}}
                    <div class="mt-8 flex flex-col items-center gap-3 text-sm text-[#B49F9A]">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center gap-2 font-semibold text-[#822021] hover:text-[#6b1a1b] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
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
