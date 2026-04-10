<?php
namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\BookComment;
use App\Models\AntrianPeminjaman;

class RakController extends Controller
{
    public function index()
    {
              /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->load('anggota');

        // ================= PINJAM =================
        $pinjam = collect();
        if ($user->anggota) {
            $pinjam = Peminjaman::with('buku')
                ->where('anggota_id', $user->anggota->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->latest()
                ->get();
        }

        // ================= ANTRIAN =================
        $antrian = collect();
        if ($user->anggota) {
            $antrian = AntrianPeminjaman::with('buku')
                ->where('anggota_id', $user->anggota->id)
                ->where('status', 'menunggu')
                ->latest()
                ->get();
        }

        // ================= RIWAYAT =================
        $riwayat = collect();
        if ($user->anggota) {
            $riwayat = Peminjaman::with('buku')
                ->where('anggota_id', $user->anggota->id)
                ->where('status', 'dikembalikan')
                ->latest()
                ->get()
                ->unique('buku_id');
        }

        // ================= ULASAN =================
        $ulasan = BookComment::with(['buku','rating'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('anggota.rak', compact(
            'user',
            'pinjam',
            'antrian',
            'riwayat',
            'ulasan'
        ));
    }
}