<x-layouts.app :title="'Reset Kata Sandi'">

<section class="bg-gradient-to-b from-[#FFF3E8] via-[#FFE1D0] to-[#F7BFA5] py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-center">
        <div class="w-full max-w-lg rounded-[36px] bg-white/80 backdrop-blur shadow-xl ring-1 ring-[#F7C8B8]/60 p-10">

            {{-- TITLE --}}
            <div class="text-center mb-8">
                <h2 class="text-2xl font-semibold text-[#7C3A2D]">Atur Kata Sandi Baru</h2>
                <p class="text-sm text-[#9A5A46] mt-1">
                    Masukkan kata sandi baru untuk akun Anda.
                </p>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf

                {{-- TOKEN --}}
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- EMAIL (Hidden/Prefilled) --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium text-[#7C3A2D]">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $request->email) }}" required
                        class="w-full rounded-2xl border border-[#F7C8B8] bg-white/70 px-4 py-3 text-sm text-[#7C3A2D]
                        placeholder:text-[#D9A497] focus:border-[#D97862] focus:ring-2 focus:ring-[#F5A38D] focus:outline-none">
                    @error('email')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PASSWORD BARU --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium text-[#7C3A2D]">Kata Sandi Baru</label>
                    <input type="password" name="password" required
                        class="w-full rounded-2xl border border-[#F7C8B8] bg-white/70 px-4 py-3 text-sm text-[#7C3A2D]
                        placeholder:text-[#D9A497] focus:border-[#D97862] focus:ring-2 focus:ring-[#F5A38D] focus:outline-none">
                    @error('password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- KONFIRMASI PASSWORD --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium text-[#7C3A2D]">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full rounded-2xl border border-[#F7C8B8] bg-white/70 px-4 py-3 text-sm text-[#7C3A2D]
                        placeholder:text-[#D9A497] focus:border-[#D97862] focus:ring-2 focus:ring-[#F5A38D] focus:outline-none">
                </div>

                {{-- SUBMIT --}}
                <button type="submit"
                    class="w-full rounded-full bg-[#D97862] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#D97862]/20
                    hover:bg-[#b9644f] hover:scale-[1.02] active:scale-[0.98] transition">
                    Reset Kata Sandi
                </button>
            </form>

            {{-- BACK --}}
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}"
                    class="text-sm font-semibold text-[#D97862] hover:text-[#b9644f] transition">
                    Kembali ke Login
                </a>
            </div>

        </div>
    </div>
</section>

</x-layouts.app>