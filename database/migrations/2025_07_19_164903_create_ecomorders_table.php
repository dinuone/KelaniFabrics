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
        Schema::create('ecomorders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_email')->nullable(); 
            $table->string('customer_phone')->nullable();  
            $table->string('customer_address')->nullable(); 
            $table->string('customer_city')->nullable(); 
            $table->string('customer_state')->nullable();
            $table->string('customer_name')->nullable(); 
            $table->unsignedBigInteger('customer_id')->nullable(); // optional, if customers are stored
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method')->nullable(); // e.g., cash, card, etc.
            $table->string('status')->default('pending'); // e.g., pending, completed, cancelled
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecomorders');
    }
};
