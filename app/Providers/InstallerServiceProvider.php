<?php

namespace App\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

class InstallerServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind('app.installed', function () {
            return file_exists(storage_path('app/.activated'));
        });
    }

    /**
     * Bootstrap services.
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        if($this->app->make('app.installed'))
            return;

        $this->loadRoutesFrom(base_path('routes/installer.php'));
    }
}
