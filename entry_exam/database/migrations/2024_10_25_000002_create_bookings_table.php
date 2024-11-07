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
        Schema::create('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id')->autoIncrement();
            $table->integer('hotel_id');
            $table->string('customer_name')->comment('Customer name');
            $table->string('customer_contact')->comment('Customer contact');
            $table->dateTime('checkin_time')->nullable();
            $table->dateTime('checkout_time');
            $table->timestamps();
            $table->softDeletes();// <-- This will add a deleted_at field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
