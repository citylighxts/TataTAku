<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        if (config('app.url')) {
            $this->app['url']->forceRootUrl(config('app.url'));
        }

        $this->app['url']->forceScheme('https');
    }
}
