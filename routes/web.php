<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes - Proyek Aplikasi GoPet (Hasil Integrasi Backend & Frontend)
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
    $role = $request->input('role');

    $user = DB::table('user')
              ->where('email', $email)
              ->where('password', $password)
              ->where('role', $role)
              ->first();

    if ($user) {
        return redirect('/dashboard')->with('success', 'Selamat datang kembali, ' . ($user->nama ?? 'Reymon'));
    }

    return back()->with('error', 'Email, Password, atau Role salah, Cees!');
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
// FIX: Halaman pesan layanan sekarang dinamis berdasarkan ID dokter/sitter yang diklik
// ==========================================
Route::get('/pesan-layanan/{id}', function ($id) {
    // Sembuh: Mengubah 'id' menjadi 'id_penyedia' sesuai kolom di database kamu
    $dokter = DB::table('penyedia_jasa')->where('id_penyedia', $id)->first();

    // Antisipasi kalau data dokter tidak sengaja terhapus atau tidak ada di DB
    if (!$dokter) {
        return redirect('/pilih-dokter')->with('error', 'Penyedia jasa tidak ditemukan, Cees!');
    }

    return view('pesan-layanan', ['dokter' => $dokter]);
});

// Halaman pilih dokter (mengambil data dokter dari database)
Route::get('/pilih-dokter', function () {
    $dokter = DB::table('penyedia_jasa')->where('jenis', 'dokter')->get();
    return view('pilih-dokter', ['daftar_dokter' => $dokter]);
});

// Halaman pilih sitter (mengambil data sitter dari database)
Route::get('/pilih-sitter', function () {
    $sitter = DB::table('penyedia_jasa')->where('jenis', 'sitter')->get();
    return view('pilih-sitter', ['daftar_sitter' => $sitter]);
});

// BARU DARI FRONTEND: Halaman daftar mitra
Route::get('/daftar-mitra', function () {
    return view('daftar-mitra');
});

// BARU DARI FRONTEND: Halaman chat
Route::get('/chat', function () {
    return view('chat');
});


// ==========================================
// 3. PROSES SIMPAN FORM RATING (DASHBOARD)
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


// =========================================================================
// 4. HALAMAN PESAN LAYANAN (MENAMPILKAN FORMULIR)
// =========================================================================
Route::get('/pesan-layanan/{id}', function ($id) {
    // Mencari data penyedia jasa berdasarkan id_penyedia di database gopet_db2
    $dokter = DB::table('penyedia_jasa')->where('id_penyedia', $id)->first();

    if (!$dokter) {
        return redirect('/pilih-dokter')->with('error', 'Penyedia jasa tidak ditemukan, Cees!');
    }

    // Mengirim data dokter DAN melempar variabel id_terpilih langsung dari parameter URL
    return view('pesan-layanan', [
        'dokter'      => $dokter,
        'id_terpilih' => $id
    ]);
});

// =========================================================================
// 5. PROSES SIMPAN FORM PEMESANAN LAYANAN KE DATABASE (ANTI-NULL)
// =========================================================================
Route::post('/proses-pemesanan', function (Request $request) {

    // Menyimpan seluruh kiriman data formulir ke dalam tabel pemesanan
    DB::table('pemesanan')->insert([
        'id_mitra'          => $request->input('id_mitra'),
        'nama_hewan'        => $request->input('nama_hewan'),
        'jenis_hewan'       => $request->input('jenis_hewan'),
        'umur_hewan'        => $request->input('umur_hewan'),
        'riwayat_kesehatan' => $request->input('riwayat_kesehatan'),
        'tanggal_kunjungan' => $request->input('tanggal_kunjungan'),
        'jam_kunjungan'     => $request->input('jam_kunjungan'),
        'alamat'            => $request->input('alamat'),
        'catatan'           => $request->input('catatan'),
        'status'            => 'Pending', // Status default saat pertama kali pesan
        'created_at'        => now(),
        'updated_at'        => now()
    ]);

    // Mengalihkan halaman kembali ke dashboard dengan membawa notifikasi sukses
    return redirect('/dashboard')->with('success', 'Pemesanan layanan home-visit berhasil dibuat, Cees!');
});

// ==========================================
// 6. PROSES SIMPAN FORM KONTAK DI DASHBOARD
// ==========================================
Route::post('/kontak-store', function (Request $request) {
    // Sementara kita buat redirect balik ke dashboard dulu agar tidak error
    return redirect('/dashboard')->with('success', 'Pesan kamu berhasil dikirim, Cees!');
})->name('kontak.store'); // <-- Ini nama rute yang dicari oleh dashboard.blade.php

Route::get('/dashboard-dokter', function () {
    return view('dashboard-dokter');
});

Route::get('/login-admin', function () {
    return view('login-admin');
});

Route::get('/dashboard-admin', function () {
    return view('dashboard-admin');
});

Route::get('/dashboard-sitter', function () {
    return view('dashboard-sitter');
});
