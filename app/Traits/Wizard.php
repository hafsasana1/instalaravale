<?php

namespace App\Traits;

trait Wizard
{
    public function currentStep(): string|null
    {
        $path = storage_path("/app/.wizard");
        if (!file_exists($path)) return null;
        $route = file_get_contents($path);
        return trim($route);
    }

    function storeStep(string $route): int|bool
    {
        $path = storage_path("/app/.wizard");
        if (!file_exists($path)) touch($path);

        return file_put_contents(storage_path("/app/.wizard"), trim($route));
    }
}
