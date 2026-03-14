<?php

namespace App\Providers;

use App\Services\Sms\SmsManager;
use App\Services\Sms\TermiiSmsClient;
use App\Services\Sms\TwilioSmsClient;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TermiiSmsClient::class);
        $this->app->singleton(TwilioSmsClient::class);

        $this->app->singleton(SmsManager::class, function ($app) {
            return new SmsManager([
                'termii' => $app->make(TermiiSmsClient::class),
                'twilio' => $app->make(TwilioSmsClient::class),
            ]);
        });
    }
}
