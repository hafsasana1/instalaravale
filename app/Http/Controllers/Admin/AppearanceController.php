<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Theme\ThemeManager;
use Illuminate\Support\Facades\Artisan;

class AppearanceController extends Controller
{
    use AdminAccessMiddleware;

    protected ThemeManager $manager;

    public function __construct(ThemeManager $manager)
    {
        $this->manager = $manager;
        $this->middleware($this->makeIsAdminMiddleware())->except('index');
    }

    public function index()
    {
        $themes = $this->manager->getThemes();
        return view('admin.appearance', compact('themes'));
    }

    public function screenshot(string $id)
    {
        $theme = $this->manager->getTheme($id);
        if (!$theme) {
            abort(404);
        }

        return response()->stream(function () use ($theme) {
            echo file_get_contents($theme->getScreenshot());
        }, 200, [
            'Content-Type' => 'image/png',
        ]);
    }

    public function activate(string $id)
    {
        $theme = $this->manager->getTheme($id);
        if (!$theme) {
            abort(404);
        }

        Artisan::call('theme:activate', [
            '--theme' => $id
        ]);

        return redirect()->back()->with('message', [
            'type' => 'success',
            'content' => 'Theme activated successfully'
        ]);
    }

    public function clearCache(string $id)
    {
        $theme = $this->manager->getTheme($id);
        if (!$theme) {
            abort(404);
        }

        Artisan::call('theme:clear-cache');

        return redirect()->back()->with('message', [
            'type' => 'success',
            'content' => 'Theme cache cleared successfully'
        ]);
    }
}
