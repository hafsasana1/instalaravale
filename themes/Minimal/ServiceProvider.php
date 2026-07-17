<?php

namespace Themes\Minimal;

use App\Service\Theme\ThemeServiceProvider;
use Illuminate\Support\Facades\Blade;

class ServiceProvider extends ThemeServiceProvider
{
    public function boot(): void
    {
        parent::boot();
        /**
         * It does not work with theme as a prefix because
         * theme prefix is already being used
         */
        Blade::componentNamespace("Themes\\Minimal\\Views", 'minimal');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
    }
}
