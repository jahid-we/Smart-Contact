<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'jahidhasan370919@gmail.com',
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'email' => 'editor@example.com',
            'role' => 'editor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::create([
            'email' => 'editor1@example.com',
            'role' => 'editor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::create([
            'email' => 'editor2@example.com',
            'role' => 'editor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'email' => 'user@example.com',
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::create([
            'email' => 'user2@example.com',
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::create([
            'email' => 'user3@example.com',
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::create([
            'email' => 'user4@example.com',
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::create([
            'email' => 'user5@example.com',
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::create([
            'email' => 'user6@example.com',
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::create([
            'email' => 'user7@example.com',
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
