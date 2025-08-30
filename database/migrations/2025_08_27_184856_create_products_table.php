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
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->string('brand');
            $table->string('size'); // حجم العبوة
            $table->integer('quantity_per_box'); // عدد العبوات في الصندوق
            $table->decimal('price_per_box', 10, 2);
            $table->decimal('price_per_bottle', 10, 2);
            $table->string('image')->nullable();
            $table->string('barcode')->nullable();
            $table->enum('type', ['mineral', 'distilled', 'spring', 'alkaline'])->default('mineral');
            $table->enum('status', ['available', 'out_of_stock', 'discontinued'])->default('available');
            $table->integer('stock_quantity')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_sales')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
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
