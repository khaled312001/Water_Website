<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // تحديث enum payment_method لإضافة القيم الجديدة
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('cash', 'bank_transfer', 'visa', 'card', 'online') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إعادة القيم الأصلية
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('cash', 'card', 'online') DEFAULT 'cash'");
    }
};
