<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\AntrianPeminjaman;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\PengaturanSistem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    // =========================
    // PINJAM BUKU
    // =========================
    public function pinjam($id)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu.',
                ], 401);
            }

            if ($user->role !== 'anggota') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses hanya untuk anggota.',
                ], 403);
            }

            if ($user->status !== 'aktif') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun kamu belum aktif.',
                ], 403);
            }

            $anggota = $user->anggota;

            if (!$anggota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil anggota tidak ditemukan.',
                ], 404);
            }

            $buku = Buku::findOrFail($id);
            $pengaturan = PengaturanSistem::aktif();

            if (!empty($buku->file_buku)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku digital tidak perlu dipinjam.',
                ], 422);
            }

            if ($buku->stok <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok buku habis. Silakan masuk antrian.',
                ], 422);
            }

            // CEK DENDA AKTIF
            $punyaDendaAktif = Denda::whereHas('peminjaman', function ($q) use ($anggota) {
                $q->where('anggota_id', $anggota->id);
            })
            ->whereIn('status_denda', ['belum_bayar', 'menunggu_verifikasi', 'ditolak'])
            ->exists();

            if ($punyaDendaAktif) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kamu masih memiliki denda aktif yang belum selesai.',
                ], 422);
            }

            // CEK BATAS PINJAMAN
            $jumlahPinjamanAktif = Peminjaman::where('anggota_id', $anggota->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->count();

            if ($jumlahPinjamanAktif >= $pengaturan->batas_peminjaman) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kamu sudah mencapai batas maksimal peminjaman.',
                ], 422);
            }

            // CEK SUDAH PINJAM BUKU INI
            $sudahPinjamAktif = Peminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->exists();

            if ($sudahPinjamAktif) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kamu masih sedang meminjam buku ini.',
                ], 422);
            }

            $tanggalMulai = Carbon::today();

            $peminjaman = Peminjaman::create([
                'anggota_id' => $anggota->id,
                'buku_id' => $buku->id,
                'tanggal_pinjam' => now(),
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_jatuh_tempo' => $tanggalMulai->copy()->addDays($pengaturan->lama_peminjaman),
                'status' => 'dipinjam',
            ]);

            $buku->decrement('stok');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil dipinjam.',
                'reload' => true,
                'data' => [
                    'peminjaman_id' => $peminjaman->id,
                ]
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal meminjam buku.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // =========================
    // MASUK ANTRIAN
    // =========================
    public function masukAntrian($id)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu.',
                ], 401);
            }

            if ($user->role !== 'anggota') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses hanya untuk anggota.',
                ], 403);
            }

            if ($user->status !== 'aktif') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun kamu belum aktif.',
                ], 403);
            }

            $anggota = $user->anggota;

            if (!$anggota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil anggota tidak ditemukan.',
                ], 404);
            }

            $buku = Buku::findOrFail($id);

            if (!empty($buku->file_buku)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku digital tidak menggunakan antrian.',
                ], 422);
            }

            if ($buku->stok > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok buku masih tersedia. Kamu bisa langsung pinjam.',
                ], 422);
            }

            $sudahAntri = AntrianPeminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->whereIn('status', ['menunggu', 'diproses'])
                ->exists();

            if ($sudahAntri) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kamu sudah masuk antrian buku ini.',
                ], 422);
            }

            $lastQueue = AntrianPeminjaman::where('buku_id', $buku->id)->max('posisi_antrian') ?? 0;

            $antrian = AntrianPeminjaman::create([
                'anggota_id' => $anggota->id,
                'buku_id' => $buku->id,
                'posisi_antrian' => $lastQueue + 1,
                'status' => 'menunggu',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil masuk antrian peminjaman.',
                'reload' => true,
                'data' => [
                    'antrian_id' => $antrian->id,
                    'posisi_antrian' => $antrian->posisi_antrian,
                ]
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal masuk antrian.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // =========================
    // KEMBALIKAN BUKU
    // =========================
    public function kembalikan($id)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu.',
                ], 401);
            }

            if ($user->role !== 'anggota') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses hanya untuk anggota.',
                ], 403);
            }

            $anggota = $user->anggota;

            if (!$anggota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil anggota tidak ditemukan.',
                ], 404);
            }

            $pengaturan = PengaturanSistem::aktif();

            $peminjaman = Peminjaman::with('buku')
                ->where('id', $id)
                ->where('anggota_id', $anggota->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->firstOrFail();

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
                    ? 'Buku berhasil dikembalikan. Kamu terkena denda Rp ' . number_format($jumlahDenda, 0, ',', '.')
                    : 'Buku berhasil dikembalikan.',
                'reload' => true,
                'data' => [
                    'hari_terlambat' => $hariTerlambat,
                    'jumlah_denda' => $jumlahDenda,
                ]
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengembalikan buku.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // =========================
    // PRIVATE: PROSES ANTRIAN
    // =========================
    private function prosesAntrianBerikutnya($bukuId)
    {
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