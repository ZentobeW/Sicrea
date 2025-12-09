<x-layouts.app :title="'Daftar'">

    {{-- Load reCAPTCHA --}}
    {!! NoCaptcha::renderJs() !!}

    {{-- Custom Style for this page --}}
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

        /* Center reCaptcha on mobile */
        .g-recaptcha {
            display: inline-block;
        }
    </style>

    {{-- Main Background: FFDEF8 --}}
    <section class="bg-[#FCF5E6] py-16 min-h-screen flex items-center">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 w-full">

            <div class="flex flex-col items-center gap-12">

                {{-- TITLE --}}
                <div class="text-center space-y-3 max-w-2xl">
                    <p class="text-sm uppercase tracking-[0.4em] text-[#822021]/60 font-semibold">Mulai Perjalananmu</p>
                    <h1 class="text-3xl sm:text-4xl font-bold text-[#822021]">
                        Buat akun Kreasi Hangat dan ikuti workshop favoritmu
                    </h1>
                    <p class="text-sm text-[#822021]/70">
                        Daftarkan dirimu untuk mengakses katalog event, kelola portofolio kelas, dan pantau status pembayaran.
                    </p>
                </div>

                {{-- TWO COLUMN WRAPPER --}}
                <div class="w-full max-w-5xl grid gap-8 lg:grid-cols-[minmax(0,1fr),minmax(0,1.1fr)]">

                    {{-- LEFT COLUMN (Info) --}}
                    {{-- BG: FAF8F1, Border: 822021 --}}
                    <div class="rounded-[36px] border border-[#822021] bg-[#FAF8F1] p-8 shadow-xl shadow-[#822021]/10 backdrop-blur">

                        <div class="flex items-center justify-between">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-[#822021]">Mengapa bergabung?</h2>
                                <p class="text-sm text-[#822021]/70">Gabung dengan komunitas kreatif kami.</p>
                            </div>
                            <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#FFDEF8] text-[#822021] border border-[#822021]/20">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="h-7 w-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.25 6.75H5.75A2.25 2.25 0 003.5 9v9.75A2.25 2.25 0 005.75 21h12.5A2.25 2.25 0 0020.5 18.75V9a2.25 2.25 0 00-2.25-2.25h-1.5M8.25 6.75V5.25a3 3 0 013-3h1.5a3 3 0 013 3v1.5" />
                                </svg>
                            </span>
                        </div>

                        <ul class="mt-8 space-y-4 text-sm text-[#822021]">
                            <li class="flex items-start gap-3">
                                <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#822021] text-[#FCF5E6] font-bold text-xs">1</span>
                                <span>Telusuri kurasi workshop terbaru.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#822021] text-[#FCF5E6] font-bold text-xs">2</span>
                                <span>Kelola riwayat pendaftaran & status pembayaran.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#822021] text-[#FCF5E6] font-bold text-xs">3</span>
                                <span>Dapatkan notifikasi otomatis melalui email.</span>
                            </li>
                        </ul>
                    </div>

                    {{-- RIGHT COLUMN (Form) --}}
                    {{-- BG: FAF8F1, Border: 822021 --}}
                    <div class="rounded-[36px] bg-[#FAF8F1] border border-[#822021] shadow-xl shadow-[#822021]/10 p-10 backdrop-blur">

                        <div class="mb-8 space-y-2">
                            <h2 class="text-2xl font-bold text-[#822021]">Buat Akun Baru</h2>
                            <p class="text-sm text-[#822021]/70">
                                Isi data berikut untuk mulai mendaftar workshop Kreasi Hangat.
                            </p>
                            <p class="text-xs text-[#822021]/50 italic">
                                Setelah daftar, kami kirim OTP 6-digit ke email kamu untuk verifikasi.
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
                        <form id="register-form" method="POST" action="{{ route('register') }}" class="space-y-6" novalidate>
                            @csrf
                            <div class="absolute left-[-9999px] top-auto h-0 overflow-hidden">
                                <label for="website" class="sr-only">Website</label>
                                <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                            </div>

                            {{-- NAME --}}
                            <div class="space-y-2">
                                <label for="name" class="text-sm font-bold text-[#822021]">Nama Lengkap</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name"
                                       class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021]
                                       focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20" required>
                                <p id="name-feedback" class="text-xs text-[#BA1B1D] min-h-[18px]" aria-live="polite"></p>
                            </div>

                            {{-- EMAIL --}}
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-bold text-[#822021]">Alamat E-mail</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                                       class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021]
                                       focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20" required>
                                <p id="email-feedback" class="text-xs text-[#BA1B1D] min-h-[18px]" aria-live="polite"></p>
                            </div>

                            {{-- PASSWORD --}}
                            <div class="space-y-2">
                                <label for="password" class="text-sm font-bold text-[#822021]">Kata Sandi</label>
                                <input id="password" type="password" name="password" autocomplete="new-password"
                                       class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021]
                                       focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20" required>
                                <div class="flex items-center gap-3">
                                    <div class="h-2 flex-1 rounded-full bg-[#822021]/10 overflow-hidden">
                                        <div id="password-strength-bar" class="h-full w-0 bg-[#822021] transition-all duration-300"></div>
                                    </div>
                                    <span id="password-strength-label" class="text-xs text-[#822021]/60">Kekuatan sandi</span>
                                </div>
                                <p class="text-xs text-[#822021]/60">
                                    Min. 8 karakter dengan huruf besar, angka, dan simbol.
                                </p>
                                <p id="password-feedback" class="text-xs text-[#BA1B1D] min-h-[18px]" aria-live="polite"></p>
                            </div>

                            {{-- PASSWORD CONFIRM --}}
                            <div class="space-y-2">
                                <label for="password_confirmation" class="text-sm font-bold text-[#822021]">Konfirmasi Kata Sandi</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
                                       class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021]
                                       focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20" required>
                                <p id="confirm-feedback" class="text-xs text-[#BA1B1D] min-h-[18px]" aria-live="polite"></p>
                            </div>

                            {{-- RECAPTCHA --}}
                            <div class="mt-2 flex justify-center">
                                <div class="inline-block">
                                    {!! NoCaptcha::display() !!}
                                    @error('g-recaptcha-response')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- SUBMIT --}}
                            {{-- Default: BG FFDEF8, Text 822021 --}}
                            {{-- Hover: Zoom, BG 822021, Text FCF5E6 --}}
                            <button type="submit"
                                id="register-submit"
                                class="btn-action w-full inline-flex items-center justify-center gap-2 rounded-full bg-[#FFDEF8] border border-[#822021] px-6 py-3 text-sm font-bold text-[#822021] shadow-lg disabled:opacity-70 disabled:cursor-not-allowed">
                                <svg id="submit-spinner" class="h-4 w-4 animate-spin text-[#822021] hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                <span id="submit-text">Daftar Sekarang</span>
                            </button>
                        </form>

                        {{-- DIVIDER --}}
                        <div class="mt-6 flex items-center gap-3">
                            <div class="flex-1 border-t border-[#822021]/30"></div>
                            <span class="text-xs font-medium text-[#822021]/60">ATAU</span>
                            <div class="flex-1 border-t border-[#822021]/30"></div>
                        </div>

                        {{-- SIGN UP WITH GOOGLE --}}
                        <a href="{{ route('google.redirect', ['action' => 'register']) }}"
                           class="mt-6 flex w-full items-center justify-center gap-2 rounded-full border border-[#822021]/40
                           bg-white px-6 py-3 text-sm font-bold text-[#822021] shadow-sm hover:bg-[#FFDEF8] transition transform hover:scale-[1.02]">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="h-5 w-5" />
                            Daftar dengan Google
                        </a>

                        {{-- LOGIN LINK --}}
                        <div class="mt-8 text-center text-sm text-[#822021]/70">
                            <span>Sudah punya akun? </span>
                            <a href="{{ route('login') }}"
                               class="font-bold text-[#822021] hover:underline transition">
                                Masuk di sini
                            </a>
                        </div>

                    </div>
                </div>

                {{-- BACK TO HOME --}}
                <a href="{{ route('home') }}"
                   class="inline-flex items-center gap-2 text-sm font-semibold text-[#822021] hover:text-[#822021]/70 mt-6 transition">
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

@push('scripts')
<script>
    // ... (Script Validasi JavaScript Tetap Sama - Tidak Perlu Diubah Logicnya) ...
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('register-form');
        if (!form) return;

        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const submitBtn = document.getElementById('register-submit');
        const submitSpinner = document.getElementById('submit-spinner');
        const submitText = document.getElementById('submit-text');
        const strengthBar = document.getElementById('password-strength-bar');
        const strengthLabel = document.getElementById('password-strength-label');

        const feedback = {
            name: document.getElementById('name-feedback'),
            email: document.getElementById('email-feedback'),
            password: document.getElementById('password-feedback'),
            confirm: document.getElementById('confirm-feedback'),
        };

        const disposableDomains = [
            'mailinator.com', '10minutemail.com', 'guerrillamail.com', 'temp-mail.org',
            'yopmail.com', 'getnada.com', 'trashmail.com', 'fakemail.net', 'dispostable.com',
        ];

        const setFeedback = (input, target, message = '', isValid = true) => {
            if (!target) return;
            target.textContent = message;
            if (input) {
                // Warna Border Input saat Error/Valid
                input.style.borderColor = isValid ? 'rgba(130, 32, 33, 0.4)' : '#ef4444';
            }
            target.style.color = isValid ? '#822021' : '#BA1B1D';
        };

        const passwordScore = (value) => {
            const checks = [
                value.length >= 8,
                /[A-Z]/.test(value) && /[a-z]/.test(value),
                /\d/.test(value),
                /[^A-Za-z0-9]/.test(value),
            ];
            return checks.filter(Boolean).length;
        };

        const renderStrength = (score) => {
            const percent = (score / 4) * 100;
            const colors = ['#F87171', '#F97316', '#F59E0B', '#22C55E', '#16A34A'];
            strengthBar.style.width = `${percent}%`;
            strengthBar.style.backgroundColor = colors[score] ?? colors[colors.length - 1];

            const labels = ['Sangat lemah', 'Lemah', 'Cukup', 'Kuat', 'Sangat kuat'];
            strengthLabel.textContent = labels[score] ?? 'Kekuatan sandi';
        };

        const validateName = () => {
            const value = nameInput.value.trim();
            const isValid = value.length >= 3;
            setFeedback(nameInput, feedback.name, isValid ? '' : 'Nama minimal 3 karakter.', isValid);
            return isValid;
        };

        const validateEmail = () => {
            const value = emailInput.value.trim();
            const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let message = '';
            let isValid = pattern.test(value);

            if (isValid) {
                const domain = value.split('@')[1]?.toLowerCase();
                if (domain && disposableDomains.includes(domain)) {
                    isValid = false;
                    message = 'Gunakan email permanen, bukan temporary email.';
                }
            } else if (value.length) {
                message = 'Format email belum benar.';
            }

            setFeedback(emailInput, feedback.email, message, isValid || !value.length);
            return isValid;
        };

        const validatePassword = () => {
            const value = passwordInput.value;
            const score = passwordScore(value);
            renderStrength(score);

            const requirements = [];
            if (value.length < 8) requirements.push('8 karakter');
            if (!/[A-Z]/.test(value) || !/[a-z]/.test(value)) requirements.push('huruf besar & kecil');
            if (!/\d/.test(value)) requirements.push('angka');
            if (!/[^A-Za-z0-9]/.test(value)) requirements.push('simbol');

            const isValid = requirements.length === 0;
            const message = isValid ? '' : `Tambahkan ${requirements.join(', ')}.`;

            setFeedback(passwordInput, feedback.password, message, isValid || !value.length);
            return isValid;
        };

        const validateConfirm = () => {
            const isValid = passwordInput.value === confirmInput.value && confirmInput.value.length > 0;
            const message = isValid || !confirmInput.value.length ? '' : 'Konfirmasi kata sandi belum cocok.';
            setFeedback(confirmInput, feedback.confirm, message, isValid || !confirmInput.value.length);
            return isValid;
        };

        nameInput?.addEventListener('input', validateName);
        emailInput?.addEventListener('input', validateEmail);
        passwordInput?.addEventListener('input', () => {
            validatePassword();
            validateConfirm();
        });
        confirmInput?.addEventListener('input', validateConfirm);

        form.addEventListener('submit', (event) => {
            const allValid = [validateName(), validateEmail(), validatePassword(), validateConfirm()].every(Boolean);
            if (!allValid) {
                event.preventDefault();
                return;
            }

            submitBtn.disabled = true;
            submitSpinner.classList.remove('hidden');
            submitText.textContent = 'Memproses...';
        });
    });
</script>
@endpush
</x-layouts.app>