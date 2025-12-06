<x-layouts.app :title="'Verifikasi Email'">

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
        .btn-action:hover:not(:disabled) {
            transform: scale(1.05); /* Zoom In */
            background-color: #822021 !important;
            color: #FCF5E6 !important;
            border-color: #822021 !important;
            box-shadow: 0 10px 15px -3px rgba(130, 32, 33, 0.3);
        }
    </style>

    {{-- Main Background: FFDEF8 --}}
    <section class="bg-[#FFDEF8] py-16 min-h-screen flex items-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            
            {{-- CARD: BG FAF8F1, Border 822021 --}}
            <div class="rounded-[36px] bg-[#FAF8F1] border border-[#822021] shadow-xl shadow-[#822021]/10 p-8 md:p-12">
                
                {{-- HEADER --}}
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
                    <div class="space-y-2">
                        <p class="text-xs uppercase tracking-[0.35em] text-[#822021]/60 font-semibold">Verifikasi Email</p>
                        <h1 class="text-3xl font-bold text-[#822021]">Konfirmasi identitas kamu</h1>
                        <p class="text-sm text-[#822021]/70">
                            Masukkan kode OTP 6-digit yang kami kirim ke <span class="font-bold text-[#822021]">{{ $user->email }}</span>.
                            Kode berlaku 15 menit.
                        </p>
                    </div>
                    <div class="inline-flex items-center gap-2 rounded-full bg-[#FFDEF8] border border-[#822021]/20 px-4 py-2 text-[#822021]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-semibold">Email belum diverifikasi</span>
                    </div>
                </div>

                {{-- ERROR MESSAGE --}}
                @if ($errors->any())
                    <div class="mt-6 rounded-3xl border border-[#FDE1E7] bg-[#FFF5F7] px-5 py-4 text-sm text-[#BA1B1D]">
                        <p class="font-semibold">Periksa kembali data berikut:</p>
                        <ul class="mt-2 list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM OTP --}}
                <form method="POST" action="{{ route('verification.verify') }}" class="mt-8 space-y-6" id="otp-form">
                    @csrf
                    
                    <div class="space-y-2">
                        <label for="otp" class="text-sm font-bold text-[#822021]">Kode OTP</label>
                        <input id="otp" name="otp" type="text" inputmode="numeric" maxlength="6" pattern="[0-9]*" autofocus
                               class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-center text-lg tracking-[0.5em] text-[#822021] font-bold
                               focus:border-[#822021] focus:ring-2 focus:ring-[#822021]/20 focus:outline-none"
                               placeholder="••••••" required>
                        <p class="text-xs text-[#822021]/60">Tidak menerima email? Periksa folder spam atau kirim ulang kode.</p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between pt-4">
                        {{-- SUBMIT BUTTON --}}
                        {{-- Default: BG FFDEF8, Text 822021 --}}
                        {{-- Hover: Zoom, BG 822021, Text FCF5E6 --}}
                        <button type="submit" id="otp-submit"
                                class="btn-action inline-flex items-center justify-center gap-2 rounded-full bg-[#FFDEF8] border border-[#822021] px-6 py-3 text-sm font-bold text-[#822021] shadow-lg disabled:opacity-70 disabled:cursor-not-allowed transition">
                            <svg id="otp-spinner" class="h-4 w-4 animate-spin text-[#822021] hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            <span id="otp-submit-text">Verifikasi & Masuk</span>
                        </button>

                        {{-- RESEND BUTTON --}}
                        <button type="submit" form="resend-form"
                                class="inline-flex items-center justify-center gap-2 rounded-full border border-[#822021]/40 bg-white px-5 py-3 text-sm font-semibold text-[#822021] hover:bg-[#FAF8F1] transition"
                                onclick="this.disabled=true; setTimeout(() => this.disabled=false, 2000);">
                            Kirim Ulang Kode
                        </button>
                    </div>
                </form>

                <form id="resend-form" class="hidden" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                </form>

                {{-- SWITCH ACCOUNT --}}
                <div class="mt-8 pt-6 border-t border-[#822021]/10 flex items-center justify-between text-sm text-[#822021]/70">
                    <span>Ingin menggunakan email lain?</span>
                    <a href="{{ route('register') }}" class="font-bold text-[#822021] hover:underline transition">Buat ulang akun</a>
                </div>

            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('otp-form');
            const submitBtn = document.getElementById('otp-submit');
            const spinner = document.getElementById('otp-spinner');
            const submitText = document.getElementById('otp-submit-text');

            form?.addEventListener('submit', () => {
                submitBtn.disabled = true;
                spinner.classList.remove('hidden');
                submitText.textContent = 'Memverifikasi...';
            });
        });
    </script>
    @endpush
</x-layouts.app>