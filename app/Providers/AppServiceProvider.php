<?php
namespace App\Providers;

use App\Models\ShipmentRequest;
use App\Models\SiteSetting;
use App\Policies\ShipmentRequestPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        RateLimiter::for('tracking', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        Gate::policy(ShipmentRequest::class, ShipmentRequestPolicy::class);

        View::composer('*', function ($view) {
            $view->with('whatsappNumber', SiteSetting::get('whatsapp_number'));
        });
    }
}
