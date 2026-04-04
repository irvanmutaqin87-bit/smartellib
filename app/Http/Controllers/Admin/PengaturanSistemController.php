<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PengaturanSistemController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanSistem::aktif();
        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'lama_peminjaman' => 'required|integer|min:1|max:60',
                'batas_peminjaman' => 'required|integer|min:1|max:20',
                'denda_per_hari' => 'required|numeric|min:0|max:1000000',

                'metode_pembayaran_denda' => 'nullable|string|max:50',
                'nama_ewallet' => 'nullable|string|max:100',
                'nomor_pembayaran' => 'nullable|string|max:50',
                'catatan_pembayaran' => 'nullable|string|max:1000',
                'qr_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ], [
                'lama_peminjaman.required' => 'Lama peminjaman wajib diisi.',
                'lama_peminjaman.integer' => 'Lama peminjaman harus berupa angka.',
                'lama_peminjaman.min' => 'Lama peminjaman minimal 1 hari.',
                'lama_peminjaman.max' => 'Lama peminjaman maksimal 60 hari.',

                'batas_peminjaman.required' => 'Batas peminjaman wajib diisi.',
                'batas_peminjaman.integer' => 'Batas peminjaman harus berupa angka.',
                'batas_peminjaman.min' => 'Batas peminjaman minimal 1 buku.',
                'batas_peminjaman.max' => 'Batas peminjaman maksimal 20 buku.',

                'denda_per_hari.required' => 'Denda per hari wajib diisi.',
                'denda_per_hari.numeric' => 'Denda per hari harus berupa angka.',
                'denda_per_hari.min' => 'Denda tidak boleh kurang dari 0.',
                'denda_per_hari.max' => 'Denda terlalu besar.',

                'metode_pembayaran_denda.max' => 'Metode pembayaran maksimal 50 karakter.',
                'nama_ewallet.max' => 'Nama e-wallet maksimal 100 karakter.',
                'nomor_pembayaran.max' => 'Nomor pembayaran maksimal 50 karakter.',
                'catatan_pembayaran.max' => 'Catatan pembayaran maksimal 1000 karakter.',

                'qr_pembayaran.image' => 'QR pembayaran harus berupa gambar.',
                'qr_pembayaran.mimes' => 'Format QR pembayaran harus JPG, JPEG, PNG, atau WEBP.',
                'qr_pembayaran.max' => 'Ukuran QR pembayaran maksimal 2MB.',
            ]);

            $pengaturan = PengaturanSistem::aktif();

            // Upload QR baru
            if ($request->hasFile('qr_pembayaran')) {
                if ($pengaturan->qr_pembayaran && Storage::disk('public')->exists($pengaturan->qr_pembayaran)) {
                    Storage::disk('public')->delete($pengaturan->qr_pembayaran);
                }

                $validated['qr_pembayaran'] = $request->file('qr_pembayaran')
                    ->store('pengaturan/qr-pembayaran', 'public');
            }

            $pengaturan->update($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengaturan sistem berhasil diperbarui.',
                ]);
            }

            return back()->with('success', 'Pengaturan sistem berhasil diperbarui.');
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $e->errors(),
                ], 422);
            }

            throw $e;
        } catch (\Throwable $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan pengaturan: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Gagal menyimpan pengaturan.');
        }
    }
}