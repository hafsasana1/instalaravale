<?php

namespace App\View\Components\Admin\Card;

use Illuminate\Support\Facades\Http;

trait InteractsWithLicense
{
    public static string $licenseStatus = 'in-active';
    public static array $licenseData = [];
    public static bool $fetchedLicenseStatus = false;

    protected function getLicense(): void
    {
        if (static::$fetchedLicenseStatus) return;
        static::$fetchedLicenseStatus = true;

        $response = Http::timeout(30)
            ->baseUrl(config('services.codespikex.api'))
            ->acceptJson()
            ->get('/api/v2/license/status', [
                'ip'=> request()->ip(),
                'license' => config('app.license_key'),
                'domain' => config('app.url'),
            ]);

        if ($response->failed()) {
            static::$licenseStatus = 'in-active';
            return;
        }

        $data = $response->json();
        static::$licenseData = $data;
        static::$licenseStatus = data_get($data, 'status', 'in-active');
    }

    public function licenseStatus(): string
    {
        return static::$licenseStatus;
    }

    public function licenseData(string $key = null, $default = null): mixed
    {
        if(is_null($key)) return static::$licenseData;
        return data_get(static::$licenseData, $key, $default);
    }
}
