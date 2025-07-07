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
       
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('stock_id')->constrained()->onDelete('cascade');
            $table->enum('order_type', ['Cash on Delivery', 'Card Payment', 'Cash']);
            $table->enum('status', ['Pending', 'Processing', 'Dispatched', 'Out for Delivery', 'Delivered', 'Collected', 'Cancelled', 'Returned', 'Failed']);
            $table->integer('qty');
            $table->text('shipping_address');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
