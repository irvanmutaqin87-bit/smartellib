<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Denda;
use App\Models\PengaturanSistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function pinjam(Request $request, $id)
    {
        $user = Auth::user();
        $buku = Buku::findOrFail($id);

        // CEK DENDA BELUM LUNAS
        $dendaAktif = Denda::whereHas('peminjaman', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->whereIn('status_denda', ['belum_bayar', 'menunggu_verifikasi', 'ditolak'])
            ->exists();

        if ($dendaAktif) {
            return $this->responseHandler($request, false, 'Kamu masih memiliki denda yang belum diselesaikan.');
        }

        // CEK SEDANG PINJAM BUKU INI
        $sedangPinjamBukuIni = Peminjaman::where('user_id', $user->id)
            ->where('buku_id', $buku->id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($sedangPinjamBukuIni) {
            return $this->responseHandler($request, false, 'Kamu sedang meminjam buku ini.');
        }

        // BATAS PEMINJAMAN
        $pengaturan = PengaturanSistem::first();
        $batasPeminjaman = $pengaturan->batas_peminjaman ?? 3;
        $lamaPeminjaman = $pengaturan->lama_peminjaman ?? 7;

        $jumlahPinjamanAktif = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->count();

        if ($jumlahPinjamanAktif >= $batasPeminjaman) {
            return $this->responseHandler($request, false, 'Kamu sudah mencapai batas maksimal peminjaman.');
        }

        // CEK STOK TERSEDIA
        $sedangDipinjam = Peminjaman::where('buku_id', $buku->id)
            ->where('status', 'dipinjam')
            ->count();

        $stokTersedia = ($buku->stok ?? 0) - $sedangDipinjam;

        if ($stokTersedia <= 0) {
            return $this->responseHandler($request, false, 'Stok buku habis. Silakan masuk antrian.');
        }

        DB::beginTransaction();

        try {
            $peminjaman = Peminjaman::create([
                'user_id' => $user->id,
                'buku_id' => $buku->id,
                'tanggal_pinjam' => now(),
                'tanggal_jatuh_tempo' => now()->addDays($lamaPeminjaman),
                'status' => 'dipinjam',
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
            return $this->responseHandler($request, false, 'Terjadi kesalahan saat meminjam buku.');
        }
    }

        public function masukAntrian(Request $request, $id)
    {
        $user = Auth::user();
        $buku = Buku::findOrFail($id);

        $sudahPinjam = Peminjaman::where('user_id', $user->id)
            ->where('buku_id', $buku->id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($sudahPinjam) {
            return $this->responseHandler($request, false, 'Kamu sedang meminjam buku ini.');
        }

        $sudahAntri = \App\Models\AntrianPeminjaman::where('user_id', $user->id)
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['menunggu', 'diproses'])
            ->exists();

        if ($sudahAntri) {
            return $this->responseHandler($request, false, 'Kamu sudah ada di antrian buku ini.');
        }

        $sedangDipinjam = Peminjaman::where('buku_id', $buku->id)
            ->where('status', 'dipinjam')
            ->count();

        $stokTersedia = ($buku->stok ?? 0) - $sedangDipinjam;

        if ($stokTersedia > 0) {
            return $this->responseHandler($request, false, 'Stok masih tersedia, silakan pinjam langsung.');
        }

        \App\Models\AntrianPeminjaman::create([
            'user_id' => $user->id,
            'buku_id' => $buku->id,
            'status' => 'menunggu',
            'tanggal_antri' => now(),
        ]);

        return $this->responseHandler($request, true, 'Berhasil masuk antrian.', true);
    }

        public function kembalikan(Request $request, $id)
    {
        $user = Auth::user();

        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->firstOrFail();

        DB::beginTransaction();

        try {
            $peminjaman->tanggal_kembali = now();
            $peminjaman->status = 'dikembalikan';
            $peminjaman->save();

            // CEK TERLAMBAT
            if (now()->gt($peminjaman->tanggal_jatuh_tempo)) {
                $hariTerlambat = Carbon::parse($peminjaman->tanggal_jatuh_tempo)
                    ->diffInDays(now());

                $pengaturan = PengaturanSistem::first();
                $dendaPerHari = $pengaturan->denda_per_hari ?? 2000;

                Denda::updateOrCreate(
                    ['peminjaman_id' => $peminjaman->id],
                    [
                        'hari_terlambat' => $hariTerlambat,
                        'jumlah_denda' => $hariTerlambat * $dendaPerHari,
                        'status_denda' => 'belum_bayar',
                    ]
                );
            }

            // PROSES ANTRIAN OTOMATIS
            $antrianPertama = \App\Models\AntrianPeminjaman::where('buku_id', $peminjaman->buku_id)
                ->where('status', 'menunggu')
                ->orderBy('tanggal_antri', 'asc')
                ->first();

            if ($antrianPertama) {
                $antrianPertama->status = 'diproses';
                $antrianPertama->save();
            }

            DB::commit();

            return $this->responseHandler($request, true, 'Buku berhasil dikembalikan.', true);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseHandler($request, false, 'Terjadi kesalahan saat mengembalikan buku.');
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