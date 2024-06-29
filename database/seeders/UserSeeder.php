<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('users')->insert([
        [
            'username' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'address' => '123 Main St, Anytown, USA',
            'contact_number' => '123-456-7890',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'username' => 'Customer 1',
            'email' => 'customer1@hmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'customer',
            'address' => '123 Main St, Anytown, USA',
            'contact_number' => '123-456-7890',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ],
     ]);
    }
}
