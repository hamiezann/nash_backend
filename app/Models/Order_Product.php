<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Product extends Model
{
    use HasFactory;
    public $table = 'category';
    protected $fillable = [
        'quantity',
        'price',
        'product_ID',
       
    ];

    public function order_product()
{
    return $this->belongsTo(Product::class, 'product_ID');
}

    public $timestamps = true;
}
