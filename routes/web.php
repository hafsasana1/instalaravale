<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::withoutMiddleware(['locale'])->group(function () {
    
    Route::get("download", \App\Http\Controllers\DownloadFileController::class)
        ->name("download");

    Route::redirect('/admin', '/admin/settings');

    Route::prefix('/admin')
        ->middleware('guest')
        ->group(function () {
            Route::get('/login', [\App\Http\Controllers\AuthenticatedSessionController::class, 'index'])
                ->name('login');
            Route::post('/login', [\App\Http\Controllers\AuthenticatedSessionController::class, 'store']);
        });

    Route::post('admin/logout', [\App\Http\Controllers\AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');

    Route::prefix("/admin")
        ->middleware('auth')
        ->as('admin.')
        ->group(function () {
            Route::get("/settings", [\App\Http\Controllers\Admin\SettingsController::class, 'index'])
                ->name('settings');
            Route::post('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])
                ->name('settings.update');

            Route::get("/proxies", [\App\Http\Controllers\Admin\ProxyController::class, 'index'])
                ->name('proxy');
            Route::get("/proxies/create", [\App\Http\Controllers\Admin\ProxyController::class, 'createForm'])
                ->name('proxy.create');
            Route::post("/proxies/create", [\App\Http\Controllers\Admin\ProxyController::class, 'create']);
            Route::get("/proxies/{proxy}/edit", [\App\Http\Controllers\Admin\ProxyController::class, 'editForm'])
                ->name('proxy.edit');
            Route::post("/proxies/{proxy}/edit", [\App\Http\Controllers\Admin\ProxyController::class, 'update']);
            Route::delete("/proxies/{proxy}/delete", [\App\Http\Controllers\Admin\ProxyController::class, 'destroy'])->name('proxy.delete');
            Route::post("/proxies/{proxy}/toggle", [\App\Http\Controllers\Admin\ProxyController::class, 'toggleProxyStatus'])
                ->name('proxy.toggle');

            Route::get('/appearance', [\App\Http\Controllers\Admin\AppearanceController::class, 'index'])
                ->name('appearance');

            Route::get('/appearance/{id}/screenshot', [\App\Http\Controllers\Admin\AppearanceController::class, 'screenshot'])
                ->name('appearance.theme.screenshot');
            Route::post('/appearance/{id}/activate', [\App\Http\Controllers\Admin\AppearanceController::class, 'activate'])
                ->name('appearance.theme.activate');
            Route::post('/appearance/{id}/clear-cache', [\App\Http\Controllers\Admin\AppearanceController::class, 'clearCache'])
                ->name('appearance.theme.clear-cache');

            Route::get('/me', [\App\Http\Controllers\Admin\MeController::class, 'index'])
                ->name('me');
            Route::post('/me', [\App\Http\Controllers\Admin\MeController::class, 'store']);
        });
});
