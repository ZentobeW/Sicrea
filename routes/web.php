<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Auth\PasswordResetLinkController; 
use App\Http\Controllers\Auth\NewPasswordController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestSendGridMail;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio.index');
Route::get('/partnership', [PageController::class, 'partnership'])->name('partnership.index');
Route::get('/about', [PageController::class, 'about'])->name('about.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

/*
|--------------------------------------------------------------------------
| Authentication (Guest Only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');

    // Email verification with OTP
    Route::get('/verify-email', [EmailVerificationController::class, 'show'])->name('verification.notice');
    Route::post('/verify-email', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('throttle:6,1');
    Route::post('/verify-email/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend')->middleware('throttle:3,1');

    // Lupa password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
    
    // Google OAuth (login / register)
    Route::get('/auth/google/{action?}', [GoogleAuthController::class, 'redirect'])
        ->whereIn('action', ['login', 'register'])
        ->name('google.redirect');

    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
        ->name('google.callback');
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| User Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified.email'])->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Registrations (workshops)
    Route::get('/my/workshops', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/events/{event}/register', [RegistrationController::class, 'create'])->name('events.register');
    Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('events.register.store');

    Route::get('/registrations/{registration}', [RegistrationController::class, 'show'])->name('registrations.show');
    Route::post('/registrations/{registration}/payment-proof', [RegistrationController::class, 'uploadProof'])
        ->name('registrations.payment-proof');
    Route::post('/registrations/{registration}/expire', [RegistrationController::class, 'expire'])
        ->name('registrations.expire');

    Route::get('/registrations/{registration}/refund', [RefundController::class, 'create'])
        ->name('registrations.refund.create');
    Route::post('/registrations/{registration}/refund', [RefundController::class, 'store'])
        ->name('registrations.refund.store');

    // Account Settings (Email & Password)
    Route::get('/account/settings', [ProfileController::class, 'accountSettings'])
        ->name('account.settings');

    Route::put('/account/settings', [ProfileController::class, 'updateAccount'])
        ->name('account.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified.email', 'can:access-admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Events
        Route::resource('events', AdminEventController::class)->except(['show']);

        // Registrations
        Route::get('registrations/export', [AdminRegistrationController::class, 'export'])
            ->name('registrations.export');
        Route::post('registrations/{registration}/verify-payment', [AdminRegistrationController::class, 'verifyPayment'])
            ->name('registrations.verify-payment');
        Route::post('registrations/{registration}/reject-payment', [AdminRegistrationController::class, 'rejectPayment'])
            ->name('registrations.reject-payment');

        // Refund
        Route::post('refunds/{refund}/approve', [AdminRegistrationController::class, 'approveRefund'])
            ->name('refunds.approve');
        Route::post('refunds/{refund}/reject', [AdminRegistrationController::class, 'rejectRefund'])
            ->name('refunds.reject');

        Route::resource('registrations', AdminRegistrationController::class)->only(['index', 'show']);

        // Portfolio
        Route::resource('portfolios', AdminPortfolioController::class)->except(['show']);

        // Reports
        Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    });

/*
|--------------------------------------------------------------------------
| SENDGRID SMTP TEST ROUTE (Development Mode)
|--------------------------------------------------------------------------
*/
//Route::get('/test-email', function (Request $request) {
//    if (! app()->environment(['local', 'development', 'testing'])) {
//        abort(404);
//    }
//
//    $to = $request->string('to')->value()
//        ?: config('mail.test_recipient')
//        ?: config('mail.admin_address')
//        ?: config('mail.from.address');
//
//    if (! $to) {
//        return 'Set MAIL_TEST_RECIPIENT di .env atau tambahkan parameter ?to=email@domain.test';
//    }
//
//    Mail::to($to)->send(new TestSendGridMail());
//
//    return "Email test berhasil dikirim ke {$to}!";
//});

Route::get('/test-email', function (Request $request) {
    $recipient = $request->string('to')->value()
        ?: config('mail.test_recipient')
        ?: config('mail.admin_address')
        ?: config('mail.from.address');

    if (! $recipient) {
        return 'Set MAIL_TEST_RECIPIENT di .env atau tambahkan parameter ?to=email@domain.test';
    }

    Mail::raw('Test email via SMTP (Laravel)', function ($msg) use ($recipient) {
        $msg->to($recipient)
            ->subject('SMTP Testing');
    });

    return "Email test terkirim ke {$recipient}!";
});
