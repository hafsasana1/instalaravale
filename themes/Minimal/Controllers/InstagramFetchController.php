<?php

namespace Themes\Minimal\Controllers;

use App\Http\Controllers\Controller;
use App\Service\Instagram\InstagramService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstagramFetchController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $url = trim($request->input('url', ''));

        if (empty($url)) {
            return response()->json(['message' => 'Please enter an Instagram URL.'], 422);
        }

        if (! InstagramService::isValidUrl($url)) {
            return response()->json([
                'message' => 'Invalid URL. Please paste a link from instagram.com/reel/, /p/, /tv/, or /stories/.'
            ], 422);
        }

        try {
            $info = (new InstagramService)->getInfo($url);
            return response()->json($info);
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }
}
