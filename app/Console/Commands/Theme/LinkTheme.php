<?php

namespace App\Console\Commands\Theme;

use App\Service\Theme\Theme;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Console\StorageLinkCommand;

class LinkTheme extends StorageLinkCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:link
                {--relative : Create the symbolic link using relative paths}
                {--force : Recreate existing symbolic links}';


    protected static $defaultName = 'theme:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the symbolic theme links configured for the application';

    /**
     * Get the symbolic links that are configured for the application.
     *
     * @return array
     * @throws BindingResolutionException
     */
    protected function links(): array
    {
        /** @var Theme $theme */
        $theme = $this->laravel->make('theme');

        return [
            public_path('theme-assets') => $theme->resourcesPath('assets')
        ];
    }
}
