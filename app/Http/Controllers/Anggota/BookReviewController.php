<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Rating;
use App\Models\BookComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ], [
            'rating.required' => 'Rating wajib diisi.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'comment.required' => 'Komentar ulasan wajib diisi.',
        ]);

        $buku = Buku::findOrFail($id);
        $userId = Auth::id();

        // Simpan / update rating
        Rating::updateOrCreate(
            [
                'user_id' => $userId,
                'buku_id' => $buku->id,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        // Simpan / update komentar utama
        BookComment::updateOrCreate(
            [
                'user_id' => $userId,
                'buku_id' => $buku->id,
                'parent_id' => null,
            ],
            [
                'comment' => $request->comment,
            ]
        );

        return redirect()->back()->with('success', 'Ulasan berhasil disimpan.');
    }
}