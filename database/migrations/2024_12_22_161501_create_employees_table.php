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
       Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // Use ulid for user_id to match users.id type
           $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

            $table->char('first_name', 50);
            $table->char('last_name', 50)->nullable();
            $table->text('address')->nullable();
            $table->date('dob')->nullable();
            $table->char('contact_number', 15)->unique();
            $table->date('join_date')->nullable();
            $table->date('resign_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
