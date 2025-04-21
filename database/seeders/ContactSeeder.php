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
        Contact::create([
            'name' => 'John Doe',
            'phone' => '123-456-7890',
            'email' => 'johndoe@example.com',
            'address' => '123 Main Street, City, Country',
            'nationality' => 'American',
            'gender' => 'male',
            'dob' => '1990-05-15',
            'designation' => 'Software Developer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Contact::create([
            'name' => 'Jane Smith',
            'phone' => '987-654-3210',
            'email' => 'janesmith@example.com',
            'address' => '456 Elm Street, Town, Country',
            'nationality' => 'British',
            'gender' => 'female',
            'dob' => '1985-08-20',
            'designation' => 'Graphic Designer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Contact::create([
            'name' => 'Sam Lee',
            'phone' => '555-123-9876',
            'email' => 'samlee@example.com',
            'address' => '789 Oak Avenue, Village, Country',
            'nationality' => 'Canadian',
            'gender' => 'other',
            'dob' => '2000-12-05',
            'designation' => 'Product Manager',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
