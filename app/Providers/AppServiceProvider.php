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
                $isLaravelDevServer = (string) request()->server('SERVER_PORT') === '8000';
                $pathPrefix = ! $isLaravelDevServer && str_starts_with(request()->getRequestUri(), '/thestellarsurge/public')
                    ? '/thestellarsurge/public'
                    : '';

                URL::forceRootUrl($forwardedProtocol . '://' . $forwardedHost . $pathPrefix);
                URL::forceScheme($forwardedProtocol);
            }
        }
    }
}
