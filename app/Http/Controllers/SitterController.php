<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class SitterController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $user = DB::table('user')->where('id_user', $userId)->first();

        if (!$user) {
            return redirect()->route('login');
        }

        $penyedia = DB::table('penyedia_jasa')->where('nama', $user->nama)->first();
        $sitterId = $penyedia ? $penyedia->id_penyedia : $user->id_user;

        // Metric
        $totalPenitipanHariIni = DB::table('pemesanan')
            ->where('id_penyedia', $sitterId)
            ->whereDate('tanggal', now()->toDateString())
            ->count();

        $menungguKonfirmasi = DB::table('pemesanan')
            ->where('id_penyedia', $sitterId)
            ->whereIn('status', ['Pending', 'menunggu', 'pending'])
            ->count();

        $totalHewanDiasuh = DB::table('riwayat_layanan as r')
            ->join('pemesanan as p', 'p.id_pemesanan', '=', 'r.id_pemesanan')
            ->where('p.id_penyedia', $sitterId)
            ->count();

        // Jadwal (JOIN biar view tidak hardcode)
        $jadwal = DB::table('pemesanan as p')
            ->join('user as u', 'u.id_user', '=', 'p.id_user')
            ->join('hewan as h', 'h.id_hewan', '=', 'p.id_hewan')
            ->join('layanan as l', 'l.id_layanan', '=', 'p.id_layanan')
            ->where('p.id_penyedia', $sitterId)
            ->select([
                'p.id_pemesanan',
                'p.tanggal',
                'p.jam_kunjungan',
                'p.status',
                'u.nama as nama_pemilik',
                'h.nama_hewan as nama_hewan',
                'l.nama_layanan as nama_layanan',
            ])
            ->orderBy('p.tanggal', 'desc')
            ->get();

        return view('dashboard-sitter', [
            'user' => $user,
            'totalPenitipanHariIni' => $totalPenitipanHariIni,
            'menungguKonfirmasi' => $menungguKonfirmasi,
            'totalHewanDiasuh' => $totalHewanDiasuh,
            'jadwal' => $jadwal,
        ]);

    }
}

