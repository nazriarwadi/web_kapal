<?php

use App\Http\Controllers\AbsensiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\InformasiController;
use App\Models\Anggota;
use App\Models\Profesi;

// Halaman Login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Halaman Dashboard (Hanya bisa diakses setelah login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // CRUD Anggota
    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{anggota}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{anggota}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::post('/anggota/{anggota}/ban', [AnggotaController::class, 'ban'])->name('anggota.ban');
    Route::post('/anggota/{anggota}/unban', [AnggotaController::class, 'unban'])->name('anggota.unban');

    // Rute untuk Absensi
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/get-anggota-by-regu/{reguId}', [AbsensiController::class, 'getAnggotaByRegu'])->name('absensi.getAnggotaByRegu');

    // Route untuk menampilkan daftar slip gaji
    Route::get('/gaji', [GajiController::class, 'index'])->name('gaji.index');

    // Route untuk menampilkan form create slip gaji
    Route::get('/gaji/create', [GajiController::class, 'create'])->name('gaji.create');

    // Route untuk menyimpan data slip gaji baru
    Route::post('/gaji', [GajiController::class, 'store'])->name('gaji.store');

    // Route untuk menampilkan form edit slip gaji
    Route::get('/gaji/{slipGaji}/edit', [GajiController::class, 'edit'])->name('gaji.edit');

    // Route untuk mengupdate data slip gaji
    Route::put('/gaji/{slipGaji}', [GajiController::class, 'update'])->name('gaji.update');

    // Route untuk menghapus data slip gaji
    Route::delete('/gaji/{slipGaji}', [GajiController::class, 'destroy'])->name('gaji.destroy');

    // Route khusus untuk mengambil data anggota dan absensi
    Route::get('/get-anggota-data/{id}', [GajiController::class, 'getAnggotaData'])->name('get.anggota.data');

    Route::get('/get-anggota-data/{id}', [GajiController::class, 'getAnggotaData']);

    // Route untuk CRUD informasi
    Route::resource('informasi', InformasiController::class);
});
