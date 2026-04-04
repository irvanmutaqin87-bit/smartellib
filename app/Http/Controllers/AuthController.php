<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW REGISTER
    |--------------------------------------------------------------------------
    */
    public function showRegister()
    {
        return view('auth.register');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER PROCESS
    |--------------------------------------------------------------------------
    */
    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers(),
            ],
            'no_hp' => 'required|numeric|digits_between:10,15',
            'alamat' => 'required|string'
        ]);

        $user = User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'anggota',
            'status'   => 'pending'
        ]);

        Anggota::create([
            'user_id' => $user->id,
            'no_hp'   => $request->no_hp,
            'alamat'  => $request->alamat
        ]);

        return redirect('/login')
            ->with('success', 'Registrasi berhasil! Silahkan menunggu verifikasi.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW LOGIN
    |--------------------------------------------------------------------------
    */
    public function showLogin()
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN PROCESS
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

    $credentials = $request->only('email', 'password');

    // default false
    $remember = false;

    // cek user dulu dari email
    $userCheck = User::where('email', $request->email)->first();

    if ($request->has('remember')) {

        if ($userCheck && $userCheck->role === 'anggota') {
            $remember = true;
        } else {
            return back()->with('error', 'Fitur ingat saya hanya untuk anggota.');
        }
    }

    if (Auth::attempt($credentials, $remember)) {
    
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || !$user->isActive()) {
            Auth::logout();
            return back()->with('error', 'Akun belum aktif atau tidak ditemukan.');
        }

        $request->session()->regenerate();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'petugas':
                return redirect()->route('petugas.dashboard');
            default:
                return redirect()->route('anggota.beranda');
        }
    }

        return back()->with('error', 'Email atau password salah.');
    }

    /*
    |--------------------------------------------------------------------------
    | GOOGLE REDIRECT
    |--------------------------------------------------------------------------
    */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /*
    |--------------------------------------------------------------------------
    | GOOGLE CALLBACK
    |--------------------------------------------------------------------------
    */
    public function handleGoogleCallback()
    {
        try {

           /** @var AbstractProvider $provider */
            $provider = Socialite::driver('google');

            $googleUser = $provider->stateless()->user();

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {

                if ($user->role !== 'anggota') {
                    return redirect()->route('login')
                        ->with('error', 'Akun ini tidak diizinkan login dengan Google.');
                }

                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'photo' => $googleUser->avatar
                    ]);
                }

            } else {

                $user = User::create([
                    'nama' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'photo' => $googleUser->avatar,
                    'password' => null,
                    'role' => 'anggota',
                    'status' => 'aktif'
                ]);

                Anggota::create([
                    'user_id' => $user->id,
                    'no_hp' => null,
                    'alamat' => null
                ]);
            }

            if ($user->status !== 'aktif') {
                return redirect()->route('login')
                    ->with('error', 'Akun tidak aktif.');
            }

            Auth::login($user);

            return redirect()->route('anggota.beranda');

        } catch (\Exception $e) {

            return redirect()->route('login')
                ->with('error', 'Login Google gagal.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // hapus session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->withCookie(cookie()->forget(Auth::getRecallerName()));
    }
}