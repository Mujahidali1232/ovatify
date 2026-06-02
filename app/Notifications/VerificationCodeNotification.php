<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerificationCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $code;
    public string $type;

    public function __construct(string $code, string $type = 'email')
    {
        $this->code = $code;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        // If mail configured, use email
        if ($this->type === 'email') {
            return ['mail'];
        }

        // Otherwise return database only
        return ['database'];
    }

    public function toMail($notifiable): MailMessage
    {
        Log::info("Sending mail to {$notifiable->email} with code {$this->code}");

        return (new MailMessage)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Your Verification Code')
            ->line("Your verification code is: {$this->code}")
            ->line('This code will expire shortly.');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "Your verification code is: {$this->code}",
        ];
    }
}
