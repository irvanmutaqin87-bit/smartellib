<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\AntrianPeminjaman;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntrianPeminjamanController extends Controller
{
    // =========================
    // INDEX DATA ANTRIAN
    // =========================
    public function index(Request $request)
    {
        $query = AntrianPeminjaman::with(['anggota', 'buku']);

        // SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('anggota', function ($anggota) use ($search) {
                    $anggota->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nis', 'like', "%{$search}%");
                })->orWhereHas('buku', function ($buku) use ($search) {
                    $buku->where('judul', 'like', "%{$search}%")
                         ->orWhere('kode_buku', 'like', "%{$search}%");
                });
            });
        }

        // FILTER STATUS
        if ($request->filled('statusFilter')) {
            $query->where('status', $request->statusFilter);
        }

        /** @var \Illuminate\Pagination\LengthAwarePaginator $data */
        $data = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('petugas.antrian.partials.table', compact('data'))->render(),
                'pagination' => view('components.pagination', ['paginator' => $data])->render(),
                'totalBox' => 'Total Antrian : ' . $data->total(),
            ]);
        }

        return view('petugas.antrian.index', compact('data'));
    }

    // =========================
    // PROSES ANTRIAN
    // =========================
    public function proses($id)
    {
        DB::beginTransaction();

        try {
            $antrian = AntrianPeminjaman::with('buku')->findOrFail($id);

            if ($antrian->status !== 'menunggu') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya antrian menunggu yang bisa diproses.',
                ], 422);
            }

            // Cegah ada 2 antrian diproses untuk buku yang sama
            $sudahAdaDiproses = AntrianPeminjaman::where('buku_id', $antrian->buku_id)
                ->where('status', 'diproses')
                ->where('id', '!=', $antrian->id)
                ->exists();

            if ($sudahAdaDiproses) {
                return response()->json([
                    'success' => false,
                    'message' => 'Masih ada antrian lain yang sedang diproses untuk buku ini.',
                ], 422);
            }

            $antrian->update([
                'status' => 'diproses',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Antrian berhasil diproses.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses antrian.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // =========================
    // SELESAIKAN ANTRIAN → BUAT PEMINJAMAN
    // =========================
  public function selesai($id)
  {
      DB::beginTransaction();

      try {
          $antrian = AntrianPeminjaman::with(['anggota', 'buku'])->findOrFail($id);
          $pengaturan = \App\Models\PengaturanSistem::aktif();

          if ($antrian->status !== 'diproses') {
              return response()->json([
                  'success' => false,
                  'message' => 'Antrian belum siap diselesaikan.',
              ], 422);
          }

          if ($antrian->buku->stok <= 0) {
              return response()->json([
                  'success' => false,
                  'message' => 'Stok buku masih habis.',
              ], 422);
          }

          // =========================
          // CEK DENDA AKTIF
          // =========================
          $punyaDendaAktif = \App\Models\Denda::whereHas('peminjaman', function ($q) use ($antrian) {
              $q->where('anggota_id', $antrian->anggota_id);
          })->whereIn('status_denda', ['belum_bayar', 'menunggu_verifikasi', 'ditolak'])
            ->exists();

          if ($punyaDendaAktif) {
              return response()->json([
                  'success' => false,
                  'message' => 'Anggota masih memiliki denda aktif.',
              ], 422);
          }

          // =========================
          // CEK BATAS PEMINJAMAN
          // =========================
          $jumlahPinjamanAktif = Peminjaman::where('anggota_id', $antrian->anggota_id)
              ->whereIn('status', ['dipinjam', 'terlambat'])
              ->count();

          if ($jumlahPinjamanAktif >= $pengaturan->batas_peminjaman) {
              return response()->json([
                  'success' => false,
                  'message' => 'Anggota sudah mencapai batas maksimal peminjaman.',
              ], 422);
          }

          // =========================
          // CEK PINJAMAN AKTIF BUKU INI
          // =========================
          $cekAktif = Peminjaman::where('anggota_id', $antrian->anggota_id)
              ->where('buku_id', $antrian->buku_id)
              ->whereIn('status', ['dipinjam', 'terlambat'])
              ->exists();

          if ($cekAktif) {
              return response()->json([
                  'success' => false,
                  'message' => 'Anggota masih memiliki pinjaman aktif untuk buku ini.',
              ], 422);
          }

          // =========================
          // BUAT PEMINJAMAN BARU
          // =========================
          $tanggalMulai = Carbon::today();
          $lamaHari = $pengaturan->lama_peminjaman;

          Peminjaman::create([
              'anggota_id' => $antrian->anggota_id,
              'buku_id' => $antrian->buku_id,
              'tanggal_pinjam' => now(),
              'tanggal_mulai' => $tanggalMulai,
              'tanggal_jatuh_tempo' => $tanggalMulai->copy()->addDays($lamaHari),
              'status' => 'dipinjam',
          ]);

          // =========================
          // KURANGI STOK
          // =========================
          $antrian->buku->decrement('stok');

          // =========================
          // UPDATE ANTRIAN
          // =========================
          $antrian->update([
              'status' => 'selesai',
          ]);

          DB::commit();

          return response()->json([
              'success' => true,
              'message' => 'Antrian berhasil diselesaikan dan buku dipinjamkan.',
          ]);
      } catch (\Throwable $e) {
          DB::rollBack();

          return response()->json([
              'success' => false,
              'message' => 'Gagal menyelesaikan antrian.',
              'error' => $e->getMessage(),
          ], 500);
      }
  }
}