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

        for ($i = 2; $i <= 20; $i++) {
            User::create([
                'email' => "user{$i}@example.com",
                'role' => ['admin', 'editor', 'user'][rand(0, 2)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
