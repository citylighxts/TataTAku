<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        $appUrl = config('app.url');
        if ($appUrl) {
            URL::forceRootUrl($appUrl);
        }
    }
}