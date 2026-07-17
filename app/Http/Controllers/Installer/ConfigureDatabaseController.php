<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use App\Traits\Wizard;
use App\Traits\WriteEnv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Throwable;

class ConfigureDatabaseController extends Controller
{
    use WriteEnv;
    use Wizard;

    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'database_host' => ['required', 'string'],
            'database_port' => ['required', 'numeric'],
            'database_name' => ['required', 'string'],
            'database_username' => ['required', 'string'],
            'database_password' => ['nullable', 'string'],
        ]);


        try {

            if (!$this->testConnection($request)) {
                return back()->exceptInput('database_password')
                    ->with('message', [
                        'type' => 'error',
                        'content' => "Database connection failed. Please check your credentials and try again."
                    ]);
            }

            $env = [
                'DB_HOST' => $request->get('database_host'),
                'DB_PORT' => $request->get('database_port'),
                'DB_DATABASE' => $request->get('database_name'),
                'DB_USERNAME' => $request->get('database_username'),
                'DB_PASSWORD' => $request->get('database_password', '') ?? '',
            ];

            if (!$this->writeENV($env)) {
                return back()->exceptInput('database_password')
                    ->with('message', [
                        'type' => 'error',
                        'content' => "Failed to write database credentials to .env file."
                    ]);
            }

            if (Artisan::call('config:clear', ['--quiet' => true]) !== 0) {
                return back()
                    ->exceptInput('database_password')
                    ->with('message', [
                        'type' => 'error',
                        'content' => "Failed to clear config cache. Please try again."
                    ]);
            }

            $result = Artisan::call("migrate:fresh", [
                '--no-interaction' => true,
                '--force' => true,
                '--quiet' => true,
            ]);

            if ($result !== 0) {
                return back()
                    ->exceptInput('database_password')
                    ->with('message', [
                        'type' => 'error',
                        'content' => "Database migration failed. Please check your credentials and try again."
                    ]);
            }

            $this->storeStep("installer.admin");

            return redirect()
                ->route('installer.admin')
                ->with('message', [
                    'type' => 'success',
                    'content' => "Database configured successfully."
                ]);

        } catch (Throwable $exception) {
            logger()->error($exception);

            return back()
                ->exceptInput('database_password')
                ->with('message', [
                    'type' => 'error',
                    'content' => "An error occurred while configuring database. Please try again."
                ]);
        }
    }

    function testConnection(Request $request): bool
    {
        $connection = config('database.default');

        $config = [
            'driver' => config('database.connections.' . $connection . '.driver'),
            'host' => $request->input('database_host'),
            'port' => $request->input('database_port'),
            'database' => $request->input('database_name'),
            'username' => $request->input('database_username'),
            'password' => $request->input('database_password', "") ?? "",
        ];

        $baseConfig = config('database.connections.' . $connection);
        config(["database.connections.$connection" => array_merge($baseConfig, $config)]);

        try {
            DB::purge();
            DB::reconnect($connection);
            DB::connection($connection)->getPDO();
            return true;
        } catch (Throwable $e) {
            logger()->error($e);
            return false;
        }
    }
}
