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

        // =========================
        // PENGATURAN SISTEM
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
        $sudahPernahPinjam = false;
        $punyaDendaAktif = false;
        $sudahMelebihiBatas = false;

        // =========================
        // 🔥 HITUNG STOK REAL (FIX UTAMA)
        // =========================
        $sedangDipinjam = Peminjaman::where('buku_id', $buku->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        $stokTersedia = max(0, ($buku->stok ?? 0) - $sedangDipinjam);
        $stokHabis = $stokTersedia <= 0;

        // =========================
        // ULASAN
        // =========================
        $ulasan = BookComment::with(['user', 'replies.user'])
            ->where('buku_id', $buku->id)
            ->whereNull('parent_id')
            ->latest()
            ->get();

        $ratingsByUser = Rating::where('buku_id', $buku->id)
            ->get()
            ->keyBy('user_id');

        $userRating = auth()->check()
            ? Rating::where('buku_id', $buku->id)->where('user_id', auth()->id())->first()
            : null;

        $userComment = auth()->check()
            ? BookComment::where('buku_id', $buku->id)
                ->where('user_id', auth()->id())
                ->whereNull('parent_id')
                ->first()
            : null;

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

            // =========================
            // DENDA
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
            // VALIDASI TAMBAHAN
            // =========================
            $sudahMelebihiBatas = $jumlahDipinjamUser >= $batasPeminjaman;

            $sudahAntri = AntrianPeminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->whereIn('status', ['menunggu', 'diproses'])
                ->exists();

            $sudahPernahPinjam = Peminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $buku->id)
                ->where('status', 'dikembalikan')
                ->exists();

            $bolehUlasan = $sudahPernahPinjam;
            $bolehKembalikan = !is_null($sedangDipinjamUser);

            // =========================
            // 🔥 LOGIKA PINJAM (FIX)
            // =========================
            $bolehPinjamDasar = $isDigital || (!$isDigital && $stokTersedia > 0);

            $bolehPinjam =
                !$sedangDipinjamUser &&
                !$dendaAktif &&
                !$sudahMelebihiBatas &&
                $user->status === 'aktif' &&
                $bolehPinjamDasar;

            // =========================
            // 🔥 LOGIKA ANTRIAN (FIX)
            // =========================
            $bolehAntri =
                !$sedangDipinjamUser &&
                !$sudahAntri &&
                !$isDigital &&
                $stokTersedia <= 0 &&
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
            'userRating',
            'userComment',
            'bukuSerupa',
            'totalDipinjam',
            'totalAntrian',
            'dendaPerHari',
            'stokHabis',
            'stokTersedia',
            'sudahAntri',
            'sudahPernahPinjam',
            'sudahMelebihiBatas',
            'jumlahDipinjamUser',
            'punyaDendaAktif'
        ));
    }
}