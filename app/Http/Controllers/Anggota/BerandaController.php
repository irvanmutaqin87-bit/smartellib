<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;

class BerandaController extends Controller
{
    public function index()
    {
        // =========================
        // 10 BUKU UNTUK CAROUSEL ATAS
        // =========================
        $carouselBooks = Buku::with('kategori')
            ->withCount([
                'ratings as total_rating'
            ])
            ->withAvg('ratings as average_rating', 'rating')
            ->whereNotNull('cover')
            ->latest()
            ->take(10)
            ->get();

        // =========================
        // REKOMENDASI BUKU
        // Bisa pakai buku terbaru / populer
        // =========================
        $rekomendasiBooks = Buku::with('kategori')
            ->withCount([
                'ratings as total_rating',
                'peminjaman as total_dipinjam'
            ])
            ->withAvg('ratings as average_rating', 'rating')
            ->orderByDesc('total_dipinjam')
            ->orderByDesc('id')
            ->take(15)
            ->get();

        // =========================
        // BUKU TERATAS = RATING TERTINGGI
        // =========================
        $bukuTeratas = Buku::with('kategori')
            ->withCount([
                'ratings as total_rating'
            ])
            ->withAvg('ratings as average_rating', 'rating')
            ->orderByDesc('average_rating')
            ->orderByDesc('total_rating')
            ->take(8)
            ->get();

        return view('anggota.beranda', compact(
            'carouselBooks',
            'rekomendasiBooks',
            'bukuTeratas'
        ));
    }
}