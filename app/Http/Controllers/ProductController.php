<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function product_index()
    {
        $products = Product::all();
    
        // Append full URL to the image paths
        foreach ($products as $product) {
            if ($product->image) {
                $product->image = asset('storage/' . $product->image);
            }
        }
    
        return response()->json($products);
    }

    public function product_details($id)
    {
        $product = Product::findOrFail($id);
    
        // Append full URL to the image path
        if ($product->image) {
            $product->image = asset('storage/' . $product->image);
        }
    
        return response()->json($product);
    }
    
    

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'category_id' => 'required',
            'product_name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
            'rating' => 'required',
        ]);
    
        // Handle the image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public'); // Store the image in the public/images directory
        }
    
        // Create a new product with the uploaded image path
        $product = Product::create([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath, // Store the image path in the database
            'rating' => $request->rating,
        ]);
    
        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'product_name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required',
        ]);
        
        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $imagePath; // Update the image path
        }
    
        $product->update([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'rating' => $request->rating,
        ]);
    
        return response()->json($product, 200);
    }
    

// app/Http/Controllers/ProductController.php
public function destroy($id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    $product->delete();

    return response()->json(null, 204);
}

}
