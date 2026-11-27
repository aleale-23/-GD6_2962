<?php

use App\Http\Controllers\Api\KonserController;
use App\Http\Controllers\Api\PesananController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TokenController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API publik TiketWar (modul API dan Autentikasi, kelas)
Route::get('/konser', [KonserController::class, 'index'])
    ->name('api.konser.index');

Route::get('/konser/{konser}', [KonserController::class, 'show'])
    ->whereNumber('konser')->name('api.konser.show');

Route::post('/konser/{konser}/pesanan', [PesananController::class, 'store'])
    ->whereNumber('konser')->name('api.pesanan.store');

// Token admin
Route::post('/login', [TokenController::class, 'store'])
    ->middleware('throttle:login')
    ->name('api.login');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [TokenController::class, 'destroy'])
        ->name('api.logout');

    Route::get('/admin/pesanan', [PesananController::class, 'index'])
        ->middleware('abilities:pesanan:baca')
        ->name('api.admin.pesanan.index');

    // API CRUD konser untuk admin
    Route::post('/konser', [KonserController::class, 'store'])
        ->name('api.konser.store');

    Route::put('/konser/{konser}', [KonserController::class, 'update'])
        ->name('api.konser.update');

    Route::delete('/konser/{konser}', [KonserController::class, 'destroy'])
        ->name('api.konser.destroy');

});