<x-layouts.app :title="'Daftar'">
    <div class="max-w-md mx-auto bg-white shadow-sm rounded-xl border border-slate-200 p-8">
        <h1 class="text-2xl font-semibold text-slate-800 mb-6">Buat Akun Baru</h1>
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="mt-1 block w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Alamat E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Kata Sandi</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Konfirmasi Kata Sandi</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="mt-1 block w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div class="text-sm text-slate-600">
                Sudah punya akun?
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700">Masuk di sini</a>
                @endif
            </div>
            <div>
                <button type="submit" class="w-full inline-flex justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Daftar
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
