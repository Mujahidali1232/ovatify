<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class SmsNotification extends Notification
{
    use \Illuminate\Bus\Queueable;

    public function __construct(public string $message) {}

    public function via($notifiable)
    {
        return ['sms'];
    }

    public function toSms($notifiable)
    {
        return $this->message;
    }
}
