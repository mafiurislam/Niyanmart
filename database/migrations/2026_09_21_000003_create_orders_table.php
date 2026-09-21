<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // e.g. NM94821670
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Customer & Address Info
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->string('house_flat')->nullable();
            $table->string('street_area');
            $table->string('city')->default('Kolkata');
            $table->string('state')->default('West Bengal');
            $table->string('pincode', 10);
            $table->string('landmark')->nullable();
            $table->string('address_type')->default('Home'); // Home, Work, Other
            
            // Financials
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->string('coupon_code')->nullable();
            $table->decimal('delivery_charge', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            
            // Statuses
            $table->string('payment_method')->default('cod'); // cod, upi, gpay, phonepe, card
            $table->string('payment_status')->default('pending'); // pending, processing, paid, failed, refunded
            $table->string('transaction_id')->nullable();
            $table->string('order_status')->default('placed'); // placed, confirmed, packed, out_for_delivery, delivered, cancelled
            
            $table->text('notes')->nullable();
            $table->timestamp('expected_delivery_date')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('product_name');
            $table->string('product_image')->nullable();
            $table->string('weight')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        Schema::create('order_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('status'); // placed, confirmed, packed, out_for_delivery, delivered
            $table->string('title');
            $table->string('description')->nullable();
            $table->timestamp('tracked_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_trackings');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
