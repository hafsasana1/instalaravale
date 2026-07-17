<?php

namespace App\Events;

use App\Service\TikTok\TikTokVideo;
use Illuminate\Foundation\Events\Dispatchable;

class TikTokVideoFetched
{
    use Dispatchable;

    public TikTokVideo $video;

    /**
     * Create a new event instance.
     */
    public function __construct(TikTokVideo $video)
    {
        $this->video = $video;
    }
}
