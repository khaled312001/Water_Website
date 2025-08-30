<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'supplier_price',
        'customer_price',
        'profit_margin',
        'admin_commission',
        'delivery_commission',
        'status',
        'distributed_at',
    ];

    protected $casts = [
        'supplier_price' => 'decimal:2',
        'customer_price' => 'decimal:2',
        'profit_margin' => 'decimal:2',
        'admin_commission' => 'decimal:2',
        'delivery_commission' => 'decimal:2',
        'distributed_at' => 'datetime',
    ];

    // العلاقات
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function distributions()
    {
        return $this->hasMany(ProfitDistribution::class);
    }

    // Methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isDistributed()
    {
        return $this->status === 'distributed';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'في الانتظار',
            'distributed' => 'تم التوزيع',
            'cancelled' => 'ملغي',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getFormattedSupplierPriceAttribute()
    {
        return number_format($this->supplier_price, 2) . ' ريال';
    }

    public function getFormattedCustomerPriceAttribute()
    {
        return number_format($this->customer_price, 2) . ' ريال';
    }

    public function getFormattedProfitMarginAttribute()
    {
        return number_format($this->profit_margin, 2) . ' ريال';
    }

    public function getFormattedAdminCommissionAttribute()
    {
        return number_format($this->admin_commission, 2) . ' ريال';
    }

    public function getFormattedDeliveryCommissionAttribute()
    {
        return number_format($this->delivery_commission, 2) . ' ريال';
    }

    // Static methods for calculations
    public static function calculateProfitMargin($supplierPrice)
    {
        return $supplierPrice * 0.20; // 20% هامش ربح
    }

    public static function calculateCustomerPrice($supplierPrice)
    {
        return $supplierPrice + self::calculateProfitMargin($supplierPrice);
    }

    public static function calculateAdminCommission($profitMargin)
    {
        return $profitMargin * 0.60; // 60% للإدارة
    }

    public static function calculateDeliveryCommission($profitMargin)
    {
        return $profitMargin * 0.40; // 40% لمندوب التوصيل
    }
} 