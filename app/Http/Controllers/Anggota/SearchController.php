<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('anggota.search');
    }

    public function search(Request $request)
    {
        $query = trim($request->q ?? '');

        if ($query === '' || strlen($query) < 1) {
            return response()->json([]);
        }

        $books = Buku::query()
            ->where(function ($q) use ($query) {
                $q->where('judul', 'like', '%' . $query . '%')
                  ->orWhere('penulis', 'like', '%' . $query . '%')
                  ->orWhere('penerbit', 'like', '%' . $query . '%');
            })
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($buku) {

                // =========================
                // NORMALISASI COVER TOTAL
                // =========================
                $coverUrl = asset('images/default-book.png');

                if (!empty($buku->cover)) {
                    $cover = trim($buku->cover);

                    // kalau ternyata sudah full URL
                    if (str_starts_with($cover, 'http://') || str_starts_with($cover, 'https://')) {
                        $coverUrl = $cover;
                    } else {
                        // hapus slash depan kalau ada
                        $cover = ltrim($cover, '/');

                        // kalau di DB sudah tersimpan "storage/..."
                        if (str_starts_with($cover, 'storage/')) {
                            $coverUrl = asset($cover);
                        } else {
                            // default: simpanan file upload Laravel
                            $coverUrl = asset('storage/' . $cover);
                        }
                    }
                }

                return [
                    'id' => $buku->id,
                    'judul' => $buku->judul,
                    'penulis' => $buku->penulis,
                    'cover' => $coverUrl,
                ];
            });

        return response()->json($books);
    }
}