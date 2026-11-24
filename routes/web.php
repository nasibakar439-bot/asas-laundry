<?php

use App\Http\Controllers\LayananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman utama (Pencatatan Transaksi Laundry)
Route::get('/', [TransaksiController::class, 'index'])->name('kasir.index');

// Dashboard utama Breeze (otomatis cek role admin atau kasir)
Route::get('/dashboard', [TransaksiController::class, 'adminDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Proses simpan transaksi & cetak struk (bisa diakses Kasir maupun Admin)
    Route::post('/checkout', [TransaksiController::class, 'store'])->name('kasir.checkout');
    Route::get('/transaksi/{id}/struk', [TransaksiController::class, 'receipt'])->name('transaksi.receipt');

    // Route bawaan Breeze untuk profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route khusus Admin (Data Layanan & Rekap Transaksi)
    Route::get('/admin/dashboard', [TransaksiController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::patch('/admin/transaksi/{id}/status', [TransaksiController::class, 'updateStatus'])->name('admin.transaksi.updateStatus');
    Route::resource('/admin/layanan', LayananController::class);
});

require __DIR__.'/auth.php';