<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes - Proyek Aplikasi GoPet (Integrasi Simpan Database)
|--------------------------------------------------------------------------
*/

// ==========================================
// 0. HALAMAN LOGIN UTAMA (TAMPILAN LUXURY GOPET)
// ==========================================
Route::get('/', function () {
    return view('index'); // Memanggil tampilan form login utama (index.blade.php)
});

// PROSES MENGECEK DATA LOGIN KE DATABASE
Route::post('/login/proses', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    $user = DB::table('user')
            ->where('email', $email)
            ->where('password', $password)
            ->first();

    if ($user) {
        return redirect('/dashboard')->with('success', 'Selamat datang kembali, ' . ($user->nama ?? 'Reymon'));
    }

    return back()->with('error', 'Email atau Password kamu salah, Cees!');
})->name('login.proses');


// ==========================================
// KUNCI UTAMA: FITUR DAFTAR SEKARANG (REGISTER)
// ==========================================

// 1. TAMPILKAN HALAMAN FORM DAFTAR
Route::get('/register', function () {
    return view('register'); // Memanggil file resources/views/register.blade.php
});

// 2. PROSES DAFTAR AKUN BARU LANGSUNG KE DATABASE (BYPASS CONTROLLER)
Route::post('/register', function (Request $request) {
    $nama     = $request->input('nama');
    $email    = $request->input('email');
    $password = $request->input('password');
    $role     = $request->input('role');

    // Cek dulu apakah email sudah pernah dipakai di tabel user
    $cek_email = DB::table('user')->where('email', $email)->first();

    if ($cek_email) {
        return back()->with('error', 'Email sudah terdaftar, Cees! Gunakan email lain.');
    }

    // Jika email aman, langsung masukkan data ke tabel 'user' sebagai teks biasa
    DB::table('user')->insert([
        'nama'     => $nama,
        'email'    => $email,
        'password' => $password, // Password tersimpan polos (Plaintext) sesuai kemauan sistem loginmu
        'role'     => $role
    ]);

    // Setelah sukses daftar, lempar balik ke halaman login utama dengan pesan sukses
    return redirect('/')->with('success', 'Akun berhasil dibuat, Cees! Silakan login.');
});


// ==========================================
// 1. ROUTE DASHBOARD (AKSES: /dashboard)
// ==========================================
Route::get('/dashboard', function () {
    $hewan = DB::table('hewan')->where('id_user', 1)->get();
    $layanan = DB::table('layanan')->get();
    $daftar_rating = DB::table('review_ratings')->orderBy('id', 'desc')->get();

    return view('dashboard', [
        'nama' => 'Reymon',
        'hewan' => $hewan,
        'daftar_layanan' => $layanan,
        'daftar_rating' => $daftar_rating
    ]);
});

// ==========================================
// 2. ROUTE HALAMAN PILIH DOKTER HEWAN
// ==========================================
Route::get('/pilih-dokter', function () {
    $dokter = DB::table('penyedia_jasa')->where('jenis', 'dokter')->get();
    return view('pilih-dokter', ['daftar_dokter' => $dokter]);
});

// ==========================================
// 3. ROUTE HALAMAN PILIH PET SITTER
// ==========================================
Route::get('/pilih-sitter', function () {
    $sitter = DB::table('penyedia_jasa')->where('jenis', 'sitter')->get();
    return view('pilih-sitter', ['daftar_sitter' => $sitter]);
});

// ==========================================
// 4. PROSES SIMPAN FORM RATING (DASHBOARD)
// ==========================================
Route::post('/review/store', function (Request $request) {
    DB::table('review_ratings')->insert([
        'customer_name' => $request->input('customer_name'),
        'pet_name'      => $request->input('pet_name'),
        'rating'        => $request->input('rating_value', 5), 
        'experience'    => $request->input('experience'),
    ]);
    
    return back()->with('success', 'Rating anabul kamu berhasil disimpan ke database!');
})->name('review.store');

// ==========================================
// 5. PROSES SIMPAN FORM KONTAK / PESAN
// ==========================================
Route::post('/kontak/store', function (Request $request) {
    DB::table('kontak_pesan')->insert([
        'nama_lengkap' => $request->input('nama_lengkap'),
        'email'        => $request->input('email'),
        'pesan'        => $request->input('pesan'),
    ]);

    return back()->with('success', 'Pesan kamu berhasil dikirim dan tersimpan di database!');
})->name('kontak.store');

// ==========================================
// ROUTE JEMBATAN BIAR TIDAK 404 NOT FOUND
// ==========================================
Route::get('/pesan-layanan', function (Request $request) {
    $dokter = DB::table('penyedia_jasa')->where('jenis', 'dokter')->get();
    return view('pilih-dokter', ['daftar_dokter' => $dokter]);
});