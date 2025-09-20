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
        Schema::create('mobile_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('item');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->decimal('deposit', 10, 2);
            $table->date('booking_date')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobile_bookings');
    }
};
