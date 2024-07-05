<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment')->insert([
            [
                'total_price' => 100.00,
                'payment_method' => 'Bank Transfer',
                'transaction_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'total_price' => 150.50,
                'payment_method' => 'Bank Transfer',
                'transaction_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'total_price' => 200.00,
                'payment_method' => 'Bank Transfer',
                'transaction_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'total_price' => 250.75,
                'payment_method' => 'Bank Transfer',
                'transaction_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'total_price' => 300.00,
                'payment_method' => 'Bank Transfer',
                'transaction_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
