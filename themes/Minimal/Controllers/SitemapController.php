<?php

namespace Themes\Minimal\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $routes = [
            "home",
            "popular-videos",
            "how-to-save",
            "faq"
        ];

        $sitemap = Sitemap::create();

        $locale = 'en';
        $sitemap->add($this->createUrl(route("home")));

        $sitemap->add(
            $this->createUrl(route('tos'))
        );
        $sitemap->add(
            $this->createUrl(route('privacy'))
        );

        $locales = data_get(
            app('theme.locales'),
            'enabled',
            ['en' => 'English']
        );

        $locales = array_keys($locales);

        foreach ($locales as $locale) {
            foreach ($routes as $route) {
                $sitemap->add($this->createUrl(route($route, compact('locale'))));
            }
        }

        return $sitemap->toResponse($request);
    }

    protected function createUrl(string $url): Url
    {
        return Url::create($url)
            ->setLastModificationDate(now()->startOfWeek())
            ->setChangeFrequency('')
            ->setPriority(0);
    }
}
