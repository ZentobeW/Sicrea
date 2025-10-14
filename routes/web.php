<?php

use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

Route::middleware('auth')->group(function () {
    Route::get('/my/workshops', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/events/{event}/register', [RegistrationController::class, 'create'])->name('events.register');
    Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('events.register.store');

    Route::get('/registrations/{registration}', [RegistrationController::class, 'show'])->name('registrations.show');
    Route::post('/registrations/{registration}/payment-proof', [RegistrationController::class, 'uploadProof'])->name('registrations.payment-proof');

    Route::post('/registrations/{registration}/refund', [RefundController::class, 'store'])->name('registrations.refund.store');
});

Route::middleware(['auth', 'can:access-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('events', AdminEventController::class)->except(['show']);

    Route::get('registrations/export', [AdminRegistrationController::class, 'export'])->name('registrations.export');
    Route::post('registrations/{registration}/verify-payment', [AdminRegistrationController::class, 'verifyPayment'])->name('registrations.verify-payment');
    Route::post('registrations/{registration}/reject-payment', [AdminRegistrationController::class, 'rejectPayment'])->name('registrations.reject-payment');
    Route::post('refunds/{refund}/approve', [AdminRegistrationController::class, 'approveRefund'])->name('refunds.approve');
    Route::post('refunds/{refund}/reject', [AdminRegistrationController::class, 'rejectRefund'])->name('refunds.reject');
    Route::resource('registrations', AdminRegistrationController::class)->only(['index', 'show']);

    Route::resource('portfolios', AdminPortfolioController::class)->except(['show']);
});
