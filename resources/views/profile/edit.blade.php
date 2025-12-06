@php
    use Illuminate\Support\Facades\Storage;
@endphp
<x-layouts.app :title="'Edit Profil'">
    @php
        $avatarUrl = $user->avatar_path
            ? Storage::disk('public')->url($user->avatar_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=FFE1D0&color=7C3A2D';
    @endphp

    {{-- Custom Style --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body, h1, h2, h3, p, a, span, div, label, input, textarea, button, select {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Button Hover Effect */
        .btn-action {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-action:hover {
            transform: scale(1.05);
            background-color: #FFBE8E !important;
            color: #822021 !important;
            border-color: #822021 !important;
        }
    </style>

    {{-- Main Background: FFDEF8 --}}
    <section class="bg-[#FFDEF8] py-16 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#822021] hover:opacity-75 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Profil
            </a>

            {{-- Container Utama: BG FAF8F1, Border 822021 --}}
            <div class="rounded-3xl border border-[#822021] bg-[#FAF8F1] p-8 shadow-xl shadow-[#822021]/10">
                <div class="flex flex-col gap-2 text-center md:text-left">
                    <p class="text-sm uppercase tracking-[0.35em] text-[#822021]/60 font-semibold">Kelola Profil</p>
                    <h1 class="text-3xl font-bold text-[#822021]">Edit Profil</h1>
                    <p class="text-sm text-[#822021]/80">Perbarui informasi pribadi Anda agar proses pendaftaran event semakin mudah.</p>
                </div>

                {{-- Tabs Menu --}}
                <div class="mt-6 flex flex-wrap gap-3 justify-center md:justify-start">
                    <button type="button" class="rounded-full bg-[#822021] px-5 py-2 text-sm font-semibold text-[#FAF8F1] shadow-md">Data Pribadi</button>
                    <button type="button" class="rounded-full border border-[#822021]/20 bg-[#FFDEF8] px-5 py-2 text-sm font-semibold text-[#822021]/60 cursor-not-allowed">Akun</button>
                    <button type="button" class="rounded-full border border-[#822021]/20 bg-[#FFDEF8] px-5 py-2 text-sm font-semibold text-[#822021]/60 cursor-not-allowed">Pengaturan</button>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-8 space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-8 lg:grid-cols-[auto,1fr]">
                        
                        {{-- Avatar Section --}}
                        <div class="flex flex-col items-center gap-4">
                            <div class="relative">
                                <img id="avatar-preview" src="{{ $avatarUrl }}" data-initial="{{ $avatarUrl }}" alt="Avatar {{ $user->name }}" class="h-32 w-32 rounded-full border-4 border-[#FFDEF8] object-cover shadow-lg">
                            </div>
                            <input id="avatar" name="avatar" type="file" accept="image/*" class="hidden" data-preview="avatar-preview" onchange="window.sicreaPreviewAvatar && window.sicreaPreviewAvatar(this)">
                            
                            <label for="avatar" class="btn-action inline-flex items-center gap-2 rounded-full bg-[#822021] px-4 py-2 text-sm font-semibold text-[#FAF8F1] shadow-md cursor-pointer border border-[#822021]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125L16.875 4.5" />
                                </svg>
                                Ganti Foto
                            </label>
                            
                            <p id="avatar-helper" class="text-xs text-center text-[#822021]/70 max-w-[150px]">Unggah foto JPG/PNG maksimal 2MB.</p>
                            @error('avatar')
                                <p class="text-xs text-red-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Form Inputs --}}
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="space-y-2 sm:col-span-2">
                                <label for="name" class="text-sm font-bold text-[#822021]">Nama Lengkap</label>
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                                    class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021] placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20">
                            </div>
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-bold text-[#822021]">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021] placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20">
                            </div>
                            <div class="space-y-2">
                                <label for="phone" class="text-sm font-bold text-[#822021]">No. Telepon</label>
                                <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}"
                                    class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021] placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20">
                            </div>
                            <div class="space-y-2">
                                <label for="birth_date" class="text-sm font-bold text-[#822021]">Tanggal Lahir</label>
                                <input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date', optional($user->birth_date)->format('Y-m-d')) }}"
                                    class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021] placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20">
                            </div>
                            <div class="space-y-2">
                                <label for="province" class="text-sm font-bold text-[#822021]">Provinsi</label>
                                <select id="province" name="province" required
                                    class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021] placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20">
                                    <option value="" disabled selected>Pilih provinsi</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label for="city" class="text-sm font-bold text-[#822021]">Kabupaten/Kota</label>
                                <select id="city" name="city" required
                                    class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021] placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20">
                                    <option value="" disabled selected>Pilih kabupaten/kota</option>
                                </select>
                            </div>
                            <div class="space-y-2 sm:col-span-2">
                                <label for="address" class="text-sm font-bold text-[#822021]">Alamat Lengkap</label>
                                <textarea id="address" name="address" rows="3"
                                    class="w-full rounded-2xl border border-[#822021]/40 bg-white px-4 py-3 text-sm text-[#822021] placeholder:text-[#822021]/40 focus:border-[#822021] focus:outline-none focus:ring-2 focus:ring-[#822021]/20">{{ old('address', $user->address) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end pt-4 border-t border-[#822021]/10">
                        <a href="{{ route('profile.show') }}" class="inline-flex items-center justify-center rounded-full border border-[#822021]/40 px-6 py-3 text-sm font-bold text-[#822021] hover:bg-[#FFDEF8] transition">
                            Batal
                        </a>
                        {{-- Button Simpan: Zoom Effect --}}
                        <button type="submit" class="btn-action inline-flex items-center justify-center rounded-full bg-[#822021] border border-[#822021] px-6 py-3 text-sm font-bold text-[#FAF8F1] shadow-md">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>

@once
    <script>
        // Script Preview Avatar & Wilayah (Logic sama persis, tidak ada perubahan)
        window.sicreaPreviewAvatar = function (input) {
            if (!input) { return; }
            const helper = document.getElementById('avatar-helper');
            const previewId = input.dataset.preview;
            const preview = previewId ? document.getElementById(previewId) : null;
            const initialSrc = preview?.dataset.initial ?? preview?.getAttribute('src');
            const [file] = input.files ?? [];

            if (file && preview) {
                const objectUrl = URL.createObjectURL(file);
                preview.src = objectUrl;
                preview.onload = () => URL.revokeObjectURL(objectUrl);
                if (helper) helper.textContent = 'Foto siap disimpan. Klik "Simpan Perubahan" untuk mengunggah.';
            } else if (preview && initialSrc) {
                preview.src = initialSrc;
                if (helper) helper.textContent = 'Unggah foto JPG/PNG maksimal 2MB.';
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city');
            const selectedProvinceName = @json(old('province', $user->province));
            const selectedCityName = @json(old('city', $user->city));
            let provinces = [];

            const setLoading = (select, message) => {
                select.innerHTML = `<option value=\"\" disabled selected>${message}</option>`;
            };

            const populateProvinces = () => {
                setLoading(provinceSelect, 'Memuat provinsi...');
                fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                    .then((res) => res.json())
                    .then((data) => {
                        provinces = data;
                        provinceSelect.innerHTML = '<option value=\"\" disabled selected>Pilih provinsi</option>';
                        provinces.forEach((province) => {
                            const option = document.createElement('option');
                            option.value = province.name;
                            option.textContent = province.name;
                            option.dataset.id = province.id;
                            provinceSelect.appendChild(option);
                        });

                        if (selectedProvinceName) {
                            const matched = provinces.find((p) => p.name === selectedProvinceName);
                            if (matched) {
                                provinceSelect.value = matched.name;
                                populateCities(matched.id);
                            }
                        }
                    })
                    .catch(() => {
                        provinceSelect.innerHTML = '<option value=\"\" disabled selected>Gagal memuat provinsi</option>';
                    });
            };

            const populateCities = (provinceId) => {
                setLoading(citySelect, 'Memuat kabupaten/kota...');
                if (!provinceId) {
                    citySelect.innerHTML = '<option value=\"\" disabled selected>Pilih kabupaten/kota</option>';
                    return;
                }

                fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
                    .then((res) => res.json())
                    .then((data) => {
                        citySelect.innerHTML = '<option value=\"\" disabled selected>Pilih kabupaten/kota</option>';
                        data.forEach((city) => {
                            const option = document.createElement('option');
                            option.value = city.name;
                            option.textContent = city.name;
                            option.dataset.id = city.id;
                            citySelect.appendChild(option);
                        });

                        if (selectedCityName) {
                            const matchedCity = data.find((c) => c.name === selectedCityName);
                            if (matchedCity) {
                                citySelect.value = matchedCity.name;
                            }
                        }
                    })
                    .catch(() => {
                        citySelect.innerHTML = '<option value=\"\" disabled selected>Gagal memuat kabupaten/kota</option>';
                    });
            };

            if (provinceSelect && citySelect) {
                populateProvinces();
                provinceSelect.addEventListener('change', (event) => {
                    const selectedOption = event.target.selectedOptions[0];
                    const provinceId = selectedOption?.dataset.id;
                    citySelect.value = '';
                    populateCities(provinceId);
                });
            }
        });
    </script>
@endonce