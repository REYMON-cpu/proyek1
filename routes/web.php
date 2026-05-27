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
    return view('index'); // Memanggil tampilan form login baru kita
});

// PROSES MENGECEK DATA LOGIN KE DATABASE
Route::post('/login/proses', function (Request $request) {
    // 1. Validasi input sederhana
    $email = $request->input('email');
    $password = $request->input('password');

    // 2. Cari user di database berdasarkan email & password (sesuaikan nama tabelmu, misal: 'users' atau 'user')
    $user = DB::table('users')
                ->where('email', $email)
                ->where('password', $password) // Catatan: ini teks biasa, sesuaikan jika di db kelompokmu di-hash
                ->first();

    if ($user) {
        // Jika login sukses, oper nama asli dari database atau default 'Reymon'
        return redirect('/dashboard')->with('success', 'Selamat datang kembali, ' . ($user->nama ?? 'Reymon'));
    }

    // Jika gagal, tendang balik ke halaman login dengan pesan error
    return back()->with('error', 'Email atau Password kamu salah, Cees!');
})->name('login.proses');

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
    $dokter = DB::table('penyedia_jasa')->where('jenis', 'dokter')->get();
    return view('pilih-dokter', ['daftar_dokter' => $dokter]);
});