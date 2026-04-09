<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Petugas\AnggotaController;
use App\Http\Controllers\Petugas\BukuController as PetugasBukuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BukuController as AdminBukuController;
use App\Http\Controllers\Admin\AnggotaController as AdminAnggotaController;
use App\Http\Controllers\Petugas\PeminjamanController;
use App\Http\Controllers\Petugas\DendaController;
use App\Http\Controllers\Admin\PengaturanSistemController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Anggota\DetailBukuController;
use App\Http\Controllers\Anggota\PeminjamanController as AnggotaPeminjamanController;
use App\Http\Controllers\Anggota\DendaAnggotaController;
use App\Http\Controllers\Petugas\AntrianPeminjamanController;
use App\Http\Controllers\Anggota\BukuController as AnggotaBukuController;
use App\Http\Controllers\Anggota\BookReviewController;
use App\Http\Controllers\Anggota\BerandaController;
use App\Http\Controllers\Anggota\UlasanController;

/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (Auth::check()) {

        $user = Auth::user();

        if ($user->role === 'anggota') {
            return redirect()->route('anggota.beranda');
        }

        if ($user->role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        }

        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('landing');
});

Route::get('/landing_pages', function () {

    if (Auth::check()) {
        return redirect()->route('anggota.beranda');
    }

    return view('landing_pages');
})->name('landing');


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

// LOGIN
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])
    ->name('google.login');

Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);


// REGISTER (HANYA UNTUK ANGGOTA)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');


// ======================
// LUPA PASSWORD
// ======================

// halaman form lupa password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])
    ->name('password.request');

// kirim link reset password ke email
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->middleware('throttle:3,1')
    ->name('password.email');

// halaman reset password dari email
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

// proses simpan password baru
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])
    ->name('password.update');


// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ROLE BASED ACCESS (DILINDUNGI AUTH + ROLE)
|--------------------------------------------------------------------------
*/


// ======================
// ADMIN
// ======================
Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // daftar anggota
    Route::get('/anggota', [AdminAnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/{id}', [AdminAnggotaController::class, 'show'])->name('anggota.show');

    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/list/ajax', [KategoriController::class, 'ajaxList'])->name('kategori.ajax');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}/update', [KategoriController::class, 'update'])->name('kategori.update');
    Route::post('/kategori/{id}/delete', [KategoriController::class, 'delete'])->name('kategori.delete');

    // route read only daftar buku
    Route::get('/buku', [AdminBukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{id}/show', [AdminBukuController::class, 'show'])->name('buku.show');

    // Pengaturan Sistem
    Route::get('/pengaturan', [PengaturanSistemController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan/update', [PengaturanSistemController::class, 'update'])->name('pengaturan.update');

    // ======================
    // PETUGAS
    // ======================
    Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas.index');
    Route::get('/petugas/create', [PetugasController::class, 'create'])->name('petugas.create');
    Route::post('/petugas/store', [PetugasController::class, 'store'])->name('petugas.store');
    Route::get('/petugas/{id}', [PetugasController::class, 'show'])->name('petugas.show');
    Route::get('/petugas/{id}/edit', [PetugasController::class, 'edit'])->name('petugas.edit');
    Route::put('/petugas/{id}/update', [PetugasController::class, 'update'])->name('petugas.update');
    Route::delete('/petugas/{id}/delete', [PetugasController::class, 'destroy'])->name('petugas.destroy');

    Route::patch('/petugas/{id}/toggle-status', [PetugasController::class, 'toggleStatus'])
        ->name('petugas.toggle-status');

    // ======================
    // LAPORAN
    // ======================
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/data', [LaporanController::class, 'getData'])->name('laporan.data');
    Route::get('/laporan/download-pdf', [LaporanController::class, 'downloadPdf'])->name('laporan.downloadPdf');

});


// ======================
// PETUGAS
// ======================
Route::middleware(['auth','role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

    Route::get('/dashboard', function () {
        return view('petugas.dashboard');
    })->name('dashboard');

    //route manajemen anggota
    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');

    Route::get('/anggota/{id}', [AnggotaController::class, 'show'])->name('anggota.show');

    Route::post('/anggota/{id}/verifikasi', [AnggotaController::class, 'verifikasi'])->name('anggota.verifikasi');

    Route::post('/anggota/{id}/nonaktifkan', [AnggotaController::class, 'nonaktifkan'])->name('anggota.nonaktifkan');

    Route::post('/anggota/{id}/aktifkan', [AnggotaController::class, 'aktifkan'])->name('anggota.aktifkan');

    //route manajemen Buku
    Route::get('/buku', [PetugasBukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [PetugasBukuController::class, 'create'])->name('buku.create');
    Route::post('/buku/store', [PetugasBukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{id}/edit', [PetugasBukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{id}/update', [PetugasBukuController::class, 'update'])->name('buku.update');
    Route::get('/buku/{id}/show', [PetugasBukuController::class, 'show'])->name('buku.show');
    Route::post('/buku/{id}/delete', [PetugasBukuController::class, 'delete'])->name('buku.delete');

    //kategori
    Route::get('/kategori/list/ajax', [KategoriController::class, 'ajaxList'])->name('kategori.ajax');

    // PEMINJAMAN
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::post('/peminjaman/update-terlambat', [PeminjamanController::class, 'updateTerlambatMassal'])->name('peminjaman.updateTerlambat');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

    // DENDA
    Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
    Route::get('/denda/{id}', [DendaController::class, 'show'])->name('denda.show');
    Route::post('/denda/{id}/verifikasi', [DendaController::class, 'verifikasi'])->name('denda.verifikasi');
    Route::post('/denda/{id}/tolak', [DendaController::class, 'tolak'])->name('denda.tolak');
    Route::delete('/denda/{id}', [DendaController::class, 'destroy'])->name('denda.destroy');

    // ANTRIAN
    Route::get('/antrian-peminjaman', [AntrianPeminjamanController::class, 'index'])->name('antrian.index');
    Route::get('/antrian-peminjaman/{id}', [AntrianPeminjamanController::class, 'show'])->name('antrian.show');
    Route::post('/antrian-peminjaman/{id}/proses', [AntrianPeminjamanController::class, 'proses'])->name('antrian.proses');
    Route::post('/antrian-peminjaman/{id}/selesai', [AntrianPeminjamanController::class, 'selesai'])->name('antrian.selesai');
    Route::delete('/antrian-peminjaman/{id}', [AntrianPeminjamanController::class, 'destroy'])->name('antrian.destroy');

});


// ======================
// ANGGOTA
// ======================
Route::middleware(['auth', 'role:anggota'])
    ->prefix('anggota')
    ->name('anggota.')
    ->group(function () {

        // =========================
        // BERANDA
        // =========================
        Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

        // =========================
        // KATALOG BUKU
        // =========================
        Route::get('/buku', [AnggotaBukuController::class, 'index'])->name('buku.index');

        // =========================
        // DETAIL BUKU
        // =========================
        Route::get('/buku/{id}', [DetailBukuController::class, 'show'])->name('buku.detail');

        // =========================
        // ULASAN BUKU
        // =========================
        Route::post('/buku/{id}/ulasan', [BookReviewController::class, 'store'])
            ->name('buku.ulasan.store');

        // =========================
        // PEMINJAMAN ANGGOTA
        // =========================
        Route::post('/buku/{id}/pinjam', [AnggotaPeminjamanController::class, 'pinjam'])->name('buku.pinjam');
        Route::post('/buku/{id}/antrian', [AnggotaPeminjamanController::class, 'masukAntrian'])->name('buku.antrian');
        Route::post('/peminjaman/{id}/kembalikan', [AnggotaPeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');

        // =========================
        // PROFILE
        // =========================
        Route::get('/data-profile', function () {
            return view('anggota.data_profile');
        })->name('data_profile');

        Route::get('/profile', function () {
            return view('anggota.profile');
        })->name('profile');

        Route::get('/rak', function () {
            return view('anggota.rak');
        })->name('rak');

        // =========================
        // SEARCH
        // =========================
        Route::get('/search', [SearchController::class, 'index'])->name('search');
        Route::get('/search/query', [SearchController::class, 'search'])->name('search.query');

        // =========================
        // DENDA ANGGOTA
        // =========================
        Route::get('/denda', [DendaAnggotaController::class, 'index'])->name('denda.index');
        Route::post('/denda/{id}/upload-pembayaran', [DendaAnggotaController::class, 'uploadPembayaran'])->name('denda.uploadPembayaran');

        // =========================
        // ULASAN
        // =========================
        Route::post('/buku/{id}/ulasan', [UlasanController::class, 'store'])->name('buku.ulasan.store');
    });