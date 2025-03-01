<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();  // Create a Faker instance

        // Loop to create fake customers
        foreach (range(1, 50) as $index) {
            // Get a random user ID from the users table
            $user_id = User::inRandomOrder()->first()->id;

            DB::table('categories')->insert([
                'name' => $faker->name,  // Fake name
                'user_id' => $user_id,  // Foreign key referencing the users table
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
