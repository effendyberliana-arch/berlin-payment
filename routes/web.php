<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Wallet Routes
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet', [WalletController::class, 'store'])->name('wallet.store');
    Route::patch('/wallet', [WalletController::class, 'update'])->name('wallet.update');
    Route::delete('/wallet', [WalletController::class, 'destroy'])->name('wallet.destroy');
    Route::get('/wallet/debug', [WalletController::class, 'debug'])->name('wallet.debug');

    });

require __DIR__.'/auth.php';
