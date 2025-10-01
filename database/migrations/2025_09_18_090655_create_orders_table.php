<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('company')->nullable();
            $table->string('country');
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->string('discount_name')->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->string('shipping_method')->nullable();
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('payment_method');
            $table->boolean('is_payment')->default(false);
            $table->json('payment_data')->nullable();
            $table->boolean('isdelete')->default(false);
            $table->enum('status', [
                'pending',
                'confirmed',
                'processing',
                'shipped',
                'delivered',
                'cancelled',
                'return_requested',
                'return_approved',
                'return_rejected',
                'refund_processing',
                'refunded'
            ])->default('pending')->change();
            $table->timestamp('expires_at')->nullable();
            $table->string('idempotency_token')->nullable()->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};