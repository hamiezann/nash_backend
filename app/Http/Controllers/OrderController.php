<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_Product;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $order = Order::with('user', 'orderProducts.product', 'payment')->get();
        return response()->json($order, 200);
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_status' => 'nullable|string',
            'total_amount' => 'required|numeric',
            'order_address' => 'required|string',
            'payment_id' => 'required|exists:payments,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $order = Order::create($request->only('user_id', 'order_status', 'total_amount', 'order_address', 'payment_id'));

        foreach ($request->products as $product) {
            Order_Product::create([
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }

        return response()->json(['message' => 'Order created successfully.', 'order' => $order], 201);
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load('user', 'orderProducts.product', 'payment');
        return response()->json($order);
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_status' => 'nullable|string',
            'total_amount' => 'required|numeric',
            'order_address' => 'required|string',
            'payment_id' => 'required|exists:payments,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $order->update($request->only('user_id', 'order_status', 'total_amount', 'order_address', 'payment_id'));

        // Delete old order products
        $order->orderProducts()->delete();

        // Add new order products
        foreach ($request->products as $product) {
            Order_Product::create([
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }

        return response()->json(['message' => 'Order updated successfully.', 'order' => $order]);
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully.']);
    }
}
