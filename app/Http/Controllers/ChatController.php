<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    private function resolveUserRecId($id_sitter)
    {
        $provider = DB::table('penyedia_jasa')->where('id_penyedia', $id_sitter)->first();
        if ($provider) {
            $user_rec = DB::table('user')->where('nama', $provider->nama)->first();
            if ($user_rec) {
                return $user_rec->id_user;
            }
        }
        return $id_sitter;
    }

    public function index($id_sitter = null)
    {
        if (!$id_sitter) {
            return redirect('/pilih-sitter')->with('error', 'Pilih Sitter dulu, Cees!');
        }

        $provider = DB::table('penyedia_jasa')->where('id_penyedia', $id_sitter)->first();
        if (!$provider) {
            return redirect('/pilih-sitter')->with('error', 'Penyedia Jasa tidak ditemukan, Cees!');
        }

        $sitterUserId = $this->resolveUserRecId($id_sitter);

        $messages = DB::table('pesan_sitter')
            ->where(function($q) use ($sitterUserId) {
                $q->where('id_pengirim', Auth::id())
                  ->where('id_penerima', $sitterUserId);
            })
            ->orWhere(function($q) use ($sitterUserId) {
                $q->where('id_pengirim', $sitterUserId)
                  ->where('id_penerima', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat', compact('messages', 'id_sitter', 'provider'));
    }

    public function store(Request $request)
    {
        $id_sitter = $request->input('id_penerima');
        $isi_pesan = $request->input('isi_pesan');

        if (!$id_sitter || !$isi_pesan) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak lengkap.'], 400);
        }

        $sitterUserId = $this->resolveUserRecId($id_sitter);

        DB::table('pesan_sitter')->insert([
            'id_pengirim' => Auth::id() ?? 1,
            'id_penerima' => $sitterUserId,
            'isi_pesan' => $isi_pesan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 'success']);
    }

    public function getNewMessages(Request $request, $id_sitter)
    {
        $sitterUserId = $this->resolveUserRecId($id_sitter);
        $last_id = $request->query('last_id', 0);

        $messages = DB::table('pesan_sitter')
            ->where('id', '>', $last_id)
            ->where(function($q) use ($sitterUserId) {
                $q->where(function($q1) use ($sitterUserId) {
                    $q1->where('id_pengirim', Auth::id())
                       ->where('id_penerima', $sitterUserId);
                })
                ->orWhere(function($q2) use ($sitterUserId) {
                    $q2->where('id_pengirim', $sitterUserId)
                       ->where('id_penerima', Auth::id());
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'messages' => $messages
        ]);
    }
}