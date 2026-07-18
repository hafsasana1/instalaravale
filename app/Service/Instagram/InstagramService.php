<?php

namespace App\Service\Instagram;

class InstagramService
{
    /**
     * Validate that the given URL is a supported Instagram URL.
     */
    public static function isValidUrl(string $url): bool
    {
        return (bool) preg_match(
            '/^https?:\/\/(www\.)?instagram\.com\/(p|reel|reels|tv|stories)\/[a-zA-Z0-9_\-]+/i',
            $url
        );
    }

    /**
     * Fetch audio/video metadata for a given Instagram URL using yt-dlp.
     *
     * @throws \RuntimeException
     */
    public static function ytdlpBinPublic(): string
    {
        return self::ytdlpBin();
    }

    private static function ytdlpBin(): string
    {
        $local = base_path('bin/yt-dlp');
        if (file_exists($local) && is_executable($local)) {
            return $local;
        }
        return 'yt-dlp'; // fallback to PATH
    }

    private static function ffmpegBin(): string
    {
        $candidates = [
            '/nix/store/62mih675xxqazmr87fqm3aq8wh68j2x9-replit-runtime-path/bin/ffmpeg',
            '/usr/bin/ffmpeg',
            'ffmpeg',
        ];
        foreach ($candidates as $path) {
            if (@is_executable($path)) return $path;
        }
        return 'ffmpeg';
    }

    /**
     * Build (or reuse) a Netscape cookies file from env-supplied Instagram session cookies.
     * Returns the path if a sessionid is configured, null otherwise.
     */
    private static function cookiesFile(): ?string
    {
        $sessionId = env('INSTAGRAM_SESSION_ID', '');
        $csrfToken = env('INSTAGRAM_CSRFTOKEN', '');

        if (empty(trim($sessionId))) {
            return null;
        }

        $path = storage_path('app/instagram_cookies.txt');

        // Regenerate whenever the session changes
        $line   = fn(string $name, string $val) =>
            implode("\t", ['.instagram.com', 'TRUE', '/', 'TRUE', '1893456000', $name, $val]);

        $lines  = ["# Netscape HTTP Cookie File", $line('sessionid', trim($sessionId))];
        if (!empty(trim($csrfToken))) {
            $lines[] = $line('csrftoken', trim($csrfToken));
        }

        file_put_contents($path, implode("\n", $lines) . "\n");
        return $path;
    }

    public function getInfo(string $url): array
    {
        $cookiesFile = self::cookiesFile();

        $cookiesArg = $cookiesFile
            ? '--cookies ' . escapeshellarg($cookiesFile)
            : '';

        $cmd = sprintf(
            '%s --dump-json --no-playlist --no-warnings --socket-timeout 30 %s %s 2>&1',
            escapeshellarg(self::ytdlpBin()),
            $cookiesArg,
            escapeshellarg($url)
        );

        exec($cmd, $output, $exitCode);

        $raw = implode('', $output);

        if ($exitCode !== 0 || empty(trim($raw))) {
            // Surface a user-friendly message
            $hint = '';
            if (stripos($raw, 'login') !== false || stripos($raw, 'private') !== false || stripos($raw, 'empty media') !== false) {
                if (!$cookiesFile) {
                    $hint = ' Instagram requires authentication. Please configure INSTAGRAM_SESSION_ID in your environment settings.';
                } else {
                    $hint = ' The content may be private, or your Instagram session cookie may have expired.';
                }
            }
            throw new \RuntimeException('Could not retrieve Instagram media info.' . $hint);
        }

        $data = json_decode($raw, true);

        if (! $data || ! is_array($data)) {
            throw new \RuntimeException('Unexpected response from media extractor.');
        }

        // Extract the best audio stream URL from yt-dlp JSON
        $audioUrl = self::pickBestAudioUrl($data);

        return [
            'id'              => $data['id'] ?? null,
            'title'           => $data['title'] ?? $data['fulltitle'] ?? 'Instagram Audio',
            'description'     => $data['description'] ?? '',
            'thumbnail'       => $data['thumbnail'] ?? null,
            'uploader'        => $data['uploader'] ?? $data['channel'] ?? 'Instagram',
            'uploader_id'     => $data['uploader_id'] ?? $data['channel_id'] ?? null,
            'duration'        => $data['duration'] ?? null,
            'duration_string' => $data['duration_string'] ?? null,
            'url'             => $url,
            'webpage_url'     => $data['webpage_url'] ?? $url,
            'audio_url'       => $audioUrl,
        ];
    }

    /**
     * Pick the best audio-only (or lowest-video) stream URL from yt-dlp JSON.
     * Returns null if no suitable URL is found.
     */
    private static function pickBestAudioUrl(array $data): ?string
    {
        // 1. Prefer audio-only formats (vcodec == "none" or null)
        $formats = $data['formats'] ?? [];
        $audioOnly = array_filter($formats, function ($f) {
            $vcodec = $f['vcodec'] ?? '';
            return ($vcodec === 'none' || $vcodec === null || $vcodec === '')
                && !empty($f['url'])
                && str_starts_with($f['url'], 'http');
        });

        if (!empty($audioOnly)) {
            // Pick the one with the highest tbr/abr
            usort($audioOnly, fn($a, $b) =>
                ($b['tbr'] ?? $b['abr'] ?? 0) <=> ($a['tbr'] ?? $a['abr'] ?? 0)
            );
            return reset($audioOnly)['url'];
        }

        // 2. Fall back to the first format URL with audio
        foreach ($formats as $f) {
            if (!empty($f['url']) && str_starts_with($f['url'], 'http')
                && ($f['acodec'] ?? 'none') !== 'none') {
                return $f['url'];
            }
        }

        // 3. Last resort: top-level url (single-format media)
        if (!empty($data['url']) && str_starts_with($data['url'], 'http')) {
            return $data['url'];
        }

        return null;
    }

    /**
     * Download audio from an Instagram URL and return the local file path.
     * Caller is responsible for deleting the file.
     *
     * @throws \RuntimeException
     */
    public function downloadAudio(string $url, string $format = 'mp3'): string
    {
        $format   = in_array($format, ['mp3', 'm4a'], true) ? $format : 'mp3';
        $tmpBase  = sys_get_temp_dir() . '/ig_audio_' . uniqid('', true);
        $template = $tmpBase . '.%(ext)s';

        $cookiesFile = self::cookiesFile();
        $cookiesArg  = $cookiesFile ? '--cookies ' . escapeshellarg($cookiesFile) : '';

        $cmd = sprintf(
            '%s -x --audio-format %s --audio-quality 0 --no-playlist --no-warnings --socket-timeout 30 --ffmpeg-location %s %s -o %s %s 2>&1',
            escapeshellarg(self::ytdlpBin()),
            escapeshellarg($format),
            escapeshellarg(dirname(self::ffmpegBin())),
            $cookiesArg,
            escapeshellarg($template),
            escapeshellarg($url)
        );

        exec($cmd, $output, $exitCode);

        if ($exitCode !== 0) {
            $msg = implode("\n", array_slice($output, -5));
            throw new \RuntimeException('Audio extraction failed: ' . $msg);
        }

        // yt-dlp may produce the exact extension or something else (e.g. webm→mp3)
        $expected = $tmpBase . '.' . $format;
        if (file_exists($expected)) {
            return $expected;
        }

        // Fall back: find any file matching the base prefix
        $candidates = glob($tmpBase . '.*');
        if (! empty($candidates)) {
            return $candidates[0];
        }

        throw new \RuntimeException('Audio file not found after download.');
    }
}
