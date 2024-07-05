<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['category_name' => 'Main Course']);
        Category::create(['category_name' => 'Appetizers']);
        Category::create(['category_name' => 'Desserts']);
        Category::create(['category_name' => 'Side Dishes']);
        Category::create(['category_name' => 'Beverages']);
    }
}
