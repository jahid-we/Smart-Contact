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
            'email' => 'user@example.com',
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
