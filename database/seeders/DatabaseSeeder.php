<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @throws \ErrorException
     */
    public function run(): void
    {
        $rawPass = env('ADMIN_PASSWORD');
        if ($rawPass === null) {
            throw new \ErrorException('No admin password in env.');
        }

        User::create([
            'name'     => 'Admin',
            'email'    => env('ADMIN_EMAIL'),
            'password' => bcrypt($rawPass),
            'email_verified_at' => now(),
        ]);

        Post::factory()->count(20)->create();
    }
}
