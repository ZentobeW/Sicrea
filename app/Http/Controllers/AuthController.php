<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('status', 'Successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Show the register form
     */
    public function showRegisterForm(): View
    {
        return view('auth.register', [
            'recaptcha_site_key' => config('services.recaptcha.site_key'),
        ]);
    }

    /**
     * Handle registration request with reCAPTCHA validation
     */
    public function register(Request $request): RedirectResponse
    {
        // <CHANGE> Validate reCAPTCHA token first
        $recaptchaToken = $request->input('g-recaptcha-response');
        
        if (!$recaptchaToken) {
            return back()->withErrors(['recaptcha' => 'Please verify that you are not a robot.'])->withInput();
        }

        // Verify reCAPTCHA token with Google
        $recaptchaResponse = Http::post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $recaptchaToken,
        ]);

        $recaptchaData = $recaptchaResponse->json();

        if (!$recaptchaData['success'] || ($recaptchaData['score'] ?? 0) < 0.5) {
            return back()->withErrors(['recaptcha' => 'reCAPTCHA verification failed. Please try again.'])->withInput();
        }

        // Validate form input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create new user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('profile.edit')->with('status', 'Account created successfully! Please complete your profile.');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Successfully logged out!');
    }
}
