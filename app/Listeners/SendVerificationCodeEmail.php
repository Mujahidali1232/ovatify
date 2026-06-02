<?php

namespace App\Listeners;

use App\Events\VerificationCodeGenerated;
use Illuminate\Support\Facades\Mail;

class SendVerificationCodeEmail
{
    public function handle(VerificationCodeGenerated $event): void
    {
        Mail::send('emails.verification', [
            'user' => $event->user,
            'code' => $event->code,
        ], function ($message) use ($event) {
            $message->to($event->user->email)
                    ->subject('Verification Code');
        });
    }
}
