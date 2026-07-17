<?php

namespace App\Exceptions;

use Throwable;

class ProxyException extends TikTokException
{
    public function __construct(string $message = null, int $code = 0, int $status = 500, ?Throwable $previous = null)
    {
        $message = $message ?? "The proxy is not working.";
        parent::__construct(__($message), $code, $previous);
        $this->status = $status;
    }
}
