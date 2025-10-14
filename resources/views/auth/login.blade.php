<x-layouts.app :title="'Masuk'">
    <div class="max-w-md mx-auto bg-white shadow-sm rounded-xl border border-slate-200 p-8">
        <h1 class="text-2xl font-semibold text-slate-800 mb-6">Masuk ke Akun</h1>
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Alamat E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Kata Sandi</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div class="flex items-center justify-between text-sm">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-slate-600">Ingat saya</span>
                </label>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700">Belum punya akun?</a>
                @endif
            </div>
            <div>
                <button type="submit" class="w-full inline-flex justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Masuk
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
