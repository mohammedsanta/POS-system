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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable();   // رقم الفاتورة لو موجود
            $table->string('supplier_name')->nullable();    // اسم المورد (اختياري نص)
            $table->decimal('total',12,2);                  // إجمالي الفاتورة
            $table->text('notes')->nullable();              // ملاحظات
            $table->timestamp('purchased_at')->useCurrent();// تاريخ الشراء
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
