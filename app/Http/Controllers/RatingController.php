<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    /**
     * Display a listing of the ratings.
     */
    public function index()
    {
        $ratings = Rating::with(['user', 'order'])->get();
        return response()->json($ratings);
    }

    /**
     * Store a newly created rating in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'description' => 'nullable|string',
            'order_id' => 'required|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $rating = Rating::create($request->all());

        return response()->json($rating, 201);
    }

    /**
     * Display the specified rating.
     */
    public function show($id)
    {
        $rating = Rating::with(['user', 'order'])->findOrFail($id);
        return response()->json($rating);
    }

    /**
     * Update the specified rating in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'description' => 'nullable|string',
            'order_id' => 'required|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $rating = Rating::findOrFail($id);
        $rating->update($request->all());

        return response()->json($rating);
    }

    /**
     * Remove the specified rating from storage.
     */
    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);
        $rating->delete();

        return response()->json(null, 204);
    }
}
