<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    /**
     * Redirect ke Google OAuth
     */
    public function redirect(string $action = 'login'): RedirectResponse
    {
        // Simpan action ke session agar dipakai di callback
        Session::put('google_action', $action);

        return Socialite::driver('google')->redirect();
    }

    /**
     * Callback Google OAuth (1 endpoint untuk login & register)
     */
    public function callback(): RedirectResponse
    {
        try {
            // Ambil action dari session
            $action = Session::get('google_action', 'login');

            // Ambil data user Google
            $googleUser = Socialite::driver('google')->user();

            $googleId = $googleUser->getId();
            $email    = $googleUser->getEmail();
            $name     = $googleUser->getName() ?? 'User';

            if (!$email) {
                return redirect()->route('login')
                    ->withErrors(['oauth' => 'Google account does not have an email.']);
            }

            /* =====================================================
             | CASE 1 → LOGIN FLOW
             ===================================================== */
            if ($action === 'login') {

                // Cari user berdasarkan google_id atau email
                $user = User::where('google_id', $googleId)
                    ->orWhere('email', $email)
                    ->first();

                // User tidak ada → suruh daftar dulu
                if (!$user) {
                    return redirect()->route('register')
                        ->withErrors(['oauth' => 'Akun tidak ditemukan. Silakan daftar terlebih dahulu.']);
                }

                // Jika email cocok tapi google_id belum tersimpan → sambungkan Google
                if (!$user->google_id) {
                    $user->update([
                        'google_id'      => $googleId,
                        'oauth_provider' => 'google',
                        'email_verified_at' => now(),
                    ]);
                } elseif (! $user->hasVerifiedEmail()) {
                    $user->markEmailAsVerified();
                }

                // Login user
                Auth::login($user);

                return redirect()->intended(route('home'))
                    ->with('status', 'Berhasil masuk dengan Google!');
            }


            /* =====================================================
             | CASE 2 → REGISTER FLOW
             ===================================================== */
            if ($action === 'register') {

                // Email sudah ada → minta login
                if (User::where('email', $email)->exists()) {
                    return redirect()->route('login')
                        ->withErrors(['email' => 'Email sudah terdaftar. Silakan login.']);
                }

                // Buat pengguna baru dengan Google
                $user = User::create([
                    'name'           => $name,
                    'email'          => $email,
                    'google_id'      => $googleId,
                    'oauth_provider' => 'google',
                    'password'       => Hash::make(uniqid()), // random password
                    'email_verified_at' => now(),
                ]);

                event(new Registered($user));
                Auth::login($user);

                return redirect()->route('profile.edit')
                    ->with('status', 'Akun berhasil dibuat menggunakan Google!');
            }

            // fallback
            return redirect()->route('home');

        } catch (\Exception $e) {

            Log::error('Google OAuth Error: ' . $e->getMessage());

            return redirect()->route('login')
                ->withErrors(['oauth' => 'Google authentication failed. Coba lagi.']);
        }
    }
}
