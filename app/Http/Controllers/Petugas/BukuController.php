<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    // =========================
    // LIST DATA BUKU
    // =========================
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        // =========================
        // SEARCH
        // =========================
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%')
                  ->orWhere('kode_buku', 'like', '%' . $search . '%');
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

            // NOTE:
            // "Dipinjam" belum dipakai di sini
            // karena status dipinjam idealnya berdasarkan transaksi aktif
        }

        // =========================
        // FILTER KATEGORI
        // =========================
        if ($request->filled('kategoriFilter') && is_numeric($request->kategoriFilter)) {
            $query->where('kategori_id', $request->kategoriFilter);
        }

        // =========================
        // PAGINATION + QUERY STRING
        // =========================
        /** @var \Illuminate\Pagination\LengthAwarePaginator $data */
        $data = $query->latest()->paginate(10);

        $data->withQueryString();

        // =========================
        // AJAX RESPONSE
        // =========================
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'table' => view('petugas.buku.partials.table', compact('data'))->render(),
                'pagination' => view('components.pagination', ['paginator' => $data])->render(),
                'totalBox' => 'Total Buku : ' . $data->total(),
            ]);
        }

        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('petugas.buku.index', compact('data', 'kategori'));
    }

    // =========================
    // HALAMAN TAMBAH
    // =========================
    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $kode_buku = $this->generateKodeBuku();

        return view('petugas.buku.create', compact('kategori', 'kode_buku'));
    }

    // =========================
    // SIMPAN BUKU
    // =========================
    public function store(Request $request)
    {
        try {
            // =========================
            // DEBUG CEK FILE UPLOAD ERROR
            // =========================
            if ($request->hasFile('file_buku')) {
                $file = $request->file('file_buku');

                if (!$file->isValid()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Upload file gagal. Error code: ' . $file->getError(),
                    ], 422);
                }
            }

            $validated = $request->validate([
                'kode_buku' => 'required|string|max:20|unique:buku,kode_buku',
                'judul' => 'required|string|max:100',
                'penulis' => 'required|string|max:100',
                'penerbit' => 'required|string|max:100',
                'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
                'stok' => 'required|integer|min:0',
                'total_halaman' => 'required|integer|min:1',
                'kategori_id' => 'nullable|exists:kategori,id',
                'deskripsi' => 'nullable|string',
                'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'file_buku' => 'nullable|mimes:pdf|max:46080',
            ], [
                'file_buku.mimes' => 'File buku harus berformat PDF.',
                'file_buku.max' => 'Ukuran file PDF maksimal 45 MB.',
                'cover.image' => 'Cover harus berupa gambar.',
                'cover.mimes' => 'Cover harus JPG, JPEG, PNG, atau WEBP.',
                'cover.max' => 'Ukuran cover maksimal 2 MB.',
            ]);

            // =========================
            // UPLOAD COVER
            // =========================
            if ($request->hasFile('cover')) {
                $validated['cover'] = $request->file('cover')->store('buku/cover', 'public');
            }

            // =========================
            // UPLOAD FILE PDF
            // =========================
            if ($request->hasFile('file_buku')) {
                $validated['file_buku'] = $request->file('file_buku')->store('buku/file', 'public');
            }

            Buku::create($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Buku berhasil ditambahkan',
                ]);
            }

            return redirect()->route('petugas.buku.index')->with('success', 'Buku berhasil ditambahkan');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors(),
                ], 422);
            }

            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan buku: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Gagal menyimpan buku: ' . $e->getMessage());
        }
    }
    // =========================
    // HALAMAN EDIT
    // =========================
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('petugas.buku.edit', compact('buku', 'kategori'));
    }

    // =========================
    // UPDATE BUKU
    // =========================
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        try {
            $validated = $request->validate([
                'kode_buku' => 'required|string|max:20|unique:buku,kode_buku,' . $buku->id,
                'judul' => 'required|string|max:100',
                'penulis' => 'required|string|max:100',
                'penerbit' => 'required|string|max:100',
                'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
                'stok' => 'required|integer|min:0',
                'total_halaman' => 'required|integer|min:1',
                'kategori_id' => 'nullable|exists:kategori,id',
                'deskripsi' => 'nullable|string',
                'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'file_buku' => 'nullable|mimes:pdf|max:46080',
            ], [
                'file_buku.mimes' => 'File buku harus berformat PDF.',
                'file_buku.max' => 'Ukuran file PDF maksimal 45 MB.',
                'cover.image' => 'Cover harus berupa gambar.',
                'cover.mimes' => 'Cover harus JPG, JPEG, PNG, atau WEBP.',
                'cover.max' => 'Ukuran cover maksimal 2 MB.',
            ]);

            if ($request->hasFile('cover')) {
                if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                    Storage::disk('public')->delete($buku->cover);
                }

                $validated['cover'] = $request->file('cover')->store('buku/cover', 'public');
            }

            if ($request->hasFile('file_buku')) {
                if ($buku->file_buku && Storage::disk('public')->exists($buku->file_buku)) {
                    Storage::disk('public')->delete($buku->file_buku);
                }

                $validated['file_buku'] = $request->file('file_buku')->store('buku/file', 'public');
            }

            $buku->update($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Buku berhasil diupdate',
                ]);
            }

            return back()->with('success', 'Buku berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors(),
                ], 422);
            }

            throw $e;
        } catch (\Throwable $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal update buku: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Gagal update buku: ' . $e->getMessage());
        }
    }

    // =========================
    // DETAIL BUKU
    // =========================
    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        $stokTersimpan = $buku->stok;

        $sedangDipinjam = Peminjaman::query()
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        $stokTotal = $stokTersimpan + $sedangDipinjam;
        $tersedia = $stokTersimpan;

        return view('petugas.buku.show', compact(
            'buku',
            'stokTotal',
            'sedangDipinjam',
            'tersedia'
        ));
    }

    // =========================
    // HAPUS BUKU
    // =========================
    public function delete(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        // NOTE:
        // nanti kalau sudah ada relasi transaksi,
        // tambahkan pengecekan sebelum delete

        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        if ($buku->file_buku && Storage::disk('public')->exists($buku->file_buku)) {
            Storage::disk('public')->delete($buku->file_buku);
        }

        $buku->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil dihapus',
            ]);
        }

        return back()->with('success', 'Buku berhasil dihapus');
    }

    // =========================
    // AUTO GENERATE KODE BUKU
    // =========================
    private function generateKodeBuku()
    {
        $lastKode = Buku::where('kode_buku', 'like', 'BK%')
            ->orderByRaw("CAST(SUBSTRING(kode_buku, 3) AS UNSIGNED) DESC")
            ->value('kode_buku');

        if (!$lastKode) {
            return 'BK001';
        }

        $lastNumber = (int) substr($lastKode, 2);
        $newNumber = $lastNumber + 1;

        return 'BK' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}