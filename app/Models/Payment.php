<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';

    protected $fillable = [
        'total_price',
        'payment_method',
        'transaction_id',

    ];

    public function orders() {
    return $this->hasMany(Order::class);
    }
}
