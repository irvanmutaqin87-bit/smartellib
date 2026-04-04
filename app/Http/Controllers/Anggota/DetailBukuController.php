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

        // =========================
        // DEFAULT VALUE
        // =========================
        $pinjamanAktif = null;
        $sedangDipinjamUser = null; // object peminjaman aktif user utk buku ini
        $jumlahPinjamanAktif = 0;
        $punyaDendaAktif = false;
        $stokHabis = false;
        $stokTersedia = 0;
        $bolehPinjam = false;
        $bolehAntri = false;
        $bolehKembalikan = false;
        $bolehUlasan = false;
        $isDigital = !empty($buku->file_buku);
        $dendaAktif = null;
        $sudahAntri = false;
        $sudahPernahPinjam = false;
        $sudahMelebihiBatas = false;

        // =========================
        // DATA ULASAN & RATING
        // =========================
        $ulasan = BookComment::with(['user', 'replies.user'])
            ->where('buku_id', $buku->id)
            ->whereNull('parent_id')
            ->latest()
            ->get();

        $ratingsByUser = Rating::where('buku_id', $buku->id)
            ->get()
            ->keyBy('user_id');

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
        // STATISTIK BUKU
        // =========================
        $totalDipinjam = Peminjaman::where('buku_id', $buku->id)->count();

        $sedangDipinjam = Peminjaman::where('buku_id', $buku->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        $totalAntrian = AntrianPeminjaman::where('buku_id', $buku->id)
            ->whereIn('status', ['menunggu', 'diproses'])
            ->count();

        // stok tersedia real
        $stokTersedia = max(($buku->stok ?? 0) - $sedangDipinjam, 0);
        $stokHabis = $stokTersedia <= 0;

        // =========================
        // CEK HAK AKSES USER
        // =========================
        if ($anggota && $user) {

            // USER SEDANG PINJAM BUKU INI?
            $pinjamanAktif = Peminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->latest()
                ->first();

            $sedangDipinjamUser = $pinjamanAktif;
            $bolehKembalikan = !is_null($sedangDipinjamUser);

            // JUMLAH BUKU YANG MASIH DIPINJAM USER
            $jumlahPinjamanAktif = Peminjaman::where('anggota_id', $anggota->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->count();

            $batasPeminjaman = $pengaturan->batas_peminjaman ?? 3;
            $sudahMelebihiBatas = $jumlahPinjamanAktif >= $batasPeminjaman;

            // DENDA AKTIF
            $dendaAktif = Denda::with('peminjaman.buku')
                ->whereHas('peminjaman', function ($q) use ($anggota) {
                    $q->where('anggota_id', $anggota->id);
                })
                ->whereIn('status_denda', ['belum_bayar', 'menunggu_verifikasi', 'ditolak'])
                ->latest()
                ->first();

            $punyaDendaAktif = !is_null($dendaAktif);

            // SUDAH MASUK ANTRIAN?
            $sudahAntri = AntrianPeminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->whereIn('status', ['menunggu', 'diproses'])
                ->exists();

            // BOLEH ULASAN?
            $sudahPernahPinjam = Peminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->where('status', 'dikembalikan')
                ->exists();

            $bolehUlasan = $sudahPernahPinjam;

            // =========================
            // LOGIKA TOMBOL
            // =========================

            // BOLEH PINJAM
            $bolehPinjam =
                !$sedangDipinjamUser &&
                !$punyaDendaAktif &&
                !$sudahMelebihiBatas &&
                $user->status === 'aktif' &&
                (
                    $isDigital || $stokTersedia > 0
                );

            // BOLEH ANTRI
            $bolehAntri =
                !$sedangDipinjamUser &&
                !$punyaDendaAktif &&
                !$sudahAntri &&
                !$isDigital &&
                $stokTersedia <= 0 &&
                $user->status === 'aktif';
        }

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
            'pengaturan',
            'pinjamanAktif',
            'sedangDipinjamUser',
            'sedangDipinjam',
            'jumlahPinjamanAktif',
            'punyaDendaAktif',
            'stokHabis',
            'stokTersedia',
            'bolehPinjam',
            'bolehAntri',
            'bolehKembalikan',
            'bolehUlasan',
            'isDigital',
            'dendaAktif',
            'sudahAntri',
            'sudahPernahPinjam',
            'sudahMelebihiBatas',
            'bukuSerupa',

            // ULASAN & RATING
            'ulasan',
            'ratingsByUser',
            'userRating',
            'userComment',

            // STATISTIK
            'totalDipinjam',
            'totalAntrian',
            'dendaPerHari'
        ));
    }
}