@php
    use Illuminate\Support\Facades\Route;
@endphp

<x-layouts.app :title="'Masuk'">

    {{-- Load NoCaptcha JS --}}
    {!! NoCaptcha::renderJs() !!}

    {{-- Custom Style for this page --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        /* Force font Poppins */
        body, h1, h2, h3, p, a, span, div, label, input, button {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Button Hover Effect (Zoom In) */
        .btn-action {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-action:hover {
            transform: scale(1.05); /* Zoom In */
            background-color: #822021 !important;
            color: #FCF5E6 !important;
            border-color: #822021 !important;
            box-shadow: 0 10px 15px -3px rgba(130, 32, 33, 0.3);
        }
    </style>

    {{-- Main Background: FFDEF8 --}}
    <section class="bg-[#FCF5E6] py-16 min-h-screen flex items-center">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="flex flex-col items-center gap-12">

                {{-- TITLE --}}
                <div class="text-center space-y-2">
                    <p class="text-sm uppercase tracking-[0.4em] text-[#822021]/60 font-semibold">Selamat Datang Kembali</p>
                    <h1 class="text-3xl sm:text-4xl font-bold text-[#822021]">
                        Masuk untuk melanjutkan perjalanan kreatifmu
                    </h1>
                </div>

                {{-- CARD LOGIN --}}
                {{-- BG: FAF8F1, Border: 822021 --}}
                <div class="w-full max-w-lg rounded-[36px] bg-[#FAF8F1] border border-[#822021] shadow-xl shadow-[#822021]/10 p-10">

                    {{-- GOOGLE LOGIN ERROR --}}
                    @if ($errors->has('oauth'))
                        <div class="mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first('oauth') }}
                        </div>
                    @endif

                    {{-- HEADER --}}
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-[#822021]">Login</h2>
                            <p class="text-sm text-[#822021]/70 mt-1">
                                Masuk ke akun untuk mendaftar event dan workshop.
                            </p>
                        </div>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#FFDEF8] border border-[#822021]/20 text-[#822021]">
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
                            <label for="email" class="text-sm font-bold text-[#822021]">Alamat E-mail</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021]
                                placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20">
                        </div>

                        {{-- PASSWORD --}}
                        <div class="space-y-2">
                            <label for="password" class="text-sm font-bold text-[#822021]">Kata Sandi</label>
                            <input id="password" type="password" name="password" required
                                class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021]
                                placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20">

                            {{-- FORGOT PASSWORD --}}
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="block text-right text-sm font-semibold text-[#822021]/70 hover:text-[#822021] transition">
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
                            <label class="inline-flex items-center gap-2 text-[#822021]/80 cursor-pointer">
                                <input type="checkbox" name="remember"
                                    class="rounded border-[#822021]/40 text-[#822021] focus:ring-[#822021]/20 cursor-pointer">
                                <span>Ingat saya</span>
                            </label>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="font-bold text-[#822021] hover:underline transition">
                                    Belum punya akun? Daftar sekarang
                                </a>
                            @endif
                        </div>

                        {{-- SUBMIT BUTTON --}}
                        {{-- Default: BG FFDEF8, Text 822021 --}}
                        {{-- Hover: Zoom, BG 822021, Text FCF5E6 --}}
                        <button type="submit"
                            class="btn-action w-full rounded-full bg-[#FFDEF8] border border-[#822021] px-6 py-3 text-sm font-bold text-[#822021] shadow-md">
                            Masuk
                        </button>
                    </form>

                    {{-- DIVIDER --}}
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-[#822021]/30"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="bg-[#FAF8F1] px-3 text-[#822021]/60 font-medium">atau</span>
                        </div>
                    </div>

                    {{-- SIGN IN WITH GOOGLE --}}
                    <a href="{{ route('google.redirect', ['action' => 'login']) }}"
                        class="w-full flex items-center justify-center gap-3 rounded-full border border-[#822021]/40 bg-white px-6 py-3
                        text-sm font-bold text-[#822021] shadow-sm hover:bg-[#FFDEF8] transition transform hover:scale-[1.02]">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="h-5 w-5" />
                        Masuk dengan Google
                    </a>

                    {{-- BACK TO HOME --}}
                    <div class="mt-8 flex flex-col items-center gap-3 text-sm">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center gap-2 font-semibold text-[#822021] hover:text-[#822021]/70 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="h-4 w-4">
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