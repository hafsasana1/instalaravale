<?php

namespace App\Console\Commands;

use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->ask('What is the user name?');
        $email = $this->ask('What is the user email?');
        $password = $this->secret('What is the user password?');
        $role = $this->choice('What is the user role?', ['admin', 'demo']);

        $this->info("Creating user {$name}...");
        try {
            User::query()->create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => $role,
            ]);

            $this->info("User {$name} created!");
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }
        return 0;
    }
}
