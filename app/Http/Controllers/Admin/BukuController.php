<?php

namespace App\Http\Controllers\Admin;

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
        // SEARCH
        // =========================
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_buku', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%');
            });
        }

        // =========================
        // FILTER STATUS
        // =========================
        if ($request->filled('statusFilter')) {
            if ($request->statusFilter === 'tersedia') {
                $query->where('stok', '>', 0);
            }

            if ($request->statusFilter === 'habis') {
                $query->where('stok', '<=', 0);
            }
        }

        // =========================
        // FILTER KATEGORI
        // =========================
        if ($request->filled('kategoriFilter')) {
            $query->where('kategori_id', $request->kategoriFilter);
        }

        /** @var \Illuminate\Pagination\LengthAwarePaginator $data */
        $data = $query->paginate(10);

        /** @var \Illuminate\Pagination\LengthAwarePaginator $data */
        $data = $data->withQueryString();
        $kategori = Kategori::orderBy('nama_kategori')->get();

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.buku.partials.table', compact('data'))->render(),
                'pagination' => view('components.pagination', ['paginator' => $data])->render(),
                'totalBox' => 'Total Buku : ' . $data->total(),
            ]);
        }

        return view('admin.buku.index', compact('data', 'kategori'));
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        // kalau kamu pakai sistem stok yang sederhana
        $stokTotal = $buku->stok;
        $sedangDipinjam = 0; // nanti bisa disambung ke tabel peminjaman
        $tersedia = $buku->stok;

        return view('admin.buku.show', compact(
            'buku',
            'stokTotal',
            'sedangDipinjam',
            'tersedia'
        ));
    }
}