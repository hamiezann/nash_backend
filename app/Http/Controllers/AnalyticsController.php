<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function totalSales()
    {
        $totalSales = Order::where('order_status', 'Completed')->sum('total_amount');
        return response()->json(['total_sales' => $totalSales], 200);
    }

    public function totalProfit()
    {
        // Example: Calculate total profit based on orders and product costs
        $totalProfit = Order::where('order_status', 'Completed')
                           ->sum(function ($order) {
                               return $order->total_amount - $order->total_cost; // Adjust as per your business logic
                           });

        return response()->json(['total_profit' => $totalProfit]);
    }

    public function bestSellingProducts()
    {
        // Example: Fetch top 5 best-selling products by quantity sold
        $bestSellingProducts = Product::orderByDesc('quantity_sold')
                                      ->take(5)
                                      ->get();

        return response()->json(['best_selling_products' => $bestSellingProducts]);
    }

}
