<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\AntrianPeminjaman;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PengaturanSistem;

class PeminjamanController extends Controller
{
    // =========================
    // INDEX DATA PEMINJAMAN
    // =========================
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku', 'denda']);

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

        $anggota = Anggota::with('user')
            ->whereHas('user', function ($q) {
                $q->where('status', 'aktif');
            })
            ->get();

        $buku = Buku::where('stok', '>', 0)->get();

        $pengaturan = PengaturanSistem::aktif();

        if ($request->ajax()) {
            return response()->json([
                'table' => view('petugas.peminjaman.partials.table', compact('data'))->render(),
                'pagination' => view('components.pagination', ['paginator' => $data])->render(),
                'totalBox' => 'Total Peminjaman : ' . $data->total(),
            ]);
        }

        return view('petugas.peminjaman.index', compact('data', 'anggota', 'buku', 'pengaturan'));
    }

    // =========================
    // STORE PEMINJAMAN
    // =========================
    public function store(Request $request)
    {
        $pengaturan = PengaturanSistem::aktif();

        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|exists:buku,id',
            'tanggal_mulai' => 'required|date',
            'lama_hari' => 'required|integer|min:1|max:' . $pengaturan->lama_peminjaman,
        ], [
            'anggota_id.required' => 'Anggota wajib dipilih.',
            'buku_id.required' => 'Buku wajib dipilih.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'lama_hari.required' => 'Lama pinjam wajib diisi.',
            'lama_hari.max' => 'Lama pinjam melebihi batas maksimal sistem (' . $pengaturan->lama_peminjaman . ' hari).',
        ]);

        DB::beginTransaction();

        try {
            $anggotaId = $request->anggota_id;
            $bukuId = $request->buku_id;
            $lamaHari = (int) $request->lama_hari;
            $tanggalMulai = Carbon::parse($request->tanggal_mulai);

            $buku = Buku::findOrFail($bukuId);

            // =========================
            // CEK DENDA AKTIF
            // =========================
            $punyaDendaAktif = Denda::whereHas('peminjaman', function ($q) use ($anggotaId) {
                $q->where('anggota_id', $anggotaId);
            })->whereIn('status_denda', ['belum_bayar', 'menunggu_verifikasi', 'ditolak'])
              ->exists();

            if ($punyaDendaAktif) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota masih memiliki denda aktif yang belum selesai.',
                ], 422);
            }

            // =========================
            // CEK BATAS PEMINJAMAN ANGGOTA
            // =========================
            $jumlahPinjamanAktif = Peminjaman::where('anggota_id', $anggotaId)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->count();

            if ($jumlahPinjamanAktif >= $pengaturan->batas_peminjaman) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota sudah mencapai batas maksimal peminjaman (' . $pengaturan->batas_peminjaman . ' buku).',
                ], 422);
            }

            // =========================
            // CEK MASIH PUNYA PINJAMAN AKTIF BUKU INI
            // =========================
            $cekAktif = Peminjaman::where('anggota_id', $anggotaId)
                ->where('buku_id', $bukuId)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->exists();

            if ($cekAktif) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota masih memiliki pinjaman aktif untuk buku ini.',
                ], 422);
            }

            // =========================
            // CEK STOK
            // =========================
            if ($buku->stok <= 0) {
                $sudahAntri = AntrianPeminjaman::where('anggota_id', $anggotaId)
                    ->where('buku_id', $bukuId)
                    ->whereIn('status', ['menunggu', 'diproses'])
                    ->exists();

                if ($sudahAntri) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anggota sudah masuk antrian buku ini.',
                    ], 422);
                }

                $lastQueue = AntrianPeminjaman::where('buku_id', $bukuId)->max('posisi_antrian') ?? 0;

                AntrianPeminjaman::create([
                    'anggota_id' => $anggotaId,
                    'buku_id' => $bukuId,
                    'posisi_antrian' => $lastQueue + 1,
                    'status' => 'menunggu',
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Stok buku habis. Anggota berhasil dimasukkan ke antrian.',
                    'redirect' => route('petugas.peminjaman.index'),
                ]);
            }

            // =========================
            // BUAT PEMINJAMAN
            // =========================
            Peminjaman::create([
                'anggota_id' => $anggotaId,
                'buku_id' => $bukuId,
                'tanggal_pinjam' => now(),
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_jatuh_tempo' => $tanggalMulai->copy()->addDays($lamaHari),
                'status' => 'dipinjam',
            ]);

            // =========================
            // KURANGI STOK
            // =========================
            $buku->decrement('stok');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil dibuat.',
                'redirect' => route('petugas.peminjaman.index'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat peminjaman.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // =========================
    // PENGEMBALIAN BUKU
    // =========================
    public function kembalikan($id)
    {
        DB::beginTransaction();

        try {
            $pengaturan = PengaturanSistem::aktif();
            $peminjaman = Peminjaman::with('buku')->findOrFail($id);

            if ($peminjaman->status === 'dikembalikan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku ini sudah dikembalikan.',
                ], 422);
            }

            $today = Carbon::today();
            $jatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo);

            $hariTerlambat = 0;
            $jumlahDenda = 0;

            if ($today->gt($jatuhTempo)) {
                $hariTerlambat = $jatuhTempo->diffInDays($today);
                $jumlahDenda = $hariTerlambat * $pengaturan->denda_per_hari;

                Denda::updateOrCreate(
                    ['peminjaman_id' => $peminjaman->id],
                    [
                        'hari_terlambat' => $hariTerlambat,
                        'jumlah_denda' => $jumlahDenda,
                        'status_denda' => 'belum_bayar',
                    ]
                );
            }

            $peminjaman->update([
                'tanggal_kembali' => $today,
                'status' => 'dikembalikan',
            ]);

            $peminjaman->buku->increment('stok');

            $this->prosesAntrianBerikutnya($peminjaman->buku_id);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $hariTerlambat > 0
                    ? 'Buku berhasil dikembalikan dan terkena denda Rp ' . number_format($jumlahDenda, 0, ',', '.')
                    : 'Buku berhasil dikembalikan.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pengembalian.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // =========================
    // UPDATE STATUS TERLAMBAT OTOMATIS
    // =========================
    public function updateTerlambatMassal()
    {
        $today = Carbon::today();
        $pengaturan = PengaturanSistem::aktif();

        $data = Peminjaman::where('status', 'dipinjam')
            ->whereDate('tanggal_jatuh_tempo', '<', $today)
            ->get();

        foreach ($data as $item) {
            $hariTerlambat = Carbon::parse($item->tanggal_jatuh_tempo)->diffInDays($today);
            $jumlahDenda = $hariTerlambat * $pengaturan->denda_per_hari;

            $item->update([
                'status' => 'terlambat',
            ]);

            Denda::updateOrCreate(
                ['peminjaman_id' => $item->id],
                [
                    'hari_terlambat' => $hariTerlambat,
                    'jumlah_denda' => $jumlahDenda,
                    'status_denda' => 'belum_bayar',
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Status terlambat berhasil diperbarui.',
        ]);
    }

    // =========================
    // PRIVATE: PROSES ANTRIAN
    // =========================
    private function prosesAntrianBerikutnya($bukuId)
    {
        // Kalau sudah ada yang diproses, jangan ambil lagi
        $sudahAdaDiproses = AntrianPeminjaman::where('buku_id', $bukuId)
            ->where('status', 'diproses')
            ->exists();

        if ($sudahAdaDiproses) {
            return;
        }

        $antrian = AntrianPeminjaman::where('buku_id', $bukuId)
            ->where('status', 'menunggu')
            ->orderBy('posisi_antrian')
            ->first();

        if ($antrian) {
            $antrian->update([
                'status' => 'diproses',
            ]);
        }
    }
}