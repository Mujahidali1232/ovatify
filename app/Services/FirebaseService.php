<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Exception;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        try {
            $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials_path'));
            $this->messaging = $factory->createMessaging();
        } catch (Exception $e) {
            // Log or handle error if credentials file is missing
        }
    }

    /**
     * Send push notification
     */
    public function sendNotification(string $token, string $title, string $body, array $data = [])
    {
        if (!$this->messaging) return;

        try {
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification([
                    'title' => $title,
                    'body' => $body,
                ])
                ->withData($data);

            $this->messaging->send($message);
            return true;
        } catch (Exception $e) {
            throw new Exception('Firebase Notification Error: ' . $e->getMessage());
        }
    }
}
