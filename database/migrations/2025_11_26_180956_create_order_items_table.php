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
        Schema::create('order_items', function (Blueprint $table) {
            // Composite Primary Key
            $table->primary(['order_id', 'product_id']);

            // Foreign Keys
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // If an order is deleted, its items are deleted.
            $table->foreignId('product_id')->constrained()->onDelete('restrict'); // Prevent deleting a product if it's in an order.

            $table->integer('quantity');
            $table->decimal('price_at_time_of_purchase', 10, 2); // Important to store the price here, as product prices can change.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
