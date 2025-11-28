<x-layouts.app :title="'Daftar'">

    {{-- Load reCAPTCHA --}}
    {!! NoCaptcha::renderJs() !!}

    <section class="bg-[#FCF5E6] py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col items-center gap-12">

                {{-- TITLE --}}
                <div class="text-center space-y-3 max-w-2xl">
                    <p class="text-sm uppercase tracking-[0.4em] text-[#B49F9A]">Mulai Perjalananmu</p>
                    <h1 class="text-3xl sm:text-4xl font-semibold text-[#822021]">
                        Buat akun Kreasi Hangat dan ikuti workshop favoritmu
                    </h1>
                    <p class="text-sm text-[#B49F9A]">
                        Daftarkan dirimu untuk mengakses katalog event, kelola portofolio kelas, dan pantau status pembayaran.
                    </p>
                </div>

                {{-- TWO COLUMN WRAPPER --}}
                <div class="w-full max-w-2xl grid gap-8 lg:grid-cols-[minmax(0,1fr),minmax(0,1.1fr)]">

                    {{-- LEFT COLUMN --}}
                    <div class="rounded-[36px] border border-[#FFBE8E] bg-white/60 p-8 shadow-xl shadow-[#FFBE8E]/40 backdrop-blur">

                        <div class="flex items-center justify-between">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-semibold text-[#822021]">Mengapa bergabung?</h2>
                                <p class="text-sm text-[#B49F9A]">Gabung dengan komunitas kreatif kami.</p>
                            </div>
                            <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#FFB3E1] text-[#822021]">
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
                                <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#FFBE8E] text-[#822021]">1</span>
                                Telusuri kurasi workshop terbaru.
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#FFBE8E] text-[#822021]">2</span>
                                Kelola riwayat pendaftaran & status pembayaran.
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#FFBE8E] text-[#822021]">3</span>
                                Dapatkan notifikasi otomatis melalui email.
                            </li>
                        </ul>
                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="rounded-[36px] bg-white/80 backdrop-blur shadow-xl ring-1 ring-[#FFBE8E]/60 p-10">

                        <div class="mb-8 space-y-2">
                            <h2 class="text-2xl font-semibold text-[#822021]">Buat Akun Baru</h2>
                            <p class="text-sm text-[#B49F9A]">
                                Isi data berikut untuk mulai mendaftar workshop Kreasi Hangat.
                            </p>
                            <p class="text-xs text-[#FFB3E1]">
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
                                <label for="name" class="text-sm font-medium text-[#822021]">Nama Lengkap</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name"
                                       class="w-full rounded-2xl border border-[#FFBE8E] bg-white/80 px-4 py-3 text-sm text-[#822021]
                                       focus:ring-2 focus:ring-[#FFB3E1]" required>
                                <p id="name-feedback" class="text-xs text-[#FFB3E1] min-h-[18px]" aria-live="polite"></p>
                            </div>

                            {{-- EMAIL --}}
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-medium text-[#822021]">Alamat E-mail</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                                       class="w-full rounded-2xl border border-[#FFBE8E] bg-white/80 px-4 py-3 text-sm text-[#822021]
                                       focus:ring-2 focus:ring-[#FFB3E1]" required>
                                <p id="email-feedback" class="text-xs text-[#FFB3E1] min-h-[18px]" aria-live="polite"></p>
                            </div>

                            {{-- PASSWORD --}}
                            <div class="space-y-2">
                                <label for="password" class="text-sm font-medium text-[#822021]">Kata Sandi</label>
                                <input id="password" type="password" name="password" autocomplete="new-password"
                                       class="w-full rounded-2xl border border-[#FFBE8E] bg-white/80 px-4 py-3 text-sm text-[#822021]
                                       focus:ring-2 focus:ring-[#FFB3E1]" required>
                                <div class="flex items-center gap-3">
                                    <div class="h-2 flex-1 rounded-full bg-[#FFBE8E]/30 overflow-hidden">
                                        <div id="password-strength-bar" class="h-full w-0 bg-[#FFB3E1] transition-all duration-300"></div>
                                    </div>
                                    <span id="password-strength-label" class="text-xs text-[#B49F9A]">Kekuatan sandi</span>
                                </div>
                                <p class="text-xs text-[#B49F9A]">
                                    Min. 8 karakter dengan huruf besar, angka, dan simbol.
                                </p>
                                <p id="password-feedback" class="text-xs text-[#FFB3E1] min-h-[18px]" aria-live="polite"></p>
                            </div>

                            {{-- PASSWORD CONFIRM --}}
                            <div class="space-y-2">
                                <label for="password_confirmation" class="text-sm font-medium text-[#822021]">Konfirmasi Kata Sandi</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
                                       class="w-full rounded-2xl border border-[#FFBE8E] bg-white/80 px-4 py-3 text-sm text-[#822021]
                                       focus:ring-2 focus:ring-[#FFB3E1]" required>
                                <p id="confirm-feedback" class="text-xs text-[#FFB3E1] min-h-[18px]" aria-live="polite"></p>
                            </div>

                            {{-- RECAPTCHA --}}
                            <div class="mt-2 flex justify-center">
                                {!! NoCaptcha::display() !!}
                                @error('g-recaptcha-response')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- SUBMIT --}}
                            <button type="submit"
                                id="register-submit"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-[#FFB3E1] px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-[#e89dd1] disabled:opacity-70 disabled:cursor-not-allowed">
                                <svg id="submit-spinner" class="h-4 w-4 animate-spin text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                <span id="submit-text">Daftar Sekarang</span>
                            </button>
                        </form>

                        {{-- DIVIDER --}}
                        <div class="mt-6 flex items-center gap-3">
                            <div class="flex-1 border-t border-[#FFBE8E]"></div>
                            <span class="text-xs text-[#B49F9A]">ATAU</span>
                            <div class="flex-1 border-t border-[#FFBE8E]"></div>
                        </div>

                        {{-- SIGN UP WITH GOOGLE --}}
                        <a href="{{ route('google.redirect', ['action' => 'register']) }}"
                           class="mt-6 flex w-full items-center justify-center gap-2 rounded-full border border-[#FFBE8E]
                           bg-white/50 px-6 py-3 text-sm font-semibold text-[#822021] hover:bg-white/80 transition">

                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="h-5 w-5" />
                            Daftar dengan Google
                        </a>

                        {{-- LOGIN LINK --}}
                        <div class="mt-8 text-center text-sm text-[#B49F9A]">
                            <span>Sudah punya akun? </span>
                            <a href="{{ route('login') }}"
                                class="font-semibold text-[#FFB3E1] hover:text-[#e89dd1] transition">
                                Masuk di sini
                            </a>
                        </div>

                    </div>
                </div>

                {{-- BACK TO HOME --}}
                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#822021] hover:text-[#6b1a1b] mt-6">
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
            'mailinator.com',
            '10minutemail.com',
            'guerrillamail.com',
            'temp-mail.org',
            'yopmail.com',
            'getnada.com',
            'trashmail.com',
            'fakemail.net',
            'dispostable.com',
        ];

        const setFeedback = (input, target, message = '', isValid = true) => {
            if (!target) return;
            target.textContent = message;
            if (input) {
                input.style.borderColor = isValid ? '#FFBE8E' : '#ef4444';
            }
            target.style.color = isValid ? '#FFB3E1' : '#BA1B1D';
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
