<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    // Di dalam AdminController
public function index() {
    $mitra_list = DB::table('penyedia_jasa')->where('status', 'menunggu')->get();
    // ... variabel lain

        // Contoh mengambil data untuk dashboard
        $jumlahUser = DB::table('users')->count();
        $jumlahMitra = DB::table('penyedia_jasa')->where('status', 'terverifikasi')->count();
        $jumlahBerkas = DB::table('penyedia_jasa')->where('status', 'menunggu')->count();
        $dataMitra = DB::table('penyedia_jasa')->where('status', 'menunggu')->get();

        return view('dashboard-admin', compact('jumlahUser', 'jumlahMitra', 'jumlahBerkas', 'dataMitra'));
    }

    public function terimaMitra($id){
    DB::table('penyedia_jasa')
        ->where('id_penyedia', $id)
        ->update(['status' => 'Disetujui']);

    // Logika untuk redirect atau kembali ke halaman sebelumnya
    return redirect()->back()->with('status', 'Berhasil!');
}
}