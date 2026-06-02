<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeGenerated
{
    use Dispatchable, SerializesModels;

    public User $user;
    public string $code;

    public function __construct(User $user, string $code)
    {
        $this->user = $user;
        $this->code = $code;
    }
}
