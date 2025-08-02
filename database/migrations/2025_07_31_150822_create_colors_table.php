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
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color_code')->unique();
            $table->boolean('status')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            // Add indexes for better performance
            $table->index('status');
            $table->index('is_deleted');
            $table->index(['status', 'is_deleted']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colors');
    }
};
