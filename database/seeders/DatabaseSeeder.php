<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // UserSeeder::class,
            // CategorySeeder::class,
            // ProductSeeder::class,
            // PaymentSeeder::class,
            // OrderSeeder::class,
            // OrderProductSeeder::class,
            RatingSeeder::class,
           
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            // Add more seeders as needed
        ]);
    }
}
