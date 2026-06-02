<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\VerificationCodeGenerated;
use App\Listeners\SendVerificationCodeEmail;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        VerificationCodeGenerated::class => [
            SendVerificationCodeEmail::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
