<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Tampilkan tampilan permintaan tautan reset kata sandi.
     */
    public function create(): View
    {
        return view('auth.forgot-password'); // Menggunakan view yang sudah Anda miliki
    }

    /**
     * Tangani permintaan POST untuk mengirim tautan reset kata sandi.
     */
    public function store(Request $request): RedirectResponse
    {
        // Gunakan validasi email standar
        $request->validate(['email' => 'required|email']);

        // Kirim tautan reset ke email. Laravel akan mengelola logic di belakang layar.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Jika berhasil
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        // Jika gagal
        return back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}