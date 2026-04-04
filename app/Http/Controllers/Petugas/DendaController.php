<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\BayarDenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Denda::with(['peminjaman.anggota', 'peminjaman.buku']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('peminjaman.anggota', function ($anggota) use ($search) {
                    $anggota->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nis', 'like', "%{$search}%");
                })->orWhereHas('peminjaman.buku', function ($buku) use ($search) {
                    $buku->where('judul', 'like', "%{$search}%")
                         ->orWhere('kode_buku', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('statusFilter')) {
            $query->where('status_denda', $request->statusFilter);
        }

        $data = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('petugas.denda.partials.table', compact('data'))->render(),
                'pagination' => view('components.pagination', ['paginator' => $data])->render(),
                'totalBox' => 'Total Denda : ' . $data->total(),
            ]);
        }

        return view('petugas.denda.index', compact('data'));
    }

    // =========================
    // VERIFIKASI PEMBAYARAN
    // =========================
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'catatan_verifikasi' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            $denda = Denda::findOrFail($id);

            if ($denda->status_denda !== 'menunggu_verifikasi') {
                return response()->json([
                    'success' => false,
                    'message' => 'Status denda tidak valid untuk diverifikasi.'
                ], 422);
            }

            $petugas = auth()->user()->petugas ?? null;

            $denda->update([
                'status_denda' => 'lunas',
                'tanggal_verifikasi' => now(),
                'verifikator_id' => $petugas?->id,
                'catatan_verifikasi' => $request->catatan_verifikasi,
            ]);

            // HISTORI PEMBAYARAN BARU DIBUAT SAAT VALID
            BayarDenda::create([
                'denda_id' => $denda->id,
                'jumlah_bayar' => $denda->jumlah_denda,
                'tanggal_bayar' => now(),
                'metode_bayar' => 'QRIS / Transfer',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran denda berhasil diverifikasi.'
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal memverifikasi pembayaran.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // =========================
    // TOLAK PEMBAYARAN
    // =========================
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'catatan_verifikasi' => 'required|string|max:500',
        ], [
            'catatan_verifikasi.required' => 'Catatan penolakan wajib diisi.',
        ]);

        try {
            $denda = Denda::findOrFail($id);

            if ($denda->status_denda !== 'menunggu_verifikasi') {
                return response()->json([
                    'success' => false,
                    'message' => 'Status denda tidak valid untuk ditolak.'
                ], 422);
            }

            $petugas = auth()->user()->petugas ?? null;

            $denda->update([
                'status_denda' => 'ditolak',
                'tanggal_verifikasi' => now(),
                'verifikator_id' => $petugas?->id,
                'catatan_verifikasi' => $request->catatan_verifikasi,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran ditolak. Anggota harus upload ulang.'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak pembayaran.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // =========================
    // HAPUS DENDA
    // =========================
    public function destroy($id)
    {
        try {
            $denda = Denda::findOrFail($id);
            $denda->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data denda berhasil dihapus.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data denda.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}