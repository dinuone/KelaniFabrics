p<?php

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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->char('cust_fname', 200);
            $table->char('cust_lname', 200)->nullable();
            $table->char('contact_number', 15)->unique()->nullable();
            $table->char('email',100)->nullable();
            $table->text('address')->nullable();
            $table->char('gender', 10)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
