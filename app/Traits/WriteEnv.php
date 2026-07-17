<?php

namespace App\Traits;

trait WriteEnv
{
    function writeENV(array $data = []): bool|int
    {
        $envPath = app()->environmentFilePath();
        $env = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            $env = preg_replace("/^{$key}.*$/m", "{$key}=\"{$value}\"", $env);
        }

        return file_put_contents($envPath, $env);
    }
}
