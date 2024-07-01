<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('products')->insert([
            [
                'category_id' => 1,
                'product_name' => 'Latte',
                'description' => 'A creamy coffee made with espresso and steamed milk.',
                'price' => 3.50,
                'image' => 'latte.jpg',
                'rating' => '4.5',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => 2,
                'product_name' => 'Chicken Avocado Sandwich',
                'description' => 'Grilled chicken, avocado, lettuce, and tomato on whole grain bread.',
                'price' => 7.50,
                'image' => 'chicken_avocado_sandwich.jpg',
                'rating' => '4.7',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => 3,
                'product_name' => 'Chocolate Brownie',
                'description' => 'Rich chocolate brownie with walnuts, served warm with vanilla ice cream.',
                'price' => 4.50,
                'image' => 'chocolate_brownie.jpg',
                'rating' => '4.8',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Add more products as needed
        ]);
    }
}
