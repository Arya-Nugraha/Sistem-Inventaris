<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Kategori - resource route (CRUD lengkap)
    Route::resource('kategori', KategoriController::class);

    // Route lain masih sementara (akan diganti resource nanti)
    Route::resource('supplier', SupplierController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('barangkeluar', BarangKeluarController::class);
    Route::resource('barangmasuk', BarangMasukController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
