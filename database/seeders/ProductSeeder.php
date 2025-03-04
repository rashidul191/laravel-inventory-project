<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Assuming you already have users and categories in the database.     
        $user_id  = User::inRandomOrder()->first()->id;
        $category_id = Category::inRandomOrder()->first()->id;

        // Insert multiple records
        foreach (range(1, 50) as $index) {
            DB::table('products')->insert([
                'name' => $faker->word,
                'price' => $faker->randomFloat(2, 1, 100),
                'unit' => $faker->word,
                'img_url' => $faker->imageUrl(),
                'user_id' => $user_id,
                'category_id' => $category_id,
            ]);
        }
    }
}
