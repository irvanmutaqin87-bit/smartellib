<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\AntrianPeminjaman;
use App\Models\PengaturanSistem;
use App\Models\BookComment;
use App\Models\Rating;
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
        $sedangDipinjamUser = false; // <- status user ini sedang pinjam buku ini atau tidak
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

        // =========================
        // DATA ULASAN & RATING
        // =========================

        // Ambil komentar utama
        $ulasan = BookComment::with(['user', 'replies.user'])
            ->where('buku_id', $buku->id)
            ->whereNull('parent_id')
            ->latest()
            ->get();

        // Semua rating buku, keyBy user_id
        $ratingsByUser = Rating::where('buku_id', $buku->id)
            ->get()
            ->keyBy('user_id');

        // Rating user login
        $userRating = null;
        $userComment = null;

        if (auth()->check()) {
            $userRating = Rating::where('buku_id', $buku->id)
                ->where('user_id', auth()->id())
                ->first();

            $userComment = BookComment::where('buku_id', $buku->id)
                ->where('user_id', auth()->id())
                ->whereNull('parent_id')
                ->first();
        }

        // =========================
        // CEK HAK AKSES USER
        // =========================
        if ($anggota) {
            // CEK PINJAMAN AKTIF BUKU INI
            $pinjamanAktif = Peminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->latest()
                ->first();

            $sedangDipinjamUser = !is_null($pinjamanAktif);
            $bolehKembalikan = $sedangDipinjamUser;

            // CEK DENDA AKTIF USER
            $dendaAktif = Denda::with('peminjaman.buku')
                ->whereHas('peminjaman', function ($q) use ($anggota) {
                    $q->where('anggota_id', $anggota->id);
                })
                ->whereIn('status_denda', ['belum_bayar', 'menunggu_verifikasi', 'ditolak'])
                ->latest()
                ->first();

            $punyaDendaAktif = !is_null($dendaAktif);

            // CEK BATAS PINJAMAN
            $jumlahPinjamanAktif = Peminjaman::where('anggota_id', $anggota->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->count();

            $sudahMelebihiBatas = $jumlahPinjamanAktif >= ($pengaturan->batas_peminjaman ?? 3);

            // CEK ANTRIAN USER
            $sudahAntri = AntrianPeminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->whereIn('status', ['menunggu', 'diproses'])
                ->exists();

            // CEK PERNAH PINJAM
            $sudahPernahPinjam = Peminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->where('status', 'dikembalikan')
                ->exists();

            $bolehUlasan = $sudahPernahPinjam;

            // LOGIKA BOLEH PINJAM
            $bolehPinjam =
                !$sedangDipinjamUser &&
                !$punyaDendaAktif &&
                !$sudahMelebihiBatas &&
                $user->status === 'aktif' &&
                (
                    ($isDigital) || (!$isDigital && !$stokHabis)
                );

            $bolehAntri =
                !$sedangDipinjamUser &&
                !$punyaDendaAktif &&
                !$sudahAntri &&
                !$isDigital &&
                $stokHabis &&
                $user->status === 'aktif';
        }

        // =========================
        // STATISTIK BUKU
        // =========================
        $totalDipinjam = Peminjaman::where('buku_id', $buku->id)->count();

        $sedangDipinjam = Peminjaman::where('buku_id', $buku->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        $totalAntrian = AntrianPeminjaman::where('buku_id', $buku->id)
            ->whereIn('status', ['menunggu', 'diproses'])
            ->count();

        // =========================
        // DENDA PER HARI
        // =========================
        $dendaPerHari = $pengaturan->denda_per_hari ?? 2000;

        // =========================
        // BUKU SERUPA
        // =========================
        $bukuSerupa = Buku::with('kategori')
            ->where('id', '!=', $buku->id)
            ->where('kategori_id', $buku->kategori_id)
            ->latest()
            ->take(10)
            ->get();

        return view('anggota.detail_buku', compact(
            'buku',
            'pinjamanAktif',
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
            'bukuSerupa',

            // ULASAN & RATING
            'ulasan',
            'ratingsByUser',
            'userRating',
            'userComment',

            // STATISTIK
            'totalDipinjam',
            'sedangDipinjam',
            'totalAntrian',
            'dendaPerHari'
        ));
    }
}