<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';

    protected $fillable = [
        'user_id',
        'order_status',
        'total_amount',
        'order_address',
        'payment_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(Order_Product::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
