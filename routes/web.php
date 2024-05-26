<?php

use App\Http\Controllers\AlgoritmaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/', [LoginController::class, 'login'])->name('login.store');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi')->middleware('auth');
Route::post('/transaksi-store', [TransaksiController::class, 'store'])->name('transaksi.store')->middleware('auth');
Route::put('/transaksi-update/{id}', [TransaksiController::class, 'update'])->name('transaksi.update')->middleware('auth');
Route::delete('/transaksi-delete/{id}', [TransaksiController::class, 'delete'])->name('transaksi.delete')->middleware('auth');

Route::get('/obat', [ObatController::class, 'index'])->name('obat')->middleware('auth');
Route::post('/obat-store', [ObatController::class, 'store'])->name('obat.store')->middleware('auth');
Route::put('/obat-update/{id}', [ObatController::class, 'update'])->name('obat.update')->middleware('auth');
Route::delete('/obat-delete/{id}', [ObatController::class, 'delete'])->name('obat.delete')->middleware('auth');

Route::get('/algoritma', [AlgoritmaController::class, 'index'])->name('algoritma')->middleware('auth');
Route::get('/transaksi/filter', [AlgoritmaController::class, 'filter'])->name('transaksi.filter')->middleware('auth');

Route::get('/hasil', [HasilController::class, 'index'])->name('hasil')->middleware('auth');
Route::get('/hasil-detail/{id}', [HasilController::class, 'show'])->name('hasil.detail')->middleware('auth');
