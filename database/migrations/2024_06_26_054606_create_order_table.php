<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('product_ID');
            $table->foreign('product_ID')->references('id')->on('product')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_productID');
            $table->foreign('order_productID')->references('id')->on('order_product')->onDelete('cascade');
            $table->string('order_status')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->unsignedBigInteger('user_ID');
            $table->foreign('user_ID')->references('id')->on('users')->onDelete('cascade');
            $table->string('order_address');
            $table->unsignedBigInteger('payment_ID');
            $table->foreign('payment_ID')->references('id')->on('payment')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('order');
    }
};
