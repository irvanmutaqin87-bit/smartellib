<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Rating;
use App\Models\BookComment;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function store(Request $request, $buku_id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        $user = Auth::user();

        // ✅ CEK PERNAH PINJAM
        $pernahPinjam = Peminjaman::where('anggota_id', $user->anggota->id)
            ->where('buku_id', $buku_id)
            ->where('status', 'dikembalikan')
            ->exists();

        if (!$pernahPinjam) {
            return back()->with('error', 'Kamu belum pernah meminjam buku ini.');
        }

        // =========================
        // RATING (UPDATE / CREATE)
        // =========================
        Rating::updateOrCreate(
            [
                'user_id' => $user->id,
                'buku_id' => $buku_id
            ],
            [
                'rating' => $request->rating
            ]
        );

        // =========================
        // KOMENTAR (UPDATE / CREATE)
        // =========================
        BookComment::updateOrCreate(
            [
                'user_id' => $user->id,
                'buku_id' => $buku_id,
                'parent_id' => null
            ],
            [
                'comment' => $request->comment
            ]
        );

        return back()->with('success', 'Ulasan berhasil disimpan.');
    }
}
