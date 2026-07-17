<?php

namespace App\Console\Commands\Theme;

use App\Service\Theme\ThemeManager;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\Console\Input\InputOption;

class ActivateTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'theme:activate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate a theme';

    /**
     * Execute the console command.
     * @throws BindingResolutionException
     */
    public function handle(): int
    {
        /** @var ThemeManager $theme */
        $theme = $this->laravel->make('theme.manager');
        try {
            //Activate the theme
            $theme->activateTheme($this->option('theme'));
            // Feedback
            $this->components->info("Theme activated");
            // Link the theme assets
            $this->call('theme:link', ['--force' => true]);
            // Optimize the app in production
            $this->call('theme:clear-cache');
        } catch (Exception $e) {
            $this->laravel->make('log')->error($e);
            $this->components->error($e->getMessage());
            return 1;
        }
        return 0;
    }

    protected function getOptions(): array
    {
        return [
            ['theme', 't', InputOption::VALUE_REQUIRED, 'Activate a theme.']
        ];
    }
}
