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
            $table->string('name');
            $table->string('phone');
            $table->string('city');
            $table->text('address');
            $table->text('notes')->nullable();
            $table->string('status')->default('processing');
            $table->string('payment_method')->default('cash_on_delivery');
            $table->decimal('total_price', 10, 2);
            $table->string('guest_id')->nullable();
            $table->foreign('guest_id')->references('guest_id')->on('guests')->onDelete('set null');
            $table->timestamps();
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
