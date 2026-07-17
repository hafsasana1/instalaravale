<?php

namespace App\Providers;

use App\Service\Theme\Theme;
use App\Service\Theme\ThemeManager;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * @throws BindingResolutionException
     */
    public function register(): void
    {
        $this->app->singleton(ThemeManager::class, function ($app) {
            return new ThemeManager($app);
        });

        $this->app->bind(Theme::class, function () {
            return $this->app->make(ThemeManager::class)->currentTheme();
        });

        $this->app->alias(ThemeManager::class, 'theme.manager');
        $this->app->alias(Theme::class, 'theme');

        $this->app->bind('theme.locales', function () {
            /** @var Theme $theme */
            $theme = $this->app->make('theme');
            return [
                'enabled' => $theme->locales(),
                'rtl' => $theme->rtlLocales()
            ];
        });

        $this->app->bind('theme.provider', function () {
            return $this->app->make('theme')?->getProvider();
        });
    }

    /**
     * @throws BindingResolutionException
     */
    public function boot()
    {
        if ($provider = $this->app->make('theme.provider')) {
            $this->app->register($provider);
        }
    }
}
