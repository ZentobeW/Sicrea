<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Tampilkan tampilan reset kata sandi.
     */
    public function create(Request $request): View
    {
        // Tampilkan view reset-password.blade.php dengan token dari URL
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Tangani permintaan POST untuk memperbarui kata sandi.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            // Pastikan password baru minimal 8 karakter dan sesuai dengan konfirmasi
            'password' => ['required', 'confirmed', Rules\Password::defaults()], 
        ]);

        // Reset password. Laravel akan mengelola validasi token dan pembaruan password.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ]);
                $user->setRememberToken(null);
                $user->save();
            }
        );

        // Jika berhasil, arahkan ke halaman login dengan pesan sukses.
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        // Jika gagal, kembali dengan error.
        return back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}