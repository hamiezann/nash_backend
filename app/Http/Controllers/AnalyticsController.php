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
        $completedOrders = Order::where('order_status', 'Completed') ->get();
        $totalProfit = 0;

        foreach ($completedOrders as $order) {
            $orderProducts = $order->orderProducts;

            foreach ($orderProducts as $orderProduct) {
                $product = $orderProduct->product;
                $profitPerProduct = ($orderProduct-> price - $product-> product_cost) * $orderProduct->quantity;
                $totalProfit += $profitPerProduct;
            }
        }
                        

        return response()->json(['total_profit' => $totalProfit], 200);
    }

    public function bestSellingProducts()
    {
        // Example: Fetch top 5 best-selling products by quantity sold
        $bestSellingProducts = Product::orderByDesc('quantity_sold')
                                      ->take(5)
                                      ->get();
                                        foreach ($bestSellingProducts as $bestSellingproduct) {
                                        if ($bestSellingproduct->image) {
                                            $bestSellingproduct->image = asset('storage/' . $bestSellingproduct->image);
                                        }
                                    }

        return response()->json(['best_selling_products' => $bestSellingProducts]);
    }

    public function individualProductProfits()
    {
        // Get all completed orders
        $completedOrders = Order::where('order_status', 'Completed')->get();

        // Initialize an array to store profits for each product
        $productProfits = [];

        // Iterate through each order
        foreach ($completedOrders as $order) {
            // Get all products in the order
            $orderProducts = $order->orderProducts;

            // Calculate profit for each product in the order
            foreach ($orderProducts as $orderProduct) {
                $product = $orderProduct->product;
                $profitPerProduct = ($orderProduct->price - $product->product_cost) * $orderProduct->quantity;

                // If the product already has a profit calculated, add to it
                if (isset($productProfits[$product->id])) {
                    $productProfits[$product->id]['profit'] += $profitPerProduct;
                } else {
                    // Otherwise, initialize the profit for this product
                    $productProfits[$product->id] = [
                        'product_name' => $product->product_name,
                        'profit' => $profitPerProduct
                    ];
                }
            }
        }

        return response()->json(['individual_product_profits' => $productProfits], 200);
    }

}
