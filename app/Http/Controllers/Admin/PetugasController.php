<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PetugasController extends Controller
{
    /**
     * LIST PETUGAS
     */
    public function index(Request $request)
    {
        $query = Petugas::with('user');

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', function ($userQuery) use ($request) {
                    $userQuery->where('nama', 'like', '%' . $request->search . '%')
                              ->orWhere('email', 'like', '%' . $request->search . '%');
                })->orWhere('no_hp', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER STATUS
        if ($request->filter && $request->filter != 'semua status') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('status', $request->filter);
            });
        }

        $petugas = $query->latest()->paginate(10);

        // AJAX RESPONSE
        if ($request->ajax()) {
            return response()->json([
                "table" => view('admin.petugas.partials.table', compact('petugas'))->render(),
                "pagination" => view('components.pagination', [
                    "paginator" => $petugas
                ])->render()
            ]);
        }

        return view('admin.petugas.index', compact('petugas'));
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        return view('admin.petugas.create');
    }

    /**
     * SIMPAN PETUGAS
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'email'     => 'required|email|max:100|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
            'no_hp'     => 'required|string|max:20',
            'status'    => ['required', Rule::in(['aktif', 'nonaktif'])],
        ], [
            'nama.required' => 'Nama petugas wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'status.required' => 'Status akun wajib dipilih.',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'nama'      => $validated['nama'],
                'email'     => $validated['email'],
                'password'  => Hash::make($validated['password']),
                'role'      => 'petugas',
                'status'    => $validated['status'],
                'photo'     => null,
            ]);

            Petugas::create([
                'user_id'   => $user->id,
                'no_hp'     => $validated['no_hp'],
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Data petugas berhasil ditambahkan.',
                'redirect' => route('admin.petugas.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan petugas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * DETAIL PETUGAS
     */
    public function show($id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);

        return view('admin.petugas.show', compact('petugas'));
    }

    /**
     * FORM EDIT
     */
    public function edit($id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);

        return view('admin.petugas.edit', compact('petugas'));
    }

    /**
     * UPDATE PETUGAS
     */
    public function update(Request $request, $id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);
        $user = $petugas->user;

        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'email'     => [
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
            'password'  => 'nullable|string|min:6|confirmed',
            'no_hp'     => 'required|string|max:20',
            'status'    => ['required', Rule::in(['aktif', 'nonaktif'])],
        ], [
            'nama.required' => 'Nama petugas wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'status.required' => 'Status akun wajib dipilih.',
        ]);

        DB::beginTransaction();

        try {
            $user->update([
                'nama'   => $validated['nama'],
                'email'  => $validated['email'],
                'status' => $validated['status'],
            ]);

            if (!empty($validated['password'])) {
                $user->update([
                    'password' => Hash::make($validated['password']),
                ]);
            }

            $petugas->update([
                'no_hp' => $validated['no_hp'],
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Data petugas berhasil diperbarui.',
                'redirect' => route('admin.petugas.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui petugas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * HAPUS PETUGAS
     */
    public function destroy($id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);

        $petugas->user->delete();

        return response()->json([
            'message' => 'Data petugas berhasil dihapus.'
        ]);
    }

    /**
     * TOGGLE STATUS AKTIF / NONAKTIF
     */
    public function toggleStatus($id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);
        $user = $petugas->user;

        $newStatus = $user->status === 'aktif' ? 'nonaktif' : 'aktif';

        $user->update([
            'status' => $newStatus
        ]);

        return response()->json([
            'message' => 'Status petugas berhasil diperbarui.'
        ]);
    }
}