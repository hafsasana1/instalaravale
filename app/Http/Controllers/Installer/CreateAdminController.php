<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\Wizard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use RuntimeException;
use Throwable;

class CreateAdminController extends Controller
{
    use Wizard;

    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', Password::default()]
        ]);

        try {
            DB::beginTransaction();

            /** @var User $user */
            $user = User::query()->create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'role' => 'admin'
            ]);

            if (!$user->exists) {
                throw new RuntimeException("Unable to create user");
            }

            $user->markEmailAsVerified();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            logger()->error($e);

            return back()
                ->withInput()
                ->with(['message' => [
                    'type' => 'error',
                    'content' => "Unable to create user. Please check your logs."
                ]]);
        }

        $this->storeStep('installer.finish');

        return redirect()->route('installer.finish')
            ->with(['message' => [
                'type' => 'success',
                'content' => 'Admin account created successfully.'
            ]]);
    }
}
