<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/pesan-layanan', function () {
    return view('pesan-layanan');
});

Route::get('/pilih-dokter', function () {
    return view('pilih-dokter');
});

Route::get('/pilih-sitter', function () {
    return view('pilih-sitter');
});


Route::get('/daftar-mitra', function () {
    return view('daftar-mitra');
});

Route::get('/chat', function () {
    return view('chat');
});

Route::post('/review-store', [ReviewController::class, 'store'])->name('review.store');









