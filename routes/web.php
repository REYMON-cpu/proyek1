<?php

use Illuminate\Support\Facades\Route;
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