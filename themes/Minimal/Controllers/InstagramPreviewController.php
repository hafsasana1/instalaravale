<?php

namespace Themes\Minimal\Controllers;

use App\Http\Controllers\Controller;
use App\Service\Instagram\InstagramService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InstagramPreviewController extends Controller
{
    public function __invoke(Request $request)
    {
        $encodedUrl = $request->query('url', '');
        $url = base64_decode($encodedUrl, true);

        if (! $url || ! InstagramService::isValidUrl($url)) {
            abort(400, 'Invalid URL');
        }

        // Ask yt-dlp for the best audio stream URL (fast, no download)
        $bin = InstagramService::ytdlpBinPublic();
        $cmd = sprintf(
            '%s -f bestaudio --get-url --no-playlist --no-warnings --socket-timeout 30 %s 2>&1',
            escapeshellarg($bin),
            escapeshellarg($url)
        );

        exec($cmd, $output, $exit);
        $directUrl = trim(implode("\n", $output));

        // Grab the first valid https line
        foreach (explode("\n", $directUrl) as $line) {
            $line = trim($line);
            if (str_starts_with($line, 'http')) {
                $directUrl = $line;
                break;
            }
        }

        if ($exit !== 0 || ! str_starts_with($directUrl, 'http')) {
            abort(502, 'Could not retrieve stream URL');
        }

        // ── Proxy the stream so the browser audio player can seek ──
        $rangeHeader = $request->header('Range', '');
        $context = stream_context_create([
            'http' => [
                'method'  => 'GET',
                'header'  => $rangeHeader ? "Range: $rangeHeader\r\n" : '',
                'timeout' => 60,
                'ignore_errors' => true,
            ],
        ]);

        $stream = @fopen($directUrl, 'rb', false, $context);

        if (! $stream) {
            // Fallback: redirect — browser handles range itself
            return redirect()->away($directUrl);
        }

        $meta        = stream_get_meta_data($stream);
        $httpCode    = 200;
        $contentType = 'audio/mpeg';
        $contentLen  = null;

        foreach (($meta['wrapper_data'] ?? []) as $header) {
            if (preg_match('/^HTTP\/[\d.]+ (\d+)/', $header, $m)) {
                $httpCode = (int) $m[1];
            }
            if (preg_match('/^Content-Type:\s*(.+)/i', $header, $m)) {
                $contentType = trim($m[1]);
            }
            if (preg_match('/^Content-Length:\s*(\d+)/i', $header, $m)) {
                $contentLen = (int) $m[1];
            }
        }

        $responseHeaders = [
            'Content-Type'  => $contentType,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'no-store',
            'Access-Control-Allow-Origin' => '*',
        ];
        if ($contentLen !== null) {
            $responseHeaders['Content-Length'] = $contentLen;
        }

        return response()->stream(function () use ($stream) {
            while (! feof($stream)) {
                echo fread($stream, 65536);
                flush();
            }
            fclose($stream);
        }, $httpCode, $responseHeaders);
    }
}
