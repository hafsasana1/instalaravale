<?php

namespace App\Listeners;

use App\Events\TikTokVideoFetched;
use App\Models\Video;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateTikTokVideoRecord
{
    /**
     * Handle the event.
     */
    public function handle(TikTokVideoFetched $event): void
    {
        if (!$event->video->id) {
            return;
        }

        try {
            DB::beginTransaction();

            $coverUrl = data_get($event->video, 'cover.url');

            /** @var Video $video */
            $video = Video::query()->firstOrCreate(['id' => $event->video->id], [
                'caption' => $event->video->caption,
                'username' => data_get($event->video, 'author.username'),
                'url' => $event->video->url,
                'cover' => $coverUrl,
                'downloads' => 1
            ]);

            if ($video->wasRecentlyCreated && $coverUrl) {
                $video->setCoverFromUrl($coverUrl);

                // reset the cover if the url was signed
                // @fixed in v3.0.4
            } else if ($coverUrl && Str::startsWith($video->cover, 'https')) {
                $video->deleteCover();
                $video->setCoverFromUrl($coverUrl);
            }

            if (!$video->wasRecentlyCreated && $video->exists) {
                $video->increment('downloads');
                $video->update(array_filter([
                    'username' => data_get($event->video, 'author.username')
                ]));
            }

            DB::commit();
        } catch
        (Exception $e) {
            DB::rollBack();
            logger()->error($e);
        }
    }
}
