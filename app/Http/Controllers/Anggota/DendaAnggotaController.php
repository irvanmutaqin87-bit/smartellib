<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\PengaturanSistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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
    public function uploadBukti(Request $request, $id)
    {
        try {
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

            $denda = Denda::with('peminjaman.anggota')->findOrFail($id);

            if (!$denda->peminjaman || $denda->peminjaman->anggota_id !== $anggota->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kamu tidak punya akses ke denda ini.',
                ], 403);
            }

            if (!in_array($denda->status_denda, ['belum_bayar', 'ditolak'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Denda ini tidak bisa diupload bukti lagi.',
                ], 422);
            }

            if ($request->hasFile('bukti_pembayaran')) {
                if ($denda->bukti_pembayaran && Storage::disk('public')->exists($denda->bukti_pembayaran)) {
                    Storage::disk('public')->delete($denda->bukti_pembayaran);
                }

                $path = $request->file('bukti_pembayaran')->store('bukti-denda', 'public');

                $denda->update([
                    'bukti_pembayaran' => $path,
                    'status_denda' => 'menunggu_verifikasi',
                    'catatan_verifikasi' => null,
                    'tanggal_verifikasi' => null,
                    'verifikator_id' => null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diupload dan sedang menunggu verifikasi.',
                'reload' => true,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload bukti pembayaran.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}