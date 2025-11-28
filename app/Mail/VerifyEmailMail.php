<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $verifyUrl = url('/verify-email/' . $this->user->verification_token);

        return $this->subject('ยืนยันอีเมลของคุณ')
            ->view('emails.verify-email')
            ->with([
                'name' => $this->user->name,
                'verifyUrl' => $verifyUrl,
            ]);
    }


}
