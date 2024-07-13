<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'description',
        'price',
        'product_cost',
        'image',
        'rating',
        'product_name',
        'quantity_sold',

    ];
}
