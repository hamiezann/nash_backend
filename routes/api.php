<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Authentication
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/logout',[AuthenticationController::class,'logout'])
  ->middleware('auth:sanctum');

// Category Route
Route::get('/category-list', [CategoryController::class, 'index']);


// Product
Route::get('/product-list', [ProductController::class, 'product_index']);
Route::get('/product/{id}', [ProductController::class, 'product_details']);
Route::delete('/delete-product/{id}', [ProductController::class, 'destroy']);
Route::post('/create-product', [ProductController::class, 'store']);
Route::post('/edit-product/{id}', [ProductController::class, 'update']);