<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Product extends Model
{
    use HasFactory;
    public $table = 'order_product';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
       
    ];

    public function order_product()
{
    return $this->belongsTo(Product::class, 'product_id');
}

    public $timestamps = true;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
