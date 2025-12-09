<x-layouts.app :title="'Pengaturan Akun'">

    {{-- Custom Style (sama persis seperti edit profil) --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body, h1, h2, h3, p, a, span, div, label, input, textarea, button, select {
            font-family: 'Poppins', sans-serif !important;
        }

        .btn-action {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-action:hover {
            transform: scale(1.05);
            background-color: #FFBE8E !important;
            color: #822021 !important;
            border-color: #822021 !important;
        }

        /* Update button hover for the primary action to match register.blade.php */
        /* Default: BG 822021, Text FAF8F1 */
        /* Hover: Zoom, BG 822021/darker, Text FCF5E6 (using register style for primary) */
        #account-settings-submit:hover:not(:disabled) {
            transform: scale(1.05); /* Zoom In */
            background-color: #822021 !important; /* Keep the dark background */
            color: #FCF5E6 !important; /* Keep the light text */
            border-color: #822021 !important;
            box-shadow: 0 10px 15px -3px rgba(130, 32, 33, 0.3);
        }
    </style>

    <section class="bg-[#FCF5E6] py-16 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Tombol Kembali --}}
            <a href="{{ route('profile.edit') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-[#822021] hover:opacity-75 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Kembali
            </a>

            {{-- Container --}}
            <div class="rounded-3xl border border-[#822021] bg-[#FAF8F1] p-8 shadow-xl shadow-[#822021]/10">

                <div class="flex flex-col gap-2 text-center md:text-left">
                    <p class="text-sm uppercase tracking-[0.35em] text-[#822021]/60 font-semibold">Pengaturan</p>
                    <h1 class="text-3xl font-bold text-[#822021]">Akun</h1>
                    <p class="text-sm text-[#822021]/80">Ubah email & kata sandi akun Anda.</p>
                </div>

                {{-- Tabs Menu - Disamakan --}}
                <div class="mt-6 flex flex-wrap gap-3 justify-center md:justify-start">
                    <a href="{{ route('profile.edit') }}"
                        class="btn-action inline-flex items-center gap-2 rounded-full border border-[#822021] bg-[#FFDEF8] px-5 py-2 text-sm font-semibold text-[#822021] shadow-md cursor-pointer">
                        Data Pribadi
                    </a>

                    <button type="button"
                        class="btn-action inline-flex items-center gap-2 rounded-full bg-[#822021] text-[#FAF8F1] px-5 py-2 text-sm font-semibold shadow-md border border-[#822021] cursor-pointer">
                        Akun
                    </button>
                </div>

                {{-- FORM --}}
                {{-- Tambah ID dan novalidate --}}
                <form id="account-settings-form" method="POST" action="{{ route('account.update') }}" class="mt-10 space-y-8" novalidate>
                    @csrf
                    @method('PUT')

                    {{-- Email --}}
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-bold text-[#822021]">Email Baru</label>

                        {{-- Hapus inline error class, gunakan border-[#822021]/40 default --}}
                        <input id="email" name="email" type="email"
                            value="{{ old('email', $user->email) }}" autocomplete="email" required
                            class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021]
                            placeholder:text-[#822021]/40
                            focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20">
                        
                        {{-- Tambah feedback element (juga menampilkan error Laravel jika ada) --}}
                        <p id="email-feedback" class="text-xs text-[#BA1B1D] min-h-[18px]" aria-live="polite">
                            @error('email') {{ $message }} @enderror
                        </p>
                    </div>

                    {{-- Password (baru & konfirmasi) --}}
                    <div class="grid sm:grid-cols-2 gap-6">

                        {{-- Password baru --}}
                        <div class="space-y-2">
                            <label for="password" class="text-sm font-bold text-[#822021]">Kata Sandi Baru</label>

                            {{-- Hapus inline error class, gunakan border-[#822021]/40 default --}}
                            <input id="password" name="password" type="password" autocomplete="new-password"
                                class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021]
                                placeholder:text-[#822021]/40
                                focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20">

                            {{-- Password Strength from register.blade.php --}}
                            <div class="flex items-center gap-3">
                                <div class="h-2 flex-1 rounded-full bg-[#822021]/10 overflow-hidden">
                                    <div id="password-strength-bar" class="h-full w-0 bg-[#822021] transition-all duration-300"></div>
                                </div>
                                <span id="password-strength-label" class="text-xs text-[#822021]/60">Kekuatan sandi</span>
                            </div>
                            
                            {{-- Tambah feedback element (juga menampilkan error Laravel jika ada) --}}
                            <p id="password-feedback" class="text-xs text-[#BA1B1D] min-h-[18px]" aria-live="polite">
                                @error('password') {{ $message }} @enderror
                            </p>
                        </div>

                        {{-- Konfirmasi password --}}
                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-sm font-bold text-[#822021]">Konfirmasi Kata Sandi</label>

                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                                class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021]
                                placeholder:text-[#822021]/40
                                focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20">
                            
                            {{-- Tambah feedback element --}}
                            <p id="confirm-feedback" class="text-xs text-[#BA1B1D] min-h-[18px]" aria-live="polite"></p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end pt-4 border-t border-[#822021]/10">

                        <a href="{{ route('profile.edit') }}"
                            class="inline-flex items-center justify-center rounded-full border border-[#822021]/40 px-6 py-3 text-sm font-bold text-[#822021] hover:bg-[#FFDEF8] transition">
                            Batal
                        </a>

                        {{-- Tambah ID dan Spinner --}}
                        <button type="submit"
                            id="account-settings-submit"
                            class="btn-action inline-flex items-center justify-center gap-2 rounded-full bg-[#822021] border border-[#822021] px-6 py-3 text-sm font-bold text-[#FAF8F1] shadow-md cursor-pointer disabled:opacity-70 disabled:cursor-not-allowed">
                            <svg id="submit-spinner" class="h-4 w-4 animate-spin text-[#FAF8F1] hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            <span id="submit-text">Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('account-settings-form');
        if (!form) return;

        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const submitBtn = document.getElementById('account-settings-submit');
        const submitSpinner = document.getElementById('submit-spinner');
        const submitText = document.getElementById('submit-text');
        const strengthBar = document.getElementById('password-strength-bar');
        const strengthLabel = document.getElementById('password-strength-label');

        const feedback = {
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
            // Reset to default label if score is 0 (input empty)
            strengthLabel.textContent = score === 0 && passwordInput.value === '' ? 'Kekuatan sandi' : (labels[score] ?? 'Kekuatan sandi');
        };

        const validateEmail = () => {
            const value = emailInput.value.trim();
            const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let message = '';
            let isValid = pattern.test(value);

            // Email is required
            if (!value) {
                isValid = false;
                message = 'Alamat email wajib diisi.';
            }

            if (isValid) {
                const domain = value.split('@')[1]?.toLowerCase();
                if (domain && disposableDomains.includes(domain)) {
                    isValid = false;
                    message = 'Gunakan email permanen, bukan temporary email.';
                }
            } else if (value.length) {
                message = 'Format email belum benar.';
            }

            setFeedback(emailInput, feedback.email, message, isValid);
            return isValid;
        };

        // Disesuaikan untuk kasus opsional pada update akun
        const validatePassword = () => {
            const value = passwordInput.value;
            const confirmValue = confirmInput.value;
            
            // Case 1: Both password fields are empty (Valid, user is not changing password)
            if (value === '' && confirmValue === '') {
                renderStrength(0);
                setFeedback(passwordInput, feedback.password, '', true);
                return true;
            }

            // Case 3: Both are filled, proceed with complexity check
            const score = passwordScore(value);
            renderStrength(score);

            const requirements = [];
            if (value.length < 8) requirements.push('8 karakter');
            if (!/[A-Z]/.test(value) || !/[a-z]/.test(value)) requirements.push('huruf besar & kecil');
            if (!/\d/.test(value)) requirements.push('angka');
            if (!/[^A-Za-z0-9]/.test(value)) requirements.push('simbol');

            const isValid = requirements.length === 0;
            const message = isValid ? '' : `Tambahkan ${requirements.join(', ')}.`;

            setFeedback(passwordInput, feedback.password, message, isValid);
            return isValid;
        };

        // Disesuaikan untuk kasus opsional pada update akun
        const validateConfirm = () => {
            const passwordValue = passwordInput.value;
            const confirmValue = confirmInput.value;
            
            // Case 1: Both empty (Valid, user is not changing password)
            if (passwordValue === '' && confirmValue === '') {
                setFeedback(confirmInput, feedback.confirm, '', true);
                return true;
            }
            
            // Case 2: Only one filled (Invalid)
            if (passwordValue === '' && confirmValue !== '') {
                 setFeedback(confirmInput, feedback.confirm, 'Kata sandi baru wajib diisi.', false);
                 return false;
            }
            
            if (passwordValue !== '' && confirmValue === '') {
                 setFeedback(confirmInput, feedback.confirm, 'Konfirmasi kata sandi wajib diisi.', false);
                 return false;
            }

            // Case 3: Both present, check match
            const isValid = passwordValue === confirmValue;
            const message = isValid ? '' : 'Konfirmasi kata sandi belum cocok.';
            setFeedback(confirmInput, feedback.confirm, message, isValid);
            return isValid;
        };

        emailInput?.addEventListener('input', validateEmail);
        
        passwordInput?.addEventListener('input', () => {
            validatePassword();
            validateConfirm();
        });
        
        confirmInput?.addEventListener('input', validateConfirm);

        form.addEventListener('submit', (event) => {
            const allValid = [validateEmail(), validatePassword(), validateConfirm()].every(Boolean);
            
            if (!allValid) {
                event.preventDefault();
                return;
            }

            submitBtn.disabled = true;
            submitSpinner.classList.remove('hidden');
            submitText.textContent = 'Memproses...';
        });

        // Initial checks to ensure server errors are properly styled
        validateEmail();
        validatePassword();
        validateConfirm();
    });
</script>
@endpush
</x-layouts.app>