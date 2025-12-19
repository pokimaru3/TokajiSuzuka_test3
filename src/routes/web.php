<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Manager\ManagerAuthController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\ReviewController;
use App\Models\Review;
use Illuminate\Support\Manager;

// 一般ユーザー

Route::post('/register', [AuthController::class, 'store']);
Route::get('/email/verify/{id}/{hash}', \App\Http\Controllers\Auth\VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');
Route::get('/thanks', function () {
    return view('user.thanks');
})->middleware('auth')->name('verification.thanks');

Route::get('/', [ShopController::class, 'index'])->name('user.index');
Route::post('/search', [ShopController::class, 'search'])->name('shops.search');
Route::get('/detail/{shop_id}', [ShopController::class, 'show'])->name('user.detail');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/favorite/toggle', [ShopController::class, 'toggle'])->name('favorite.toggle');
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('/done', [ReservationController::class, 'complete'])->name('reservation.complete');
    Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');
    Route::get('/reservation/{id}/qr', [ReservationController::class, 'showQr'])->name('reservation.qr');
    Route::post('/reservation/cancel', [ReservationController::class, 'cancel'])->name('reservation.cancel');
    Route::get('/reservation/{id}/edit', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::put('/reservation/{id}', [ReservationController::class, 'update'])->name('reservation.update');
    Route::get('/reviews/{reservation}/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews/{reservation}', [ReviewController::class, 'store'])->name('reviews.store');
});

// 管理者

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

    Route::middleware('admin')->group(function () {
        Route::get('/manager/create', [AdminController::class, 'create'])->name('create');
        Route::post('/manager/store', [AdminController::class, 'store'])->name('store');
        Route::get('/manager', [AdminController::class, 'index'])->name('index');
    });
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// 店舗代表者

Route::get('/reservation/{id}/verify', [ReservationController::class, 'verify'])
    ->name('reservation.verify');

Route::prefix('manager')->name('manager.')->group(function () {
    Route::get(('/login'), [ManagerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ManagerAuthController::class, 'login'])->name('login.post');

    Route::middleware('manager')->group(function () {
        Route::get('/shop/create', [ManagerController::class, 'create'])->name('create');
        Route::post('/shop/store', [ManagerController::class, 'store'])->name('store');
        Route::get('/shop/{shop}/edit', [ManagerController::class, 'edit'])->name('shop.edit');
        Route::post('/shop/{shop}/update', [ManagerController::class, 'update'])->name('shop.update');
        Route::get('/shops', [ManagerController::class, 'index'])->name('shop.index');
        Route::get('/manager/shops/{shop}/mail', [ManagerController::class, 'showMailForm'])
        ->name('mail.create');
        Route::post('/manager/shops/{shop}/mail', [ManagerController::class, 'send'])
        ->name('mail.send');
        Route::post('/logout', [ManagerAuthController::class, 'logout'])->name('logout');
    });
});
