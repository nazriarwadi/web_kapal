<?php

use App\Http\Controllers\Api\ApiAbsensiController;
use App\Http\Controllers\Api\ApiAnggotaController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiInformasiController;
use App\Http\Controllers\Api\ApiSlipGajiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiAuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [ApiAuthController::class, 'getUser']);
    Route::post('/reset-password', [ApiAuthController::class, 'resetPassword']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    Route::get('/absensi', [ApiAbsensiController::class, 'getAbsensiByUser']);

    // Endpoint untuk mendapatkan data anggota yang sedang login
    Route::get('/anggota/current', [ApiAnggotaController::class, 'getCurrentUser']);
    // Endpoint untuk mendapatkan data semua anggota
    Route::get('/anggota/all', [ApiAnggotaController::class, 'getAllAnggota']);

    Route::get('/slip-gaji', [ApiSlipGajiController::class, 'getSlipGajiByUser']);

    Route::get('/informasi', [ApiInformasiController::class, 'getInformasiList']);
    Route::get('/informasi/{id}', [ApiInformasiController::class, 'getInformasiById']);
});
