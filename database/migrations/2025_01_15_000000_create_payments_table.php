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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->enum('payment_method', ['visa', 'bank_transfer', 'cash'])->default('cash');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'failed', 'verified'])->default('pending');
            $table->string('transaction_id')->nullable();
            $table->string('receipt_image')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('profits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->decimal('supplier_price', 10, 2); // سعر المورد الأصلي
            $table->decimal('customer_price', 10, 2); // سعر العميل (سعر المورد + 20%)
            $table->decimal('profit_margin', 10, 2); // هامش الربح (20%)
            $table->decimal('admin_commission', 10, 2); // عمولة الإدارة (60% من هامش الربح)
            $table->decimal('delivery_commission', 10, 2); // عمولة التوصيل (40% من هامش الربح)
            $table->enum('status', ['pending', 'distributed', 'cancelled'])->default('pending');
            $table->timestamp('distributed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('iban')->nullable();
            $table->string('account_holder_name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('profit_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profit_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('user_type', ['admin', 'delivery_man']);
            $table->decimal('amount', 10, 2);
            $table->foreignId('bank_account_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('status', ['pending', 'transferred', 'failed'])->default('pending');
            $table->timestamp('transferred_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profit_distributions');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('profits');
        Schema::dropIfExists('payments');
    }
}; 