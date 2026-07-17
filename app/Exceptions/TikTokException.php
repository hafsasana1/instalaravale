<?php

namespace App\Exceptions;

use RuntimeException;

class TikTokException extends RuntimeException
{
    protected int $status;

    public function getStatusCode(): int
    {
        return $this->status;
    }
}
