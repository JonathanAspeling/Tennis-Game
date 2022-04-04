<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SetupTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:create-test-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A command that creates a test user to use in app.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::create([
            'name' => 'test',
            'email' => 'test@test.test',
            'password' => Hash::make('password'),
        ]);

        return 0;
    }
}
