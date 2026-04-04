<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use App\Notifications\PasswordChangedNotification;

class ResetPasswordController extends Controller
{

    public function showResetForm($token, Request $request)
    {
        return view('auth.reset_password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }


    public function resetPassword(Request $request)
    {

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8)->mixedCase()->numbers(),
            ],
        ]);


        $status = Password::reset(

            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),

            function ($user, $password) use ($request) {

                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->notify(new PasswordChangedNotification());


                DB::table('security_logs')->insert([
                    'user_id' => $user->id,
                    'action' => 'reset_password_success',
                    'ip_address' => $request->ip(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

        );


        if ($status === Password::PASSWORD_RESET) {

            return redirect()->route('login')->with(
                'success',
                'Password berhasil diubah! Silakan login dengan password baru.'
            );
        }


        return back()->withErrors([
            'email' => 'Link reset password tidak valid atau sudah kedaluwarsa.'
        ]);
    }

}