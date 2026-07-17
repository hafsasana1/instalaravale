<?php

namespace App\Exceptions;

use Throwable;

class TikTokAPIException extends TikTokException
{
    public function __construct(string $message = null, int $code = 500, int $status = 500, ?Throwable $previous = null)
    {
        $message = $message ?? "Unable to fetch TikTok video.";
        parent::__construct(__($message), $code, $previous);
        $this->status = $status;
    }
}
