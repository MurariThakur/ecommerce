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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('subcategory_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->decimal('old_price', 10, 2)->nullable();
            $table->decimal('price', 10, 2);
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('additional_information')->nullable();
            $table->longText('shipping_return')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('isdelete')->default(false);
            $table->timestamps();
            
            $table->index(['category_id', 'subcategory_id', 'brand_id']);
            $table->index(['status', 'isdelete']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
