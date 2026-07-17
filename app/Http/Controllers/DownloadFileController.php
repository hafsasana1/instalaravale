<?php

namespace App\Http\Controllers;

use App\Service\Instagram\InstagramService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadFileController extends Controller
{
    public function __invoke(Request $request): StreamedResponse|\Illuminate\Http\JsonResponse
    {
        $encodedUrl = $request->query('url');
        $format     = $request->query('format', 'mp3');

        if (empty($encodedUrl)) {
            return response()->json(['message' => 'Missing URL parameter.'], 400);
        }

        $url = base64_decode($encodedUrl, true);

        if (! $url || ! InstagramService::isValidUrl($url)) {
            return response()->json(['message' => 'Invalid or expired download link.'], 400);
        }

        $format = in_array($format, ['mp3', 'm4a'], true) ? $format : 'mp3';

        try {
            $filePath = (new InstagramService)->downloadAudio($url, $format);
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        if (! file_exists($filePath)) {
            return response()->json(['message' => 'File not found after download.'], 500);
        }

        $mimeType = $format === 'mp3' ? 'audio/mpeg' : 'audio/mp4';
        $fileName = 'instagram-audio-' . time() . '.' . $format;
        $fileSize = filesize($filePath);

        return response()->stream(function () use ($filePath) {
            $handle = fopen($filePath, 'rb');
            while (! feof($handle)) {
                echo fread($handle, 8192);
                ob_flush();
                flush();
            }
            fclose($handle);
            @unlink($filePath);
        }, 200, [
            'Content-Type'        => $mimeType,
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Content-Length'      => $fileSize,
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
        ]);
    }
}
