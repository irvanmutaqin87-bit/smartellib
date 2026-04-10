<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Denda;
use App\Models\PengaturanSistem;
use App\Models\AntrianPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\RiwayatBuku;

class PeminjamanController extends Controller
{
    public function pinjam(Request $request, $id)
    {
        $user = Auth::user();
        $anggota = $user?->anggota;
        $buku = Buku::findOrFail($id);

        if (!$anggota) {
            return $this->responseHandler($request, false, 'Data anggota tidak ditemukan.');
        }

        // CEK DENDA BELUM LUNAS
        $dendaAktif = Denda::whereHas('peminjaman', function ($q) use ($anggota) {
                $q->where('anggota_id', $anggota->id);
            })
            ->whereIn('status_denda', ['belum_bayar', 'menunggu_verifikasi', 'ditolak'])
            ->exists();

        if ($dendaAktif) {
            return $this->responseHandler($request, false, 'Kamu masih memiliki denda yang belum diselesaikan.');
        }

        // CEK SEDANG PINJAM BUKU INI
        $sedangPinjamBukuIni = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($sedangPinjamBukuIni) {
            return $this->responseHandler($request, false, 'Kamu sedang meminjam buku ini.');
        }

        // BATAS PEMINJAMAN
        $pengaturan = PengaturanSistem::aktif() ?? PengaturanSistem::first();
        $batasPeminjaman = $pengaturan->batas_peminjaman ?? 3;
        $lamaPeminjaman = $pengaturan->lama_peminjaman ?? 7;

        $jumlahPinjamanAktif = Peminjaman::where('anggota_id', $anggota->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        if ($jumlahPinjamanAktif >= $batasPeminjaman) {
            return $this->responseHandler($request, false, 'Kamu sudah mencapai batas maksimal peminjaman.');
        }

        // CEK STOK TERSEDIA
        $sedangDipinjam = Peminjaman::where('buku_id', $buku->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        $stokTersedia = max(0, ($buku->stok ?? 0) - $sedangDipinjam);

        // Kalau buku fisik dan stok habis → tolak pinjam
    if ($stokTersedia <= 0) {

        // CEK SUDAH ANTRI
        $sudahAntri = AntrianPeminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['menunggu', 'diproses'])
            ->exists();

        if ($sudahAntri) {
            return $this->responseHandler($request, false, 'Kamu sudah ada di antrian.');
        }

        // MASUK ANTRIAN
        AntrianPeminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'status' => 'menunggu',
            'posisi_antrian' => AntrianPeminjaman::where('buku_id', $buku->id)->count() + 1,
        ]);

        return $this->responseHandler($request, false, 'Stok buku habis, silakan antri.', true);
    }

        DB::beginTransaction();

        try {
            $peminjaman = Peminjaman::create([
                'anggota_id' => $anggota->id,
                'buku_id' => $buku->id,
                'tanggal_pinjam' => now(),
                'tanggal_mulai' => now()->toDateString(),
                'tanggal_jatuh_tempo' => now()->addDays($lamaPeminjaman)->toDateString(),
                'status' => 'dipinjam',
            ]);

            // =========================
            // RIWAYAT BUKU (PINJAM)
            // =========================
            RiwayatBuku::create([
                'anggota_id' => $anggota->id,
                'buku_id' => $buku->id,
                'jenis_aktivitas' => 'pinjam',
                'waktu_mulai' => now(),
            ]);

            DB::commit();

            return $this->responseHandler(
                $request,
                true,
                'Buku berhasil dipinjam.',
                true,
                ['peminjaman_id' => $peminjaman->id]
            );

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->responseHandler(
                $request,
                false,
                'Terjadi kesalahan saat meminjam buku: ' . $e->getMessage()
            );
        }
    }

    public function masukAntrian(Request $request, $id)
    {
        $user = Auth::user();
        $anggota = $user?->anggota;
        $buku = Buku::findOrFail($id);

        if (!$anggota) {
            return $this->responseHandler($request, false, 'Data anggota tidak ditemukan.');
        }

        $sudahPinjam = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($sudahPinjam) {
            return $this->responseHandler($request, false, 'Kamu sedang meminjam buku ini.');
        }

        $sudahAntri = AntrianPeminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['menunggu', 'diproses'])
            ->exists();

        if ($sudahAntri) {
            return $this->responseHandler($request, false, 'Kamu sudah ada di antrian buku ini.');
        }

        $sedangDipinjam = Peminjaman::where('buku_id', $buku->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        $stokTersedia = ($buku->stok ?? 0) - $sedangDipinjam;

        if ($stokTersedia > 0) {
            return $this->responseHandler($request, false, 'Stok masih tersedia, silakan pinjam langsung.');
        }

        AntrianPeminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'status' => 'menunggu',
            'posisi_antrian' => AntrianPeminjaman::where('buku_id', $buku->id)->count() + 1,
        ]);

        return $this->responseHandler($request, true, 'Berhasil masuk antrian.', true);
    }

    public function kembalikan(Request $request, $id)
    {
        $user = Auth::user();
        $anggota = $user?->anggota;

        if (!$anggota) {
            return $this->responseHandler($request, false, 'Data anggota tidak ditemukan.');
        }

        $peminjaman = Peminjaman::where('id', $id)
            ->where('anggota_id', $anggota->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->firstOrFail();

        DB::beginTransaction();

        try {
            // =========================
            // UPDATE DATA PENGEMBALIAN
            // =========================
            $tanggalKembali = now();
            $peminjaman->tanggal_kembali = $tanggalKembali->toDateString();
            $peminjaman->status = 'dikembalikan';
            $peminjaman->save();

            // =========================
            // RIWAYAT BUKU (KEMBALIKAN)
            // =========================
            RiwayatBuku::where('anggota_id', $anggota->id)
                ->where('buku_id', $peminjaman->buku_id)
                ->where('jenis_aktivitas', 'pinjam')
                ->whereNull('waktu_selesai')
                ->latest()
                ->first()?->update([
                    'waktu_selesai' => now()
                ]);

            RiwayatBuku::create([
                'anggota_id' => $anggota->id,
                'buku_id' => $peminjaman->buku_id,
                'jenis_aktivitas' => 'kembalikan',
                'waktu_mulai' => now(),
            ]);

            // =========================
            // CEK TERLAMBAT + DENDA
            // =========================
            $pengaturan = PengaturanSistem::aktif();

            $jatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo);

            if ($tanggalKembali->greaterThan($jatuhTempo)) {
                $hariTerlambat = $tanggalKembali->diffInDays($jatuhTempo);

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

            // =========================
            // PROSES ANTRIAN OTOMATIS
            // =========================
            $antrianPertama = AntrianPeminjaman::where('buku_id', $peminjaman->buku_id)
                ->where('status', 'menunggu')
                ->orderBy('created_at', 'asc')
                ->first();

            if ($antrianPertama) {

                // AUTO PINJAM
                Peminjaman::create([
                    'anggota_id' => $antrianPertama->anggota_id,
                    'buku_id' => $peminjaman->buku_id,
                    'tanggal_pinjam' => now(),
                    'tanggal_mulai' => now()->toDateString(),
                    'tanggal_jatuh_tempo' => now()->addDays($pengaturan->lama_peminjaman)->toDateString(),
                    'status' => 'dipinjam',
                ]);

                // HAPUS DARI ANTRIAN
                $antrianPertama->delete();
            }

            DB::commit();

            return $this->responseHandler(
                $request,
                true,
                'Buku berhasil dikembalikan.',
                true
            );

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->responseHandler(
                $request,
                false,
                'Terjadi kesalahan saat mengembalikan buku: ' . $e->getMessage()
            );
        }
    }

    private function responseHandler(Request $request, $success, $message, $reload = false, $data = [])
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => $success,
                'message' => $message,
                'reload' => $reload,
                'data' => $data,
            ]);
        }

        return back()->with($success ? 'success' : 'error', $message);
    }

}