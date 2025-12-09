<?php

namespace App\Http\Controllers;

use App\Rules\DisposableEmail;
use App\Services\EmailOtpService;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function __construct(
        private readonly EmailOtpService $otpService
    ) {
    }

    /**
     * Show the login form
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'g-recaptcha-response' => ['required', 'captcha']
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('home'))
                ->with('status', 'Successfully logged in!');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    /**
     * Show register form
     */
    public function showRegisterForm(): View
    {
        return view('auth.register'); // No need to pass site key manually; NoCaptcha handles it
    }

    /**
     * Handle register with reCAPTCHA validation
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:users', new DisposableEmail],
            'password' => [
                'required',
                Password::min(8)->mixedCase()->numbers()->symbols(),
                'confirmed',
            ],
            'website' => ['present', 'max:0'],
            'g-recaptcha-response' => ['required', 'captcha'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $this->otpService->send($user);
        $request->session()->put('pending_verification_user_id', $user->id);

        return redirect()
            ->route('verification.notice')
            ->with('status', 'Akun dibuat. Kami mengirim OTP ke email kamu untuk verifikasi.');
    }

    /**
     * Logout
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('status', 'Successfully logged out!');
    }
}
