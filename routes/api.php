<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RatingController;
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
Route::get('/products/category/{categoryId}', [ProductController::class, 'getProductsByCategory']);

//Category
Route::post('/create-category', [CategoryController::class, 'store']);
Route::get('/category/{id}', [CategoryController::class, 'show']);
Route::get('/category-list', [CategoryController::class, 'index']);
Route::delete('/delete-category/{id}', [CategoryController::class, 'destroy']);
Route::post('/edit-category/{id}', [CategoryController::class, 'update']);

//Order
Route::get('/order-list', [OrderController::class, 'index']);
Route::put('/update-order-status/{order}', [OrderController::class, 'updateOrderStatus']);
Route::get('orders/pending-delayed', [OrderController::class, 'getPendingAndDelayedOrders']);
Route::get('orders/{id}/{status}', [OrderController::class, 'belongsToUser']);


//Payment
Route::get('/payments', [PaymentController::class, 'index']);
Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent']);
Route::get('/paypal/return', [PaymentController::class, 'handlePayPalReturn'])->name('paypal.return');
Route::get('/paypal/cancel', [PaymentController::class, 'handlePayPalCancel'])->name('paypal.cancel');
Route::post('/handle-payment-success', [PaymentController::class, 'handlePaymentSuccess']);

//Rating
Route::get('/ratings-list', [RatingController::class, 'index']);

//Analytics
Route::get('/analytics/total-sales', [AnalyticsController::class ,'totalSales']);
Route::get('/analytics/total-profit', [AnalyticsController::class ,'totalProfit']);
Route::get('/analytics/best-selling-products', [AnalyticsController::class ,'bestSellingProducts']);
Route::get('/analytics/individual-product-profits', [AnalyticsController::class, 'individualProductProfits']);