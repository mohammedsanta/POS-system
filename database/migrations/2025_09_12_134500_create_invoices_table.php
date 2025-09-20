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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('barcode_id')->nullable()->constrained('product_barcodes')->cascadeOnDelete();
            $table->integer('invoice_number')->unique();
            $table->string('product_name');             // اسم المنتج
            $table->string('customer_name')->nullable();// اسم العميل (اختياري)
            $table->integer('qty')->default(1);         // الكمية
            $table->decimal('price',10,2);              // سعر القطعة
            $table->decimal('total',12,2);              // إجمالي = qty × price
            $table->timestamp('sold_at')->useCurrent(); // وقت البيع
            $table->boolean('is_returned')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
