<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UpdateUserPasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user password';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->ask('Email');
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->components->error('User not found');
            return 1;
        }

        $password = $this->secret('Password');
        $user->password = Hash::make($password);
        $user->save();

        $this->components->info('Password updated');

        return 0;
    }
}
