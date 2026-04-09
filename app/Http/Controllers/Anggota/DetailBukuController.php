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
            'kategori'
        ])->findOrFail($id);

        $user = Auth::user();
        $anggota = $user?->anggota;

        // =========================
        // PENGATURAN
        // =========================
        $pengaturan = PengaturanSistem::aktif();

        $batasPeminjaman = $pengaturan->batas_peminjaman ?? 3;
        $dendaPerHari = $pengaturan->denda_per_hari ?? 0;

        // =========================
        // DEFAULT
        // =========================
        $sedangDipinjamUser = null;
        $jumlahDipinjamUser = 0;
        $dendaAktif = null;

        $bolehPinjam = false;
        $bolehAntri = false;
        $bolehUlasan = false;
        $bolehKembalikan = false;

        $isDigital = !empty($buku->file_buku);
        $sudahAntri = false;
        $sudahAntriUser = null;
        $sudahPernahPinjam = false;
        $punyaDendaAktif = false;
        $sudahMelebihiBatas = false;

        // =========================
        // STOK REAL
        // =========================
        $sedangDipinjam = Peminjaman::where('buku_id', $buku->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        $stokTersedia = max(0, ($buku->stok ?? 0) - $sedangDipinjam);
        $stokHabis = $stokTersedia <= 0;

        // =========================
        // 🔥 ULASAN & RATING (FIX UTAMA)
        // =========================
        $ulasan = BookComment::with(['user', 'replies.user'])
            ->where('buku_id', $buku->id)
            ->whereNull('parent_id')
            ->latest()
            ->get();

        $ratingsByUser = Rating::where('buku_id', $buku->id)
            ->get()
            ->keyBy('user_id');

        $userComment = null;
        $userRating = null;

        if (Auth::check()) {
            $userComment = BookComment::where('user_id', Auth::id())
                ->where('buku_id', $buku->id)
                ->whereNull('parent_id')
                ->first();

            $userRating = Rating::where('user_id', Auth::id())
                ->where('buku_id', $buku->id)
                ->first();
        }

        // =========================
        // LOGIKA USER
        // =========================
        if ($anggota) {

            $sedangDipinjamUser = Peminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->latest()
                ->first();

            $jumlahDipinjamUser = Peminjaman::where('anggota_id', $anggota->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->count();

            $dendaAktif = Denda::whereHas('peminjaman', function ($q) use ($anggota) {
                    $q->where('anggota_id', $anggota->id);
                })
                ->whereIn('status_denda', ['belum_bayar', 'menunggu_verifikasi', 'ditolak'])
                ->latest()
                ->first();

            $punyaDendaAktif = $dendaAktif !== null;
            $sudahMelebihiBatas = $jumlahDipinjamUser >= $batasPeminjaman;

            $sudahAntriUser = AntrianPeminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->whereIn('status', ['menunggu', 'diproses'])
                ->first();

            $sudahAntri = $sudahAntriUser !== null;

            $sudahPernahPinjam = Peminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->where('status', 'dikembalikan')
                ->exists();

            $bolehUlasan = $sudahPernahPinjam;
            $bolehKembalikan = !is_null($sedangDipinjamUser);

            $bolehPinjam =
                !$sedangDipinjamUser &&
                !$punyaDendaAktif &&
                !$sudahMelebihiBatas &&
                $user->status === 'aktif';
        }

        // =========================
        // STATISTIK
        // =========================
        $totalDipinjam = Peminjaman::where('buku_id', $buku->id)->count();

        $totalAntrian = AntrianPeminjaman::where('buku_id', $buku->id)
            ->whereIn('status', ['menunggu', 'diproses'])
            ->count();

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
            'sedangDipinjamUser',
            'sedangDipinjam',
            'bolehPinjam',
            'bolehAntri',
            'bolehUlasan',
            'bolehKembalikan',
            'isDigital',
            'dendaAktif',

            'ulasan',
            'ratingsByUser',
            'userComment',
            'userRating',

            'bukuSerupa',
            'totalDipinjam',
            'totalAntrian',
            'dendaPerHari',
            'stokHabis',
            'stokTersedia',
            'sudahAntri',
            'sudahAntriUser',
            'sudahPernahPinjam',
            'sudahMelebihiBatas',
            'jumlahDipinjamUser',
            'punyaDendaAktif'
        ));
    }
}