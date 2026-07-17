<?php

namespace App\Models;

use GuzzleHttp\Cookie\FileCookieJar;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

/**
 * @property string $cover
 */
trait HasCoverImage
{
    protected static function bootHasCoverImage(): void
    {
        static::deleting(function (Video $video) {
            $video->deleteCover();
        });
    }

    public function deleteCover(): void
    {
        if (Storage::disk('public')->exists($this->cover)) {
            Storage::disk('public')->delete($this->cover);
        }
    }

    public function getCoverUrl(): string
    {
        if (Str::startsWith($this->cover, 'http')) {
            return $this->cover;
        }
        return Storage::disk('public')->url($this->cover);
    }

    public function setCoverFromUrl(string $url): void
    {
        $temporaryFile = $this->getTempFileUsingHttpClient($url);
        if (!$temporaryFile) return;

        $file = new File($temporaryFile);
        $validation = Validator::make(
            ['file' => $file],
            ['file' => 'mimetypes:' . implode(',', ['image/jpeg', 'image/png'])]
        );

        if ($validation->fails()) return;

        $mediaExtension = explode('/', mime_content_type($temporaryFile));
        $mediaExtension = end($mediaExtension);
        $filename = $this->id . '.' . $mediaExtension;
        Storage::disk('public')->putFileAs('tiktok/', $file, $filename, 'public');
        $this->cover = 'tiktok/' . $filename;

        $this->saveQuietly();
    }

    protected function getTempFile(string $url): string|null
    {
        if (!$stream = @fopen($url, 'r')) {
            return null;
        }

        $temporaryFile = tempnam(sys_get_temp_dir(), 'tiktok-cover');

        file_put_contents($temporaryFile, $stream);

        return $temporaryFile;
    }

    protected function getTempFileUsingHttpClient(string $url): string|null
    {


        try {
            $jar = storage_path("/app/tiktok-cookies-v2.txt");

            $client = Http::timeout(30)
                ->connectTimeout(30)
                ->withUserAgent('Mozilla/5.0 (Linux; Android 12; SM-G996U) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Mobile Safari/537.36')
                ->withoutVerifying()
                ->maxRedirects(5)
                ->withHeaders([
                    'Referer' => 'https://www.tiktok.com/',
                ])
                ->withOptions([
                    'cookies' => new FileCookieJar($jar),
                ])
                ->accept("application/octet-stream");

            $proxies = Proxy::enabled()->get();
            if ($proxies->count() > 0) {
                /** @var Proxy $randomProxy */
                $randomProxy = $proxies->random();
                $client->withOptions([
                    'proxy' => $randomProxy->toUrl(),
                ]);
            }

            $stream = $client->get($url)->body();

            $temporaryFile = tempnam(sys_get_temp_dir(), 'tiktok-cover');

            file_put_contents($temporaryFile, $stream);

            return $temporaryFile;

        } catch (Throwable $e) {
            logger()->error($e);
            return null;
        }
    }
}
