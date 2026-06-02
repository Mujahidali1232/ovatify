<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Payment\StripePaymentGateway;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register payment gateway singleton
        $this->app->singleton('payment.service', function ($app) {
            return new StripePaymentGateway();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
