<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminGiftController;
use App\Http\Controllers\AiSuggestionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// --- Guest Routes ---
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});


// --- Authenticated Routes ---
Route::middleware(['auth'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // --- Demo Verification Flow (post-signup) ---
    Route::get('/verify/email', [VerificationController::class, 'showEmailVerification'])->name('verify.email');
    Route::post('/verify/email', [VerificationController::class, 'verifyEmail'])->name('verify.email.submit');
    Route::get('/verify/phone', [VerificationController::class, 'showPhoneVerification'])->name('verify.phone');
    Route::post('/verify/phone', [VerificationController::class, 'verifyPhone'])->name('verify.phone.submit');
    Route::post('/verify/resend', [VerificationController::class, 'resendCode'])->name('verify.resend');

    // Dashboard with dynamic data
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Legacy email verification (Laravel built-in)
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard');
    })->middleware('signed')->name('verification.verify');


    Route::get('/gifts', [GiftController::class, 'index'])->name('gifts.index');

    // AI Gift Suggestions
    Route::get('/ai/suggestions', [AiSuggestionController::class, 'index'])->name('ai.suggestions');
    Route::post('/ai/suggestions', [AiSuggestionController::class, 'suggest'])->name('ai.suggestions.submit');

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');


    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/events/{event}/pay', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/events/{event}/pay', [PaymentController::class, 'store'])->name('payments.store');

    // --- Admin Routes ---
    Route::middleware([AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
        Route::post('/payments/{payment}/approve', [AdminController::class, 'approvePayment'])->name('payments.approve');
        Route::post('/payments/{payment}/reject', [AdminController::class, 'rejectPayment'])->name('payments.reject');

        Route::resource('gifts', AdminGiftController::class)->names('gifts');
    });
});
