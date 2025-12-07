@php
    use Illuminate\Support\Facades\Route;
@endphp

<x-layouts.app :title="'Lupa Kata Sandi'">

    {{-- Custom Style --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body, h1, h2, h3, p, a, span, div, label, input, button {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Button Hover Effect (Zoom In) */
        .btn-action {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-action:hover {
            transform: scale(1.05);
            background-color: #822021 !important;
            color: #FCF5E6 !important;
            border-color: #822021 !important;
            box-shadow: 0 10px 15px -3px rgba(130, 32, 33, 0.3);
        }
    </style>

    {{-- Main Background: FFDEF8 --}}
    <section class="bg-[#FCF5E6] py-16 min-h-screen flex items-center">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-center w-full">
            
            {{-- CARD: BG FAF8F1, Border 822021 --}}
            <div class="w-full max-w-lg rounded-[36px] bg-[#FAF8F1] border border-[#822021] shadow-xl shadow-[#822021]/10 p-10">

                {{-- TITLE --}}
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-[#822021]">Lupa Kata Sandi?</h2>
                    <p class="text-sm text-[#822021]/70 mt-2">
                        Masukkan email untuk mengirimkan tautan reset kata sandi.
                    </p>
                </div>

                {{-- STATUS MESSAGE --}}
                @if (session('status'))
                    <div class="mb-6 rounded-xl bg-[#E9F6EC] border border-[#2F7A48]/20 px-4 py-3 text-sm text-[#2F7A48] font-semibold">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- FORM --}}
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-[#822021]">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021]
                            placeholder:text-[#822021]/40 focus:border-[#822021] focus:ring-2 focus:ring-[#822021]/20 focus:outline-none">
                        @error('email')
                            <p class="text-[#BA1B1D] text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    {{-- Default: BG FFDEF8, Text 822021 --}}
                    {{-- Hover: Zoom, BG 822021, Text FCF5E6 --}}
                    <button type="submit"
                        class="btn-action w-full rounded-full bg-[#FFDEF8] border border-[#822021] px-6 py-3 text-sm font-bold text-[#822021] shadow-md">
                        Kirim Tautan Reset
                    </button>
                </form>

                {{-- BACK --}}
                <div class="mt-8 text-center border-t border-[#822021]/10 pt-6">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 text-sm font-bold text-[#822021] hover:opacity-75 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Kembali ke Login
                    </a>
                </div>

            </div>
        </div>
    </section>

</x-layouts.app>