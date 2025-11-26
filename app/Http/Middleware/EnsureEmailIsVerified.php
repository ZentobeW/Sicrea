<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->isAdmin() && ! $user->hasVerifiedEmail()) {
            // Keep the user logged out of protected areas and send them back to verification page
            $request->session()->put('pending_verification_user_id', $user->id);

            return redirect()->route('verification.notice')
                ->withErrors(['email' => 'Verifikasi email dibutuhkan untuk melanjutkan.'])
                ->with('status', 'Silakan verifikasi email kamu terlebih dahulu.');
        }

        return $next($request);
    }
}
