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
            $table->string('name');
            $table->string('sku')->unique(); // Stock Keeping Unit, should be unique
            $table->text('description')->nullable();

            // Foreign Keys
            $table->foreignId('category_id')->constrained()->onDelete('restrict'); // Prevent deleting a category if it has products
            $table->foreignId('supplier_id')->constrained()->onDelete('restrict'); // Prevent deleting a supplier if it has products

            $table->decimal('purchase_price', 10, 2); // Price you bought it for
            $table->decimal('selling_price', 10, 2);  // Price you sell it for
            $table->integer('quantity_in_stock')->unsigned()->default(0);
            $table->string('image_url')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Adds a 'deleted_at' column
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
