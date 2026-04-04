<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\BookComment;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookReviewController extends Controller
{
    public function storeRating(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::user();
        $anggota = $user?->anggota;

        if (!$anggota) {
            return back()->with('error', 'Data anggota tidak ditemukan.');
        }

        $bolehUlasan = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $id)
            ->where('status', 'dikembalikan')
            ->exists();

        if (!$bolehUlasan) {
            return back()->with('error', 'Anda hanya bisa memberi rating setelah mengembalikan buku.');
        }

        Rating::updateOrCreate(
            [
                'user_id' => $user->id,
                'buku_id' => $id,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        return back()->with('success', 'Rating berhasil disimpan.');
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:book_comments,id',
        ]);

        $user = Auth::user();
        $anggota = $user?->anggota;

        if (!$anggota) {
            return back()->with('error', 'Data anggota tidak ditemukan.');
        }

        $bolehUlasan = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $id)
            ->where('status', 'dikembalikan')
            ->exists();

        if (!$bolehUlasan) {
            return back()->with('error', 'Anda hanya bisa memberi ulasan setelah mengembalikan buku.');
        }

        BookComment::create([
            'user_id' => $user->id,
            'buku_id' => $id,
            'parent_id' => $request->parent_id,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim.');
    }
}