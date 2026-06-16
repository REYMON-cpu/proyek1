<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

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

// PROSES MENGECEK DATA LOGIN KE DATABASE DENGAN DIVRESI ROLE AUTOMATIS
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
        // Simpan ID ke session agar dashboard bisa mengenali siapa yang login
        session(['user_id' => $user->id]); 

        if ($user->role === 'Penyedia Jasa') {
            // Logika pembeda berdasarkan kolom 'jenis'
            if (isset($user->jenis) && $user->jenis === 'sitter') {
                return redirect('/dashboard-sitter');
            } else {
                return redirect('/dashboard-dokter');
            }
        } elseif ($user->role === 'Admin') {
            return redirect('/dashboard-admin');
        }
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
        'password' => $password, // Password tersimpan polos (Plaintext)
        'role'     => $role
    ]);

    // Setelah sukses daftar, lempar balik ke halaman login utama dengan pesan sukses
    return redirect('/')->with('success', 'Akun berhasil dibuat, Cees! Silakan login.');
});


// ==========================================
// 1. ROUTE DASHBOARD USER UTAMA (AKSES: /dashboard)
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
// 2. ROUTE DASHBOARD KHUSUS DOKTER, ADMIN ,& SITTER  (FIXED ID COLUMNS)
// ==========================================
Route::get('/dashboard-dokter', function () {
    // 1. Ambil data antrean pemesanan aktif
    $pemesanan = DB::table('pemesanan')->orderBy('id_pemesanan', 'desc')->get();

    // 2. Ambil data rekam medis (yang statusnya Selesai)
    $rekam_medis = DB::table('pemesanan')
                    ->where('status', 'Selesai')
                    ->orderBy('id_pemesanan', 'desc')
                    ->get();

    // 3. Ambil data chat dari tabel kontak_pesan
    $chats = DB::table('kontak_pesan')->orderBy('id', 'desc')->get(); 

    return view('dashboard-dokter', [
        'daftar_pesanan' => $pemesanan,
        'rekam_medis'    => $rekam_medis,
        'daftar_chat'    => $chats
    ]);
});

Route::get('/dashboard-admin', function () {
    // 1. Ambil data dari database terlebih dahulu
    $total_user       = DB::table('user')->count(); 
    $total_mitra      = DB::table('penyedia_jasa')->count();
    $total_pending    = DB::table('pemesanan')->where('status', 'Pending')->count();
    
    // Pindahkan pengambilan data ini ke atas
    $mitra_verifikasi = DB::table('penyedia_jasa')->whereNull('status')->get();
    $mitra_list       = DB::table('penyedia_jasa')->whereNull('status')->orWhere('status','!=','Disetujui')->get();
    $pelanggan_list   = DB::table('user')->where('role', '!=', 'Admin')->get(); 
    $mitra_aktif      = DB::table('penyedia_jasa')->where('status','Disetujui')->get();

    // 2. Sekarang baru hitung count-nya (karena variabelnya sudah ada)
    $total_butuh_verifikasi = $mitra_verifikasi->count();

    // 3. Kirim semua variabel ke view
    return view('dashboard-admin', [
        'total_user'             => $total_user,
        'total_mitra'            => $total_mitra,
        'total_pending'          => $total_pending,
        'total_butuh_verifikasi' => $total_butuh_verifikasi, // Sekarang ini tidak akan error
        'mitra_list'             => $mitra_list,
        'pelanggan_list'         => $pelanggan_list,
        'mitra_verifikasi'       => $mitra_verifikasi,
        'mitra_aktif'            => $mitra_aktif
    ]);
});

Route::post('/login/proses', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');
    $role = $request->input('role');

    // Ambil user dari database
    $user = DB::table('user')
              ->where('email', $email)
              ->where('password', $password)
              ->where('role', $role)
              ->first();

    if ($user) {
        // Simpan ID ke session
        session(['user_id' => $user->id_user]);

        // Cek jika role-nya "Penyedia Jasa"
        if ($user->role === 'Penyedia Jasa') {
            if (isset($user->jenis) && $user->jenis === 'sitter') {
                return redirect('/dashboard-sitter');
            } else {
                return redirect('/dashboard-dokter');
            }
        } elseif ($user->role === 'Admin') {
            return redirect('/dashboard-admin');
        } elseif ($user->role === 'Pemilik Hewan');{
            return redirect('/dashboard');
        }    
    }
    
    return back()->with('error', 'Email, Password, atau Role salah, Cees!');
})->name('login.proses'); // <--- INI KUNCI UTAMANYA!

// ==========================================
// 3. SELEKSI & PEMESANAN LAYANAN MITRA
// ==========================================

// Halaman pilih dokter (mengambil data dokter dari database)
Route::get('/pilih-dokter', function () {
    // Kita panggil langsung semua data dari tabel penyedia_jasa
    // agar kita tahu pasti datanya ada atau tidak di tabel itu
    $daftar_dokter = DB::table('penyedia_jasa')->get();

    // Debugging lagi: apakah data dari tabel penyedia_jasa ada?
    // dd($daftar_dokter); 

    return view('pilih-dokter', ['daftar_dokter' => $daftar_dokter]);
});

// Halaman pilih sitter (mengambil data sitter dari database)
Route::get('/pilih-sitter', function () {
    $sitter = DB::table('penyedia_jasa')->where('jenis', 'sitter')->get();
    return view('pilih-sitter', ['daftar_sitter' => $sitter]); // Mengirim data ke view
});

// Halaman pesan layanan sekarang dinamis berdasarkan ID dokter/sitter yang diklik
Route::get('/pesan-layanan/{id}', function ($id) {
    // Mencari data penyedia jasa berdasarkan id_penyedia di database gopet_db
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

// PROSES SIMPAN FORM PEMESANAN LAYANAN KE DATABASE (ANTI-NULL)
Route::post('/proses-pemesanan', function (Request $request) {
    // Menyimpan seluruh kiriman data formulir ke dalam tabel pemesanan
   DB::table('pemesanan')->insert([
    'id_penyedia'       => $request->input('id_mitra'),
    'id_user'           => 1, 
    'id_hewan'          => 1, // Pastikan angka 1 ini ada di tabel hewanmu
    'id_layanan'        => 1, // Pastikan angka 1 ini ada di tabel layananmu
    'tanggal'           => $request->input('tanggal_kunjungan'), // <-- INI YANG KURANG
    'tanggal_kunjungan' => $request->input('tanggal_kunjungan'),
    'jam_kunjungan'     => $request->input('jam_kunjungan'),
    'alamat'            => $request->input('alamat'),
    'status'            => 'Pending',
    'nama_hewan'        => $request->input('nama_hewan'),
    'jenis_hewan'       => $request->input('jenis_hewan'),
    'umur_hewan'        => $request->input('umur_hewan'),
    'riwayat_kesehatan' => $request->input('riwayat_kesehatan'),
    'catatan'           => $request->input('catatan'),
    'created_at'        => now(),
    'updated_at'        => now()
]);

    // Mengalihkan halaman kembali ke dashboard dengan membawa notifikasi sukses
    return redirect('/dashboard')->with('success', 'Pemesanan layanan home-visit berhasil dibuat, Cees!');
});


// ==========================================
// 4. UTILITAS LAINNYA: CHAT, MITRA, RATING, KONTAK
// ==========================================
Route::get('/daftar-mitra', function () {
    return view('daftar-mitra');
});

Route::get('/chat', function () {
    return view('chat');
});

// PROSES SIMPAN FORM RATING (DASHBOARD)
Route::post('/review/store', function (Request $request) {
    DB::table('review_ratings')->insert([
        'customer_name' => $request->input('customer_name'),
        'pet_name'      => $request->input('pet_name'),
        'rating'        => $request->input('rating_value', 5),
        'experience'    => $request->input('experience'),
    ]);

    return back()->with('success', 'Rating anabul kamu berhasil disimpan ke database!');
})->name('review.store');

// PROSES SIMPAN FORM KONTAK DI DASHBOARD
Route::post('/kontak-store', function (Request $request) {
    return redirect('/dashboard')->with('success', 'Pesan kamu berhasil dikirim, Cees!');
})->name('kontak.store');

// PROSES MENYETUJUI DOKUMEN MITRA
Route::post('/admin/mitra/setujui/{id}', function ($id) {
    DB::table('penyedia_jasa')
        ->where('id_penyedia', $id)
        ->update(['status' => 'Disetujui']); // Gunakan 'status' sesuai nama kolom baru

    return back()->with('success', 'Dokumen mitra berhasil disetujui!');
})->name('admin.mitra.setujui');

// PROSES MENOLAK DOKUMEN MITRA
Route::post('/admin/mitra/tolak/{id}', function ($id) {
    DB::table('penyedia_jasa')
        ->where('id_penyedia', $id)
        ->update(['status' => 'Ditolak']); // Gunakan 'status'

    return back()->with('error', 'Dokumen mitra telah ditolak.');
})->name('admin.mitra.tolak');

// PROSES LOGOUT AKUN (SINKRON UNTUK SEMUA ROLE)
Route::post('/logout', function () {
    // Menghapus seluruh data session aktif
    session()->flush(); 
    
    // Kembalikan ke halaman login utama dengan pesan sukses
    return redirect('/')->with('success', 'Berhasil keluar aplikasi. Sampai jumpa, Cees!');
})->name('logout');
Route::get('/login-admin', function () {
    return view('login-admin');
});

Route::get('/dashboard-sitter', function () {
    return view('dashboard-sitter');
});
