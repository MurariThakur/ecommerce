<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('refund_number')->unique();
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['cancellation', 'return', 'replacement']);
            $table->enum('status', ['initiated', 'approved', 'processing', 'completed', 'rejected', 'failed'])->default('initiated');
            $table->string('payment_method');
            $table->text('reason')->nullable();
            $table->text('admin_notes')->nullable();
            $table->json('refund_data')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('estimated_days')->default(7);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('refunds');
    }
};