<?php

use App\Http\Controllers\PesananController;
use App\Http\Controllers\KonserController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', function () {
    return view('home');
})->name('home');

Route::view('/tentang', 'about')->name('tentang');

Route::view('/kontak', 'kontak')->name('kontak');

Route::get('/ping', function () {
    return ['status' => 'ok', 'aplikasi' => 'TiketWar'];
});

// CRUD Konser
Route::get('/konser', [KonserController::class, 'index'])
    ->name('konser.index');

Route::get('/konser/create', [KonserController::class, 'create'])
    ->name('konser.create');

Route::post('/konser', [KonserController::class, 'store'])
    ->name('konser.store');

Route::get('/konser/{id}', [KonserController::class, 'show'])
    ->whereNumber('id')->name('konser.detail');

Route::get('/konser/{id}/edit', [KonserController::class, 'edit'])
    ->whereNumber('id')->name('konser.edit');

Route::put('/konser/{id}', [KonserController::class, 'update'])
    ->whereNumber('id')->name('konser.update');

Route::delete('/konser/{id}', [KonserController::class, 'destroy'])
    ->whereNumber('id')->name('konser.destroy');

// Transaksi Pesanan
Route::get('/konser/{konser}/pesan', [PesananController::class, 'create'])
    ->whereNumber('konser')->name('pesanan.create');

Route::post('/konser/{konser}/pesan', [PesananController::class, 'store'])
    ->whereNumber('konser')->name('pesanan.store');

Route::get('/pesanan', [PesananController::class, 'index'])
    ->name('pesanan.index');

Route::patch('/pesanan/{pesanan}/bayar', [PesananController::class, 'bayar'])
    ->whereNumber('pesanan')->name('pesanan.bayar');

Route::patch('/pesanan/{pesanan}/batal', [PesananController::class, 'batal'])
    ->whereNumber('pesanan')->name('pesanan.batal');

// Laporan dan Ekspor PDF
Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');

Route::get('/laporan/pdf', [LaporanController::class, 'pdf'])
    ->name('laporan.pdf');