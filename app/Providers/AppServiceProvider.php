<?php

namespace App\Providers;

use App\Service\StorableConfig;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton("config.storable", function($app) {
            return new StorableConfig($app);
        });

        $this->callAfterResolving('config', function($config, $app) {
            $app->make("config.storable")->merge($config);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Schema::defaultStringLength(191);
    }
}
