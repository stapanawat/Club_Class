<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminContentController;
use App\Http\Controllers\Admin\AdminMemberController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminTagController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Auth\RegisterController;


/*
|--------------------------------------------------------------------------
| Social Login (Google / Line)
|--------------------------------------------------------------------------
| วางไว้นอก /admin และไม่อยู่ใน api.php
| เพื่อให้ URL เป็น:
| - /login/google
| - /login/line
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\SocialLoginController;


Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Email Verification Routes
use App\Http\Controllers\Auth\VerificationController;

Route::get('/email/verify', [VerificationController::class, 'notice'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::view('/verify-success', 'auth.verified')->name('verification.success');




// GOOGLE
Route::get('/login/google', [SocialLoginController::class, 'redirectToGoogle'])
    ->name('login.google');

Route::get('/login/google/callback', [SocialLoginController::class, 'handleGoogleCallback'])
    ->name('login.google.callback');

Route::view('/oauth/callback', 'oauth-callback');

// ---------- Social Login: LINE ----------

use App\Http\Controllers\Auth\LineAuthController;

// LINE Login
Route::get('/login/line', [LineAuthController::class, 'redirectToLine'])
    ->name('login.line');

Route::get('/login/line/callback', [LineAuthController::class, 'handleLineCallback'])
    ->name('login.line.callback');


Route::prefix('admin')->name('admin.')->group(function () {

    // ----- Admin Login -----
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('login.submit');

    // ----- Protected Admin Pages -----
    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('/logout', [AdminAuthController::class, 'logout'])
            ->name('logout');

        // Content CRUD
        Route::resource('contents', AdminContentController::class)
            ->names('contents')
            ->parameters(['contents' => 'content']);

        // Category CRUD
        Route::resource('categories', AdminCategoryController::class)
            ->names('categories')
            ->parameters(['categories' => 'category']);

        // Tag CRUD
        Route::resource('tags', AdminTagController::class)
            ->names('tags')
            ->parameters(['tags' => 'tag']);

        // Member Approvals
        Route::get('/members', [AdminMemberController::class, 'index'])
            ->name('members.index');

        Route::post('/members/{user}/approve', [AdminMemberController::class, 'approve'])
            ->name('members.approve');

        Route::post('/members/{user}/reject', [AdminMemberController::class, 'reject'])
            ->name('members.reject');

        // Payments
        Route::get('/payments', [AdminPaymentController::class, 'index'])
            ->name('payments.index');

        Route::post('/payments/{payment}/approve', [AdminPaymentController::class, 'approve'])
            ->name('payments.approve');

        Route::post('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])
            ->name('payments.reject');
    });
});


/*
|--------------------------------------------------------------------------
| SPA Fallback (Vue)
|--------------------------------------------------------------------------
| จะจับทุก route ที่ไม่ใช่:
| - /admin/*
| - /api/*
| - /storage/*
| - /build/*
| และจะส่งหน้า App.vue ให้ Vue Router handle
|--------------------------------------------------------------------------
*/

Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!admin|api|storage|build).*$');
