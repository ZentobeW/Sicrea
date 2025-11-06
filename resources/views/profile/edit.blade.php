<x-layouts.app :title="'Edit Profil'">
    @php
        $avatarUrl = $user->avatar_path
            ? Storage::disk('public')->url($user->avatar_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=FFE1D0&color=7C3A2D';
    @endphp

    <section class="bg-gradient-to-b from-[#FFF2E7] via-[#FFE2CF] to-[#F8C0A7] py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#7C3A2D] hover:text-[#5c261d]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Profil
            </a>

            <div class="rounded-3xl bg-white/90 p-8 shadow-xl shadow-[#F4B59E]/40 ring-1 ring-[#F7C8B8]/60">
                <div class="flex flex-col gap-2">
                    <p class="text-sm uppercase tracking-[0.35em] text-[#D97862]">Kelola Profil</p>
                    <h1 class="text-3xl font-semibold text-[#7C3A2D]">Edit Profil</h1>
                    <p class="text-sm text-[#9A5A46]">Perbarui informasi pribadi Anda agar proses pendaftaran event semakin mudah.</p>
                </div>

                <div class="mt-6 flex flex-wrap gap-3">
                    <button type="button" class="rounded-full bg-[#D97862] px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-[#D97862]/30">Data Pribadi</button>
                    <button type="button" class="rounded-full bg-[#FFF1EC] px-5 py-2 text-sm font-semibold text-[#C99F92] cursor-not-allowed">Akun</button>
                    <button type="button" class="rounded-full bg-[#FFF1EC] px-5 py-2 text-sm font-semibold text-[#C99F92] cursor-not-allowed">Pengaturan</button>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-8 space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-8 lg:grid-cols-[auto,1fr]">
                        <div class="flex flex-col items-center gap-4">
                            <div class="relative">
                                <img src="{{ $avatarUrl }}" alt="Avatar {{ $user->name }}" class="h-32 w-32 rounded-full border-4 border-white object-cover shadow-lg shadow-[#F7C8B8]/70">
                                <label for="avatar"
                                    class="absolute bottom-0 right-0 inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-[#D97862] text-white shadow-lg shadow-[#D97862]/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.826 4.504A2.25 2.25 0 018.527 3h6.946a2.25 2.25 0 011.701.804l2.347 2.76a2.25 2.25 0 01.526 1.458v9.478a2.25 2.25 0 01-2.25 2.25H6.75a2.25 2.25 0 01-2.25-2.25V8.022a2.25 2.25 0 01.526-1.458l2.347-2.76z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 13.5l2.25 2.25L15 12" />
                                    </svg>
                                </label>
                                <input id="avatar" name="avatar" type="file" accept="image/*" class="hidden">
                            </div>
                            <p class="text-xs text-center text-[#9A5A46]">Unggah foto dengan format JPG/PNG ukuran maksimal 2MB.</p>
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="space-y-2 sm:col-span-2">
                                <label for="name" class="text-sm font-semibold text-[#7C3A2D]">Nama Lengkap</label>
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                                    class="w-full rounded-2xl border border-[#F7C8B8] bg-white/70 px-4 py-3 text-sm text-[#7C3A2D] placeholder:text-[#D9A497] focus:border-[#D97862] focus:outline-none focus:ring-2 focus:ring-[#F5A38D]">
                            </div>
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-semibold text-[#7C3A2D]">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full rounded-2xl border border-[#F7C8B8] bg-white/70 px-4 py-3 text-sm text-[#7C3A2D] placeholder:text-[#D9A497] focus:border-[#D97862] focus:outline-none focus:ring-2 focus:ring-[#F5A38D]">
                            </div>
                            <div class="space-y-2">
                                <label for="phone" class="text-sm font-semibold text-[#7C3A2D]">No. Telepon</label>
                                <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}"
                                    class="w-full rounded-2xl border border-[#F7C8B8] bg-white/70 px-4 py-3 text-sm text-[#7C3A2D] placeholder:text-[#D9A497] focus:border-[#D97862] focus:outline-none focus:ring-2 focus:ring-[#F5A38D]">
                            </div>
                            <div class="space-y-2">
                                <label for="birth_date" class="text-sm font-semibold text-[#7C3A2D]">Tanggal Lahir</label>
                                <input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date', optional($user->birth_date)->format('Y-m-d')) }}"
                                    class="w-full rounded-2xl border border-[#F7C8B8] bg-white/70 px-4 py-3 text-sm text-[#7C3A2D] placeholder:text-[#D9A497] focus:border-[#D97862] focus:outline-none focus:ring-2 focus:ring-[#F5A38D]">
                            </div>
                            <div class="space-y-2">
                                <label for="province" class="text-sm font-semibold text-[#7C3A2D]">Provinsi</label>
                                <input id="province" name="province" type="text" value="{{ old('province', $user->province) }}"
                                    class="w-full rounded-2xl border border-[#F7C8B8] bg-white/70 px-4 py-3 text-sm text-[#7C3A2D] placeholder:text-[#D9A497] focus:border-[#D97862] focus:outline-none focus:ring-2 focus:ring-[#F5A38D]">
                            </div>
                            <div class="space-y-2">
                                <label for="city" class="text-sm font-semibold text-[#7C3A2D]">Kabupaten/Kota</label>
                                <input id="city" name="city" type="text" value="{{ old('city', $user->city) }}"
                                    class="w-full rounded-2xl border border-[#F7C8B8] bg-white/70 px-4 py-3 text-sm text-[#7C3A2D] placeholder:text-[#D9A497] focus:border-[#D97862] focus:outline-none focus:ring-2 focus:ring-[#F5A38D]">
                            </div>
                            <div class="space-y-2 sm:col-span-2">
                                <label for="address" class="text-sm font-semibold text-[#7C3A2D]">Alamat Lengkap</label>
                                <textarea id="address" name="address" rows="3"
                                    class="w-full rounded-2xl border border-[#F7C8B8] bg-white/70 px-4 py-3 text-sm text-[#7C3A2D] placeholder:text-[#D9A497] focus:border-[#D97862] focus:outline-none focus:ring-2 focus:ring-[#F5A38D]">{{ old('address', $user->address) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                        <a href="{{ route('profile.show') }}" class="inline-flex items-center justify-center rounded-full border border-[#F7C8B8] px-6 py-3 text-sm font-semibold text-[#7C3A2D] hover:bg-white">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-[#D97862] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#D97862]/30 hover:bg-[#b9644f]">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
