<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Api\ContentApiController;
use App\Http\Controllers\Admin\AdminContentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminTagController;
use App\Http\Controllers\Admin\AdminPaymentController;


// =======================
// 🔐 Auth
// =======================
Route::post('/register', [RegisterController::class, 'register'])->name('api.register');
Route::post('/login', [LoginController::class, 'login'])->name('api.login');


// =======================
// 🌐 Public Content List
// =======================
Route::get('/contents', [ContentApiController::class, 'index']);
Route::get('/categories', [ContentApiController::class, 'getCategories']);
Route::get('/tags', [ContentApiController::class, 'getTags']);
Route::get('/contents/{slug}', [ContentApiController::class, 'showBySlug']);


// =======================
// 🔐 Protected Routes
// =======================
Route::middleware('auth:sanctum')->group(function () {

    // User Info
    Route::get('/me', function (Request $request) {
        $user = $request->user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'membership_status' => $user->membership_status,
            'provider' => $user->provider,
            'provider_id' => $user->provider_id,
        ]);
    });



    Route::middleware('auth:sanctum')->post('/subscription/start', [SubscriptionController::class, 'start']);


    // Subscription / Payment
    Route::post('/payment', [PaymentController::class, 'store']);

    // Admin
    Route::middleware('can:is-admin')->group(function () {
        Route::apiResource('admin/categories', AdminCategoryController::class);
        Route::apiResource('admin/tags', AdminTagController::class);

        Route::get('/admin/contents', [AdminContentController::class, 'index']);
        Route::post('/admin/contents', [AdminContentController::class, 'store']);
        Route::get('/admin/contents/{content}', [AdminContentController::class, 'show']);
        Route::put('/admin/contents/{content}', [AdminContentController::class, 'update']);
        Route::delete('/admin/contents/{content}', [AdminContentController::class, 'destroy']);

        Route::get('/admin/payments', [AdminPaymentController::class, 'index']);
        Route::post('/admin/payments/{payment}/approve', [AdminPaymentController::class, 'approve']);
        Route::post('/admin/payments/{payment}/reject', [AdminPaymentController::class, 'reject']);
    });
});
