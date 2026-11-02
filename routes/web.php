<?php

use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/dashboard', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('orders.index')
        : redirect()->route('checkout');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CustomerOrderController::class, 'create'])
        ->name('checkout');

    Route::post('/checkout', [CustomerOrderController::class, 'store'])
        ->name('checkout.store');

    Route::get('/pesanan-saya', [CustomerOrderController::class, 'index'])
        ->name('pesanan-saya');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.status');
});

Route::get('/checkout/menus', [CustomerOrderController::class, 'loadMoreMenus'])
    ->middleware(['auth', 'role:customer'])
    ->name('checkout.menus');

require __DIR__.'/auth.php';
