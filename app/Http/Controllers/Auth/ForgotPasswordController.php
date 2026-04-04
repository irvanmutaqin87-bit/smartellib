<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ForgotPasswordController extends Controller
{

    /**
     * Menampilkan halaman forgot password
     */
    public function showForm()
    {
        return view('auth.forgot_password');
    }


    /**
     * Mengirim email reset password
     */
    public function sendResetLink(Request $request)
    {

        // VALIDASI EMAIL
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        // AMBIL USER
        $user = User::firstWhere('email', $request->email);

        // CEK STATUS USER
        if ($user->status !== 'aktif') {
            return back()->with(
                'error',
                'Akun Anda tidak aktif. Silakan hubungi administrator.'
            );
        }

        // KIRIM EMAIL RESET PASSWORD
        $status = Password::sendResetLink(
            $request->only('email')
        );


        // JIKA EMAIL BERHASIL DIKIRIM
        if ($status === Password::RESET_LINK_SENT) {

            // SIMPAN SECURITY LOG
            DB::table('security_logs')->insert([
                'user_id' => $user->id,
                'action' => 'request_reset_password',
                'ip_address' => $request->ip(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return back()->with(
                'status',
                'Link reset password telah dikirim ke email Anda. Silakan periksa kotak masuk atau folder spam.'
            );
        }

        // JIKA GAGAL
        return back()->with(
            'error',
            'Terjadi kesalahan saat mengirim email reset password. Silakan coba beberapa saat lagi.'
        );

    }

}