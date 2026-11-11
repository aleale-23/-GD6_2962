
<?php

use Illuminate\Support\Facades\Route;

// Data konser
$daftarKonser = [
    1 => [
        'nama' => 'Coldplay - Music of the Spheres',
        'kota' => 'Jakarta',
        'harga' => 1500000,
        'sisa' => 25
    ],
    2 => [
        'nama' => 'NCT Dream - The Dream Show',
        'kota' => 'Jakarta',
        'harga' => 1200000,
        'sisa' => 0
    ],
    3 => [
        'nama' => 'Dewa 19 - Pesta Rakyat',
        'kota' => 'Yogyakarta',
        'harga' => 450000,
        'sisa' => 120
    ],
];

// Route halaman utama
Route::get('/', function () {
    return view('home');
})->name('home');

// Route daftar konser
Route::get('/konser', function () use ($daftarKonser) {
    return view('konser', compact('daftarKonser'));
})->name('konser.index');

// Route detail konser
Route::get('/konser/{id}', function ($id) {
    return 'Detail konser nomor ' . $id;
})->whereNumber('id')->name('konser.detail');

// Route tentang
Route::view('/tentang', 'about')->name('tentang');
