<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Discount name

            $table->enum('type', ['percentage', 'amount']); // Type of discount
            $table->decimal('value', 10, 2); // Discount value
            $table->decimal('min_order_amount', 10, 2)->nullable(); // Minimum order amount
            $table->decimal('max_discount_amount', 10, 2)->nullable(); // Max discount limit
            $table->integer('usage_limit')->nullable(); // Total usage limit
            $table->integer('per_user_limit')->nullable(); // Per-user usage limit
            $table->integer('used_count')->default(0); // Counter for used coupons

            $table->date('expire_date');

            $table->boolean('status')->default(true); // Active or inactive

            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('discounts');
    }
};
