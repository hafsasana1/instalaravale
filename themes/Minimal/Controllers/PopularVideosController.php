<?php

namespace Themes\Minimal\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PopularVideosController extends Controller
{
    public function __invoke(): Factory|View|Application
    {
        $videos = Video::popular()->limit(100)->get();

        return view('theme::popular-videos', compact('videos'));
    }
}
