<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        // =========================
        // FILTER KATEGORI (MULTIPLE)
        // =========================
        if ($request->filled('kategori')) {
            $kategoriIds = array_filter((array) $request->kategori);

            if (!empty($kategoriIds)) {
                $query->whereIn('kategori_id', $kategoriIds);
            }
        }

        // =========================
        // FILTER PENGARANG (MULTIPLE)
        // =========================
        if ($request->filled('penulis')) {
            $penulisList = array_filter((array) $request->penulis);

            if (!empty($penulisList)) {
                $query->whereIn('penulis', $penulisList);
            }
        }

        // =========================
        // FILTER TAHUN TERBIT (MULTIPLE)
        // =========================
        if ($request->filled('tahun')) {
            $tahunList = array_filter((array) $request->tahun);

            if (!empty($tahunList)) {
                $query->whereIn('tahun_terbit', $tahunList);
            }
        }

        // =========================
        // FILTER KOLEKSI TERSEDIA
        // =========================
        if ($request->available_only == '1') {
            $query->where('stok', '>', 0);
        }

        // =========================
        // DATA BUKU
        // =========================
        $books = $query->latest()->get();

        // =========================
        // DATA FILTER DINAMIS
        // =========================

        // kategori dari tabel kategori
        $kategoriList = Kategori::orderBy('nama_kategori')->get();

        // pengarang unik dari tabel buku
        $penulisList = Buku::select('penulis')
            ->whereNotNull('penulis')
            ->where('penulis', '!=', '')
            ->distinct()
            ->orderBy('penulis')
            ->pluck('penulis');

        // tahun unik dari tabel buku
        $tahunList = Buku::select('tahun_terbit')
            ->whereNotNull('tahun_terbit')
            ->distinct()
            ->orderByDesc('tahun_terbit')
            ->pluck('tahun_terbit');

        return view('anggota.buku.index', compact(
            'books',
            'kategoriList',
            'penulisList',
            'tahunList'
        ));
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        return view('anggota.buku.detail', compact('buku'));
    }
}