<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use App\Service\StorableConfig;
use App\Traits\Wizard;
use App\Traits\WriteEnv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class VerifyPurchaseCodeController extends Controller
{
    use WriteEnv;
    use Wizard;

    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'domain' => ['required', 'string', 'starts_with:http'],
            'license_key' => ['required', 'string', 'uuid'],
        ], [
            'domain.starts_with' => 'The domain must start with http:// or https://',
            'license_key.required' => 'The purchase code is required.',
            'license_key.string' => 'The purchase code must be a string.',
            'license_key.uuid' => 'The purchase code must be a valid UUID.',
        ]);

        try {

            $domain = str($request->get('domain'))
                ->replace('http://', '')
                ->replace('https://', '')
                ->trim();

            $licenseKey = trim($request->get('license_key'));

            $response = Http::timeout(30)
                ->withUserAgent($request->userAgent())
                ->withoutVerifying()
                ->baseUrl(config('services.codespikex.api'))
                ->acceptJson()
                ->post('/api/v2/license/activate', [
                    'ip' => $request->ip(),
                    'license' => $licenseKey,
                    'domain' => $domain,
                ]);

            if ($response->failed()) {
                return back()->withInput()->with('message', [
                    'type' => 'error',
                    'content' => $response->json('message', 'Failed to connect to CodeSpikeX API.'),
                ]);
            }

            $domain = trim($request->get('domain'));
            config(['app.url' => $domain]);
            if (!$this->writeENV(['APP_URL' => $domain])) {
                return back()->withInput()->with('message', [
                    'type' => 'error',
                    'content' => 'Failed to write APP_URL to .env file.',
                ]);
            }
            /** @var StorableConfig $storable */
            $storable = app('config.storable');
            $storable->put('app', [
                'license_key' => $licenseKey
            ]);

            if (!$storable->save()) {
                return back()->withInput()->with('message', [
                    'type' => 'error',
                    'content' => 'Failed to write license key to config file.',
                ]);
            }

            $result = Artisan::call('key:generate', [
                '--force' => true,
                '--no-interaction' => true,
                '--quiet' => true
            ]);

            if ($result !== 0) {
                return back()
                    ->withInput()
                    ->with(['message' => [
                        'type' => 'error',
                        'content' => 'Unable to generate app key. Please check your artisan permissions.'
                    ]]);
            }

            if (!$this->storeStep('installer.database')) {
                return back()->withInput()->with('message', [
                    'type' => 'error',
                    'content' => 'Failed to store step in storage/app/.wizard file.',
                ]);
            }

            return redirect()->route('installer.database')->with('message', [
                'type' => 'success',
                'content' => $response->json('message', 'Purchase code verified successfully.'),
            ]);

        } catch (\Throwable $exception) {
            logger()->error($exception);
            return back()->withInput()->with('message', [
                'type' => 'error',
                'content' => $exception->getMessage(),
            ]);
        }
    }
}
