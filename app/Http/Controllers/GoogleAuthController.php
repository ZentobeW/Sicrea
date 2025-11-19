<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    /**
     * Redirect user to Google OAuth consent screen
     */
    public function redirect(string $action = 'login'): RedirectResponse
    {
        $callbackRoute = $action === 'register' ? 'google.callback.register' : 'google.callback.login';
        
        $query = http_build_query([
            'client_id' => config('services.google.client_id'),
            'redirect_uri' => route($callbackRoute),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'access_type' => 'offline',
        ]);

        return redirect("https://accounts.google.com/o/oauth2/v2/auth?{$query}");
    }

    /**
     * Handle Google OAuth callback
     */
    public function callback(string $action = 'login'): RedirectResponse
    {
        $code = request('code');
        $state = request('state');

        if (!$code) {
            return redirect()->route('login')->withErrors(['oauth' => 'Google authentication failed.']);
        }

        try {
            $callbackRoute = $action === 'register' ? 'google.callback.register' : 'google.callback.login';
            
            // Exchange authorization code for access token
            $response = Http::post('https://oauth2.googleapis.com/token', [
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => route($callbackRoute),
            ]);

            $accessToken = $response->json('access_token');

            // Get user info from Google
            $userResponse = Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v2/userinfo');
            $googleUser = $userResponse->json();

            if (!isset($googleUser['email'])) {
                return redirect()->route('login')->withErrors(['oauth' => 'Unable to get email from Google.']);
            }

            // Handle Sign In
            if ($action === 'login') {
                $user = User::where('google_id', $googleUser['id'])
                    ->orWhere('email', $googleUser['email'])
                    ->first();

                if (!$user) {
                    return redirect()->route('login')->withErrors(['oauth' => 'No account found. Please register first.']);
                }

                // Update google_id if not set
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser['id'],
                        'oauth_provider' => 'google',
                    ]);
                }

                Auth::login($user);

                return redirect()->intended(route('home'))->with('status', 'Successfully signed in with Google!');
            }

            // Handle Sign Up
            if ($action === 'register') {
                // Check if email already exists
                $existingUser = User::where('email', $googleUser['email'])->first();
                if ($existingUser) {
                    return redirect()->route('register')->withErrors(['email' => 'Email already registered. Please login instead.']);
                }

                // Create new user
                $user = User::create([
                    'name' => $googleUser['name'] ?? 'User',
                    'email' => $googleUser['email'],
                    'google_id' => $googleUser['id'],
                    'oauth_provider' => 'google',
                    'password' => bcrypt(uniqid()), // Random password for OAuth users
                ]);

                event(new Registered($user));
                Auth::login($user);

                return redirect()->route('profile.edit')->with('status', 'Account created successfully! Please complete your profile.');
            }

            return redirect()->route('home');

        } catch (\Exception $e) {
            Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(['oauth' => 'Authentication failed. Please try again.']);
        }
    }
}
