<x-layouts.app :title="'Verifikasi Email'">
    <section class="bg-gradient-to-b from-[#FFF6ED] via-[#FFE3D4] to-[#F7BFA5] py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-[36px] bg-white/80 backdrop-blur shadow-xl ring-1 ring-[#F7C8B8]/60 p-8 md:p-12">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="space-y-2">
                        <p class="text-xs uppercase tracking-[0.35em] text-[#D97862]">Verifikasi Email</p>
                        <h1 class="text-3xl font-semibold text-[#7C3A2D]">Konfirmasi identitas kamu</h1>
                        <p class="text-sm text-[#9A5A46]">
                            Masukkan kode OTP 6-digit yang kami kirim ke <span class="font-semibold text-[#7C3A2D]">{{ $user->email }}</span>.
                            Kode berlaku 15 menit.
                        </p>
                    </div>
                    <div class="inline-flex items-center gap-2 rounded-full bg-[#FFE8DB] px-4 py-2 text-[#D97862]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">Email belum diverifikasi</span>
                    </div>
                </div>

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

                <form method="POST" action="{{ route('verification.verify') }}" class="mt-8 space-y-6" id="otp-form">
                    @csrf
                    <div class="space-y-2">
                        <label for="otp" class="text-sm font-medium text-[#7C3A2D]">Kode OTP</label>
                        <input id="otp" name="otp" type="text" inputmode="numeric" maxlength="6" pattern="[0-9]*" autofocus
                               class="w-full rounded-2xl border border-[#F7C8B8] bg-white/80 px-4 py-3 text-center text-lg tracking-[0.5em] text-[#7C3A2D] focus:ring-2 focus:ring-[#F5A38D]"
                               placeholder="••••••" required>
                        <p class="text-xs text-[#9A5A46]">Tidak menerima email? Periksa folder spam atau kirim ulang kode.</p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <button type="submit" id="otp-submit"
                                class="inline-flex items-center justify-center gap-2 rounded-full bg-[#D97862] px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-[#b9644f] disabled:opacity-70 disabled:cursor-not-allowed">
                            <svg id="otp-spinner" class="h-4 w-4 animate-spin text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            <span id="otp-submit-text">Verifikasi & Masuk</span>
                        </button>

                        <button type="submit" form="resend-form"
                                class="inline-flex items-center justify-center gap-2 rounded-full border border-[#F7C8B8] bg-white/60 px-5 py-3 text-sm font-semibold text-[#7C3A2D] hover:bg-white transition"
                                onclick="this.disabled=true; setTimeout(() => this.disabled=false, 2000);">
                            Kirim Ulang Kode
                        </button>
                    </div>
                </form>

                <form id="resend-form" class="hidden" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                </form>

                <div class="mt-8 flex items-center justify-between text-sm text-[#9A5A46]">
                    <span>Ingin menggunakan email lain?</span>
                    <a href="{{ route('register') }}" class="font-semibold text-[#D97862] hover:text-[#b9644f] transition">Buat ulang akun</a>
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
