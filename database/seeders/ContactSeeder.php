<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            Contact::create([
                'name' => "User {$i}",
                'phone' => '01'.rand(100000000, 999999999),
                'email' => "user{$i}@example.com",
                'address' => "{$i} Example Street, City, Country",
                'nationality' => fake()->country(),
                'gender' => ['male', 'female', 'other'][rand(0, 2)],
                'dob' => fake()->date('Y-m-d', '2005-12-31'), // Random DOB upto 2005
                'designation' => fake()->jobTitle(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
