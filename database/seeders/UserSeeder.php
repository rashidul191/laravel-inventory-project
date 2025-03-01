<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();  // Create a Faker instance

        // Loop to create fake users
        foreach (range(1, 20) as $index) {
            DB::table('users')->insert([
                'firstName' => $faker->firstName,  // Fake first name
                'lastName' => $faker->lastName,    // Fake last name
                'email' => $faker->unique()->safeEmail,  // Fake email
                'mobile' => $faker->phoneNumber,   // Fake mobile number
                'password' => '123456',  // Plain text password
                'otp' => '0',  // Plain text password
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
