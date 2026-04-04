<?php

namespace App\Http\Controllers\Petugas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

use App\Notifications\AnggotaDiverifikasi;
use App\Notifications\AnggotaDinonaktifkan;
use App\Notifications\AnggotaDiaktifkan;

class AnggotaController extends Controller
{

    /**
     * Tampilkan daftar anggota
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'anggota')->with('anggota');

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER STATUS
        if ($request->filter && $request->filter != 'semua status') {
            $query->where('status', $request->filter);
        }

        $anggota = $query->latest()->paginate(10);

        // AJAX RESPONSE
        if ($request->ajax()) {
            return response()->json([
                "table" => view('petugas.anggota.partials.table', compact('anggota'))->render(),
                "pagination" => view('components.pagination', [
                    "paginator" => $anggota
                ])->render()
            ]);
        }

        return view('petugas.anggota.index', compact('anggota'));
    }


    /**
     * Detail anggota
     */
    public function show($id)
    {
        $user = User::with('anggota')->findOrFail($id);

        return view('petugas.anggota.show', compact('user'));
    }


    /**
     * Verifikasi anggota
     * pending → aktif
     */
    public function verifikasi($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => 'aktif'
        ]);

        $user->notify(new AnggotaDiverifikasi());

        return response()->json([
            'message' => 'Anggota berhasil diverifikasi'
        ]);
    }


    /**
     * Nonaktifkan anggota
     */
    public function nonaktifkan($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => 'nonaktif'
        ]);

        $user->notify(new AnggotaDinonaktifkan());

        return response()->json([
            'message' => 'Anggota berhasil dinonaktifkan'
        ]);
    }

    /**
     * Aktifkan kembali anggota
     */
    public function aktifkan($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => 'aktif'
        ]);

        $user->notify(new AnggotaDiaktifkan());

        return response()->json([
            'message' => 'Anggota berhasil diaktifkan kembali'
        ]);
    }

}