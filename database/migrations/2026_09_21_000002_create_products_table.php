<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->nullOnDelete();
            $table->string('name');
            $table->string('name_bn')->nullable();
            $table->string('slug')->unique();
            $table->string('brand')->nullable();
            $table->string('sku')->unique()->nullable();
            $table->text('description')->nullable();
            $table->text('specifications')->nullable();
            $table->decimal('mrp', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->integer('discount_percent')->default(0);
            $table->string('weight')->default('500 g');
            $table->string('unit')->default('g');
            $table->integer('stock')->default(50);
            $table->integer('min_order_qty')->default(1);
            $table->integer('max_order_qty')->default(20);
            $table->string('image')->nullable();
            $table->string('badge')->nullable(); // e.g. "10% OFF", "Best Seller", "Buy 1 Get 1"
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->boolean('is_active')->default(true);
            $table->decimal('rating', 3, 1)->default(4.5);
            $table->integer('reviews_count')->default(0);
            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('image_path');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('weight'); // e.g. 100 g, 200 g, 500 g, 1 Kg
            $table->string('unit')->default('g');
            $table->decimal('mrp', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->integer('stock')->default(50);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
    }
};
