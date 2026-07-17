<?php

namespace App\Exceptions;

use Throwable;

class TikTokVideoNotFoundException extends TikTokException
{
    public function __construct(string $message = null, int $code = 404, int $status = 404, ?Throwable $previous = null)
    {
        $message = $message ?? "Unable to fetch TikTok video.";
        parent::__construct($message, $code, $previous);
        $this->status = $status;
    }
}
