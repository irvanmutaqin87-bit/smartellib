<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{

    public function toMail($notifiable)
    {

        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Security Alert: Reset Password – SMARTELLIB')
            ->view('emails.reset_password', [
                'url' => $url,
                'user' => $notifiable
            ]);
    }
}