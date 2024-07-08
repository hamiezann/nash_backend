<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        // $payments = Payment::all();
        $payments = Payment::with('orders.user', 'orders.orderProducts.product')->get();
        return response()->json($payments, 200);
    }
}
