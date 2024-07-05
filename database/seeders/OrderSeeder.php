<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order')->insert([
            [
                'user_id' => 1,
                'order_status' => 'Preparing',
                'total_amount' => 250.00,
                'order_address' => '123 Main St, Anytown, USA',
                'payment_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'order_status' => 'Completed',
                'total_amount' => 100.50,
                'order_address' => '456 Elm St, Othertown, USA',
                'payment_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'order_status' => 'Preparing',
                'total_amount' => 300.00,
                'order_address' => '789 Oak St, Sometown, USA',
                'payment_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'order_status' => 'Completed',
                'total_amount' => 150.75,
                'order_address' => '101 Pine St, Anothertown, USA',
                'payment_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'order_status' => 'Completed',
                'total_amount' => 200.00,
                'order_address' => '202 Maple St, Yetanothertown, USA',
                'payment_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
