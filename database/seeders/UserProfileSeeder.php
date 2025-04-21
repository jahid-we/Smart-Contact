<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserProfile::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '123-456-7890',
            'address' => '123 Main Street, City, Country',
            'img_url' => 'https://example.com/images/johndoe.jpg',
            'user_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        UserProfile::create([
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'phone' => '987-654-3210',
            'address' => '456 Elm Street, Town, Country',
            'img_url' => 'https://example.com/images/janesmith.jpg',
            'user_id' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
