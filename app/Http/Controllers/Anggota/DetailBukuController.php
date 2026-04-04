<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\AntrianPeminjaman;
use App\Models\PengaturanSistem;
use Illuminate\Support\Facades\Auth;

class DetailBukuController extends Controller
{
    public function show($id)
    {
        $buku = Buku::with([
            'kategori',
            'ratings.user',
            'comments.user',
            'comments.replies.user'
        ])->findOrFail($id);

        $user = Auth::user();
        $anggota = $user?->anggota;

        $pengaturan = PengaturanSistem::aktif();

        $pinjamanAktif = null;
        $sedangDipinjam = false;
        $punyaDendaAktif = false;
        $stokHabis = $buku->stok <= 0;
        $bolehPinjam = false;
        $bolehAntri = false;
        $bolehKembalikan = false;
        $bolehUlasan = false;
        $isDigital = !empty($buku->file_buku);
        $dendaAktif = null;
        $sudahAntri = false;
        $sudahPernahPinjam = false;
        $sudahMelebihiBatas = false;
        $jumlahPinjamanAktif = 0;

        if ($anggota) {
            // =========================
            // CEK PINJAMAN AKTIF BUKU INI
            // =========================
            $pinjamanAktif = Peminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->latest()
                ->first();

            $sedangDipinjam = !is_null($pinjamanAktif);
            $bolehKembalikan = $sedangDipinjam;

            // =========================
            // CEK DENDA AKTIF USER
            // =========================
            $dendaAktif = Denda::with('peminjaman.buku')
                ->whereHas('peminjaman', function ($q) use ($anggota) {
                    $q->where('anggota_id', $anggota->id);
                })
                ->whereIn('status_denda', ['belum_bayar', 'menunggu_verifikasi', 'ditolak'])
                ->latest()
                ->first();

            $punyaDendaAktif = !is_null($dendaAktif);

            // =========================
            // CEK BATAS PINJAMAN
            // =========================
            $jumlahPinjamanAktif = Peminjaman::where('anggota_id', $anggota->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->count();

            $sudahMelebihiBatas = $jumlahPinjamanAktif >= $pengaturan->batas_peminjaman;

            // =========================
            // CEK ANTRIAN USER UNTUK BUKU INI
            // =========================
            $sudahAntri = AntrianPeminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->whereIn('status', ['menunggu', 'diproses'])
                ->exists();

            // =========================
            // CEK PERNAH PINJAM
            // =========================
            $sudahPernahPinjam = Peminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->where('status', 'dikembalikan')
                ->exists();

            $bolehUlasan = $sudahPernahPinjam;

            // =========================
            // LOGIKA BOLEH PINJAM
            // =========================
            $bolehPinjam =
                !$sedangDipinjam &&
                !$punyaDendaAktif &&
                !$stokHabis &&
                !$sudahMelebihiBatas &&
                !$isDigital &&
                $user->status === 'aktif';

            // =========================
            // LOGIKA BOLEH ANTRI
            // =========================
            $bolehAntri =
                !$sedangDipinjam &&
                !$punyaDendaAktif &&
                $stokHabis &&
                !$sudahAntri &&
                !$isDigital &&
                $user->status === 'aktif';
        }

        // =========================
        // BUKU SERUPA
        // =========================
        $bukuSerupa = Buku::with('kategori')
            ->where('id', '!=', $buku->id)
            ->where('kategori_id', $buku->kategori_id)
            ->latest()
            ->take(5)
            ->get();

        return view('anggota.detail_buku', compact(
            'buku',
            'pinjamanAktif',
            'sedangDipinjam',
            'punyaDendaAktif',
            'stokHabis',
            'bolehPinjam',
            'bolehAntri',
            'bolehKembalikan',
            'bolehUlasan',
            'isDigital',
            'dendaAktif',
            'sudahAntri',
            'sudahPernahPinjam',
            'sudahMelebihiBatas',
            'jumlahPinjamanAktif',
            'pengaturan',
            'bukuSerupa'
        ));
    }
}