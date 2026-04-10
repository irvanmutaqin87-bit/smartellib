<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\BookComment;
use App\Models\RiwayatBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * =====================
     * HALAMAN PROFILE UTAMA
     * =====================
     */
    public function profile()
    {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->load('anggota');

        $ulasan = BookComment::with(['buku','rating'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $riwayat = $this->getRiwayat($user);

        return view('anggota.profile', compact(
            'user',
            'ulasan',
            'riwayat'
        ));
    }

    /**
     * =====================
     * HALAMAN DATA PROFILE
     * =====================
     */
    public function dataProfile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('anggota');

        return view('anggota.data_profile', compact('user'));
    }

    /**
     * =====================
     * AMBIL RIWAYAT (REUSABLE)
     * =====================
     */

      private function getRiwayat($user)
      {
          if (!$user->anggota) {
              return collect();
          }

          return RiwayatBuku::with('buku')
              ->where('anggota_id', $user->anggota->id)
              ->latest()
              ->get()
              ->unique('buku_id'); // biar ga double
      }

    /**
     * =====================
     * UPDATE PROFILE
     * =====================
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        // update user
        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        // update anggota
        if ($user->anggota) {
            $user->anggota->update([
                'no_hp' => $request->phone,
                'alamat' => $request->alamat,
            ]);
        }

        return back()->with('success', 'Profile berhasil diupdate');
    }

    /**
     * =====================
     * UPDATE PASSWORD
     * =====================
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors([
                'old_password' => 'Password lama salah'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }

    /**
     * =====================
     * UPLOAD FOTO
     * =====================
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($request->hasFile('photo')) {

            // hapus foto lama
            if ($user->photo && Storage::exists('public/'.$user->photo)) {
                Storage::delete('public/'.$user->photo);
            }

            // simpan baru
            $path = $request->file('photo')->store('profile', 'public');

            $user->update([
                'photo' => $path
            ]);
        }

        return back()->with('success', 'Foto berhasil diupload');
    }
}