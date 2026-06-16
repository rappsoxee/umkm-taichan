<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CustomerAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Root → kalau udah login ke dashboard, belum login ke login page
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Public — customer (tanpa login)
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::post('/menu/checkout', [MenuController::class, 'checkout'])->name('menu.checkout');
Route::get('/menu/auth', [CustomerAuthController::class, 'showAuth'])->name('menu.auth');
Route::post('/menu/auth/login', [CustomerAuthController::class, 'login'])->name('menu.auth.login');
Route::post('/menu/auth/register', [CustomerAuthController::class, 'register'])->name('menu.auth.register');
Route::post('/menu/auth/guest', [CustomerAuthController::class, 'guest'])->name('menu.auth.guest');
Route::post('/menu/auth/logout', [CustomerAuthController::class, 'logout'])->name('menu.auth.logout');

// Admin (butuh login)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    Route::patch('/products/{id}/stok', [ProductController::class, 'updateStok'])->name('products.updateStok');

    Route::resource('customers', CustomerController::class);
    Route::resource('transactions', TransactionController::class);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.exportExcel');
    Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');

    Route::get('/qrcodes', [QrCodeController::class, 'index'])->name('qrcodes.index');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/check-new', [OrderController::class, 'checkNew'])->name('orders.checkNew');
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';