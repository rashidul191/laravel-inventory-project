<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class InvoiceProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get existing invoices, users, and products using DB Query Builder
        $invoices = DB::table('invoices')->pluck('id'); // Get all invoice IDs
        $users = DB::table('users')->pluck('id'); // Get all user IDs
        $products = DB::table('products')->pluck('id'); // Get all product IDs

        // Create fake data for the invoice_products table
        for ($i = 0; $i < 50; $i++) { // Change 50 to the desired number of records
            // Randomly choose an invoice, user, and product
            $invoice_id = $invoices->random();
            $user_id = $users->random();
            $product_id = $products->random();

            // Insert into the invoice_products table using DB Query Builder
            DB::table('invoice_products')->insert([
                'invoice_id' => $invoice_id,  // Reference to invoice
                'product_id' => $product_id,  // Reference to product
                'user_id' => $user_id,        // Reference to user
                'qty' => $faker->randomNumber(2), // Random quantity (e.g., 1, 5, 10, etc.)
                'sale_price' => $faker->randomFloat(2, 10, 500), // Random sale price between 10 and 500
                'created_at' => now(), // Current timestamp for created_at
                'updated_at' => now(), // Current timestamp for updated_at
            ]);
        }
    }
}
