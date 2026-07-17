<?php

namespace App\Service\Theme;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    public Theme|null $theme = null;
    public ThemeManager|null $themeManager = null;

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        /** @var Theme $theme */
        $theme = $this->app->make('theme');
        $this->theme = $theme;
        $this->themeManager = $theme->manager;

        // Load theme views
        $this->loadViewsFrom(
            $theme->resourcesPath('views'),
            'theme'
        );

        // Load theme locales
        $this->loadJsonTranslationsFrom($theme->path('lang'));

        // Provide theme config to views
        View::composer(['theme::*'], function ($view) {
            $view->with('theme', $this->theme);
        });

        Route::macro('localization', function () {
            return Route::prefix('{locale?}')->where(['locale', '[a-z]{2}']);
        });
    }
}
