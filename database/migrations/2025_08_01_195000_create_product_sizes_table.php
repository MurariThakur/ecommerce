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
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('size_name');
             $table->string('size_value');
            $table->decimal('additional_price', 10, 2)->default(0);
            $table->integer('quantity')->default(0);
            $table->timestamps();

            // Prevent duplicate entries for the same product-size combination
            $table->unique(['product_id', 'size_name']);

            // Add indexes for better performance
            $table->index('product_id');
            $table->index('size_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sizes');
    }
};
