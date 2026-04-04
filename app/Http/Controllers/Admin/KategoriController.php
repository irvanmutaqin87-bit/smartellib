<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Daftar kategori
    public function index(Request $request)
    {
        $query = Kategori::withCount('buku')->latest();

        if ($request->search) {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%');
        }

        $data = $query->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.kategori.partials.table', compact('data'))->render(),
                'pagination' => view('components.pagination', ['paginator' => $data])->render(),
                'totalBox' => 'Total Kategori : ' . $data->total(),
            ]);
        }

        return view('admin.kategori.index', compact('data'));
    }

    // Halaman tambah kategori
    public function create()
    {
        return view('admin.kategori.create');
    }

    // Simpan kategori
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Kategori berhasil ditambahkan'
            ]);
        }

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    // Halaman edit kategori
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Kategori berhasil diupdate',
                'redirect' => route('admin.kategori.index')
            ]);
        }

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    // Delete kategori
    public function delete($id)
    {
        Kategori::findOrFail($id)->delete();
        return response()->json(['message' => 'Kategori berhasil dihapus']);
    }

    // =========================
    // AJAX LIST KATEGORI REALTIME
    // =========================
    public function ajaxList()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get(['id', 'nama_kategori', 'updated_at']);

        $lastUpdate = Kategori::max('updated_at');

        return response()->json([
            'success' => true,
            'kategori' => $kategori->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_kategori' => $item->nama_kategori,
                ];
            }),
            'updated_at' => $lastUpdate ? strtotime($lastUpdate) : 0,
        ]);
    }
}