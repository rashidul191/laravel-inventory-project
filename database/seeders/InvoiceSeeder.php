<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get existing user IDs and customer IDs from the database
        $userIds = DB::table('users')->pluck('id')->toArray(); // Get all user IDs
        $customerIds = DB::table('customers')->pluck('id')->toArray(); // Get all customer IDs

        // Create fake data for the invoices table
        for ($i = 0; $i < 50; $i++) { // You can change 50 to however many records you want
            DB::table('invoices')->insert([
                'total' => $faker->randomFloat(2, 100, 10000), // Random total between 100 and 10000
                'discount' => $faker->randomFloat(2, 0, 100), // Random discount between 0 and 100
                'vat' => $faker->randomFloat(2, 0, 50), // Random VAT between 0 and 50
                'payable' => $faker->randomFloat(2, 0, 10000), // Random payable between 0 and 10000
                'user_id' => $faker->randomElement($userIds), // Random user_id from existing users
                'customer_id' => $faker->randomElement($customerIds), // Random customer_id from existing customers
                'created_at' => now(), // Use the current timestamp for created_at
                'updated_at' => now(), // Use the current timestamp for updated_at
            ]);
        }
    }
}
