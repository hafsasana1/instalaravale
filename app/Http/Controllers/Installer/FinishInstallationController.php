<?php

namespace App\Http\Controllers\Installer;

use App\Exceptions\ArtisanException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Throwable;

class FinishInstallationController extends Controller
{
    public function __invoke()
    {
        try {
            if(!function_exists('symlink')) {
                throw new ArtisanException("Unable to create symbolic links. Please check your server configuration and enable PHP function symlink()");
            }

            if (Artisan::call("storage:link", ['--force' => true, '--quiet' => true]) !== 0) {
                throw new ArtisanException("Unable to link storage directory.");
            }

            if (Artisan::call("theme:link", ['--quiet' => true]) !== 0) {
                throw new ArtisanException("Unable to link theme assets directory");
            }

            if (Artisan::call("theme:clear-cache", ['--quiet' => true]) !== 0) {
                throw new ArtisanException("Unable to clear cache.");
            }


            if (!touch(storage_path("/app/.activated"))) {
                throw new ArtisanException("Unable to write in /storage/app directory.");
            }

            if(file_exists(storage_path("/app/.wizard"))) {
                unlink(storage_path("/app/.wizard"));
            }

        } catch (Throwable $exception) {
            $message = $exception instanceof ArtisanException ?
                $exception->getMessage() :
                "Something went wrong. Please check the logs";
            logger()->error($exception);

            return back()->with(['message' => [
                'type' => 'error',
                'content' => $message
            ]]);
        }

        return redirect("/");
    }
}
