<?php

namespace App\Console\Commands\Theme;

use Illuminate\Console\Command;

class ClearCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear theme cache';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (!$this->laravel->environment('local')) {
            $this->call('config:cache');
            $this->call('view:cache');
        } else {
            $this->call('config:clear');
            $this->call('view:clear');
        }
        $this->call('route:clear');
        return 0;
    }
}
