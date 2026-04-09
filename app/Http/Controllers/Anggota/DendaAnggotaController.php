<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\PengaturanSistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DendaAnggotaController extends Controller
{
    // =========================
    // LIST DENDA ANGGOTA
    // =========================
    public function index()
    {
        $user = Auth::user();
        $anggota = $user?->anggota;

        $data = Denda::with(['peminjaman.buku'])
            ->whereHas('peminjaman', function ($q) use ($anggota) {
                $q->where('anggota_id', $anggota->id);
            })
            ->latest()
            ->get();

        $pengaturan = PengaturanSistem::aktif();

        return view('anggota.denda.index', compact('data', 'pengaturan'));
    }

    // =========================
    // UPLOAD BUKTI PEMBAYARAN
    // =========================
    public function uploadPembayaran(Request $request, $id)
    {
        // VALIDASI (otomatis redirect kalau gagal)
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diupload.',
            'bukti_pembayaran.image' => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format file harus JPG, JPEG, PNG, atau WEBP.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $user = Auth::user();
        $anggota = $user?->anggota;

        if (!$anggota) {
            return $this->responseHandler($request, false, 'Data anggota tidak ditemukan.');
        }

        $denda = Denda::with('peminjaman.anggota')->findOrFail($id);

        // CEK AKSES
        if (!$denda->peminjaman || $denda->peminjaman->anggota_id !== $anggota->id) {
            return $this->responseHandler($request, false, 'Kamu tidak punya akses ke denda ini.');
        }

        // CEK STATUS
        if (!in_array($denda->status_denda, ['belum_bayar', 'ditolak'])) {
            return $this->responseHandler($request, false, 'Denda ini tidak bisa diupload bukti lagi.');
        }

        try {
            // HAPUS FILE LAMA
            if ($denda->bukti_pembayaran && Storage::disk('public')->exists($denda->bukti_pembayaran)) {
                Storage::disk('public')->delete($denda->bukti_pembayaran);
            }

            // SIMPAN FILE BARU
            $path = $request->file('bukti_pembayaran')->store('bukti-denda', 'public');

            // UPDATE DATA
            $denda->update([
                'bukti_pembayaran' => $path,
                'status_denda' => 'menunggu_verifikasi',
                'catatan_verifikasi' => null,
                'tanggal_verifikasi' => null,
                'verifikator_id' => null,
            ]);

            return $this->responseHandler(
                $request,
                true,
                'Bukti pembayaran berhasil diupload dan sedang menunggu verifikasi.',
                true
            );

        } catch (\Throwable $e) {
            return $this->responseHandler(
                $request,
                false,
                'Gagal upload bukti pembayaran.'
            );
        }
    }

    // =========================
    // RESPONSE HANDLER (SAMA KAYAK PEMINJAMAN)
    // =========================
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