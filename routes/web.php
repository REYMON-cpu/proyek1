<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use Illuminate\Support\Facades\DB;

// Jalur Utama (Halaman Dashboard)
Route::get('/', function () {
    // Mengambil data hewan yang dimiliki oleh id_user = 1 dari database gopet
    $hewan = DB::table('hewan')->where('id_user', 1)->get();

    // Mengirimkan data ke halaman dashboard.blade.php
    return view('dashboard', [
        'nama' => 'Reymon',
        'role' => 'Admin',
        'daftar_hewan' => $hewan
    ]);
});
=======
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/verify', function () {
    return view('verify');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});


Route::post('/review-store', [ReviewController::class, 'store'])->name('review.store');





>>>>>>> 0de9869f023d5b330a53d5703a39cd5d0d380b2b
