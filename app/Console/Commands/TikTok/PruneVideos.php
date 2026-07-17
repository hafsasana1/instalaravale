<?php

namespace App\Console\Commands\TikTok;

use App\Models\Video;
use Illuminate\Console\Command;

class PruneVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tiktok:prune-videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old videos and their attachments.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->components->info('Deleting old videos...');
        $count = 0;
        /** @var Video $video */
        foreach (Video::prunable()->cursor() as $video) {
            $video->delete();
            $count++;
        }

        $this->components->info("Deleted {$count} videos.");

        return 0;
    }
}
