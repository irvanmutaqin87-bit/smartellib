<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AnggotaController extends Controller
{
    /**
     * LIST ANGGOTA (READ ONLY)
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
                "table" => view('admin.anggota.partials.table', compact('anggota'))->render(),
                "pagination" => view('components.pagination', [
                    "paginator" => $anggota
                ])->render()
            ]);
        }

        return view('admin.anggota.index', compact('anggota'));
    }

    /**
     * DETAIL ANGGOTA (READ ONLY)
     */
    public function show($id)
    {
        $user = User::with('anggota')->findOrFail($id);

        return view('admin.anggota.show', compact('user'));
    }
}