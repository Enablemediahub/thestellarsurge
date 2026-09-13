<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('local') && ! app()->runningInConsole()) {
            $forwardedHost = request()->header('x-forwarded-host');
            $forwardedProtocol = request()->header('x-forwarded-proto', request()->getScheme());

            if ($forwardedHost) {
                URL::forceRootUrl($forwardedProtocol . '://' . $forwardedHost);
                URL::forceScheme($forwardedProtocol);
            }
        }
    }
}
