<x-layouts.app :title="'Daftar Workshop'">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-semibold text-slate-800 mb-6">Daftar Workshop: {{ $event->title }}</h1>

        <div class="bg-white border border-slate-100 rounded-xl shadow-sm p-6 space-y-6">
            <div class="grid md:grid-cols-2 gap-4 text-sm text-slate-600">
                <div>
                    <p class="font-semibold text-slate-700">Tanggal</p>
                    <p>{{ $event->start_at->translatedFormat('d M Y H:i') }} - {{ $event->end_at->translatedFormat('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="font-semibold text-slate-700">Lokasi</p>
                    <p>{{ $event->location }}</p>
                </div>
                <div>
                    <p class="font-semibold text-slate-700">Biaya</p>
                    <p>Rp{{ number_format($event->price, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="font-semibold text-slate-700">Kuota</p>
                    <p>{{ $event->available_slots ?? 'Tidak terbatas' }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('events.register.store', $event) }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                    <input type="text" name="form_data[name]" value="{{ old('form_data.name', auth()->user()->name) }}"
                        class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="form_data[email]" value="{{ old('form_data.email', auth()->user()->email) }}"
                        class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nomor Telepon</label>
                    <input type="text" name="form_data[phone]" value="{{ old('form_data.phone') }}"
                        class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Instansi / Perusahaan (opsional)</label>
                    <input type="text" name="form_data[company]" value="{{ old('form_data.company') }}"
                        class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('events.show', $event->slug) }}" class="text-sm text-slate-500 hover:text-slate-700">Batal</a>
                    <button class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Kirim Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
