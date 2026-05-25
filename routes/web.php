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
// 1. ROUTE DASHBOARD / HALAMAN UTAMA (SUDAH DISATUKAN)
// ==========================================
Route::get('/dashboard', function () {
    // Query bawaan project kelompokmu
    $hewan = DB::table('hewan')->where('id_user', 1)->get();
    $layanan = DB::table('layanan')->get();
    
    // AMBIL DATA DARI TABEL RATING (Urutkan dari yang paling baru diinput)
    $daftar_rating = DB::table('review_ratings')->orderBy('id', 'desc')->get();

    // Kirim semua variabel ke file dashboard.blade.php
    return view('dashboard', [
        'nama' => 'Reymon',
        'hewan' => $hewan,
        'daftar_layanan' => $layanan,
        'daftar_rating' => $daftar_rating // Aman, tidak akan tertimpa lagi!
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
// ==========================================
// 4. PROSES SIMPAN FORM RATING (DASHBOARD)
// ==========================================
Route::post('/review/store', function (Request $request) {
    // Memasukkan data dari form rating langsung ke tabel review_ratings
    DB::table('review_ratings')->insert([
        'customer_name' => $request->input('customer_name'),
        'pet_name'      => $request->input('pet_name'),
        
        // DISINI KUNCINYA: Kiri adalah nama kolom database asli ('rating'), kanan adalah name dari input HTML-mu
        'rating'        => $request->input('rating_value', 5), 
        
        'experience'    => $request->input('experience'),
    ]);
    
    return back()->with('success', 'Rating anabul kamu berhasil disimpan ke database!');
})->name('review.store');

// ==========================================
// 5. PROSES SIMPAN FORM KONTAK / PESAN
// ==========================================
Route::post('/kontak/store', function (Request $request) {
    // Memasukkan data dari form kontak langsung ke tabel kontak_pesan
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
    // Kita cek, jika ada parameter jenis tertentu atau default-nya diarahkan ke dokter/sitter
    // Tapi biar aman dan langsung menampilkan data, kita panggil view pilih-dokter atau pilih-sitter langsung.
    
    $dokter = DB::table('penyedia_jasa')->where('jenis', 'dokter')->get();
    return view('pilih-dokter', ['daftar_dokter' => $dokter]);
});