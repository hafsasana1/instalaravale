<?php

namespace Themes\Minimal\Controllers;

use App\Events\TikTokVideoFetched;
use App\Exceptions\TikTokException;
use App\Exceptions\TikTokVideoNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\FetchRequest;
use App\Models\User;
use App\Models\Video;
use App\Service\TikTok\TikTok;
use Illuminate\Http\JsonResponse;

class FetchController extends Controller
{
    public function __invoke(FetchRequest $request): JsonResponse
    {
        try {
            $video = (new TikTok)->getVideo($request->url);
            event(new TikTokVideoFetched($video));

            /** @var Video $videoModel */
            if ($videoModel = Video::query()->find($video->id)) {
                $cover = $video->cover;
                $cover['url'] = $videoModel->getCoverUrl();
                $video->offsetSet('cover', $cover);
            }

            $downloadUrls = collect($video->downloads)
                ->sortByDesc('bitrate')
                ->map(function ($data, $key) {
                    $isHD = $key == 0;
                    return collect(data_get($data, 'urls', []))
                        ->take(config('app.link_per_bitrate', 2))
                        ->map(fn($url) => [
                            'url' => $url,
                            'isHD' => $isHD,
                            'size' => data_get($data, 'size')
                        ])->all();
                })
                ->flatten(1)
                ->reject(fn($item) => empty(data_get($item, 'url')))
                ->map(fn($data, $idx) => array_merge($data, compact('idx')))
                ->values();

            $data = [
                'author' => [
                    'username' => data_get($video, 'author.username'),
                    'avatar' => data_get($video, 'author.avatar.url'),
                ],
                'mp3URL' => data_get($video, 'music.downloadUrl'),
                'coverURL' => data_get($video, 'cover.url'),
                'watermark' => data_get($video, 'watermark'),
                'downloadUrls' => $downloadUrls,
                'caption' => $video->caption
            ];

            return response()->json($data);
        } catch (TikTokException $exception) {
            $message = $exception->getMessage();
            $code = $exception->getCode();
            $status = $exception->getStatusCode();

            $message = "[Error: $code]: $message";

            /** @var User $user */
            $user = auth()->user();
            if (!$user || !$user->is_admin) {
                $message = "An unknown error occurred. Error Code: $code";
            }

            if ($exception instanceof TikTokVideoNotFoundException) {
                $message = $exception->getMessage() . " Error Code: $code";
            }

            if (!$request->wantsJson()) {
                abort($message, $status);
            }

            return response()->json(compact('message'), $status);
        }
    }
}
