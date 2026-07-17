<?php

use Illuminate\Support\Facades\Route;
use Themes\Minimal\Controllers\FetchController;
use Themes\Minimal\Controllers\InstagramFetchController;
use Themes\Minimal\Controllers\InstagramPreviewController;
use Themes\Minimal\Controllers\PopularVideosController;
use Themes\Minimal\Controllers\SitemapController;

Route::post("fetch", FetchController::class)
    ->middleware(['web', 'auth.session'])
    ->name("fetch");

Route::post("insta-fetch", InstagramFetchController::class)
    ->middleware(['web', 'auth.session'])
    ->name("insta-fetch");

Route::get("insta-preview", InstagramPreviewController::class)
    ->middleware(['web'])
    ->name("insta-preview");

Route::get("/sitemap.xml", SitemapController::class)->name('sitemap');

Route::middleware(['web', 'theme'])->group(function () {
    Route::view('/tos', "theme::tos")->name('tos');
    Route::view('/privacy', "theme::privacy")->name('privacy');
    Route::view('/instagram-reels-audio-download', "theme::reels-audio")->name('reels-audio');
});

Route::localization()->middleware(['web', 'theme'])->group(function () {
    Route::match(
        ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
        '/',
        fn() => view("theme::home")
    )->name('home');
    Route::view('/faq', "theme::faq")->name('faq');
    Route::view('/how-to-save', "theme::how-to-save")->name('how-to-save');
    Route::get('/popular-videos', PopularVideosController::class)->name('popular-videos');
});
