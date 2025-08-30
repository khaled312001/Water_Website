<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'supplier_id',
        'delivery_man_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
        'delivery_fee',
        'commission',
        'total_amount',
        'delivery_address',
        'delivery_city',
        'customer_phone',
        'customer_name',
        'notes',
        'status',
        'payment_status',
        'payment_method',
        'estimated_delivery_time',
        'actual_delivery_time',
        'delivery_lat',
        'delivery_lng',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'commission' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'delivery_lat' => 'decimal:8',
        'delivery_lng' => 'decimal:8',
        'estimated_delivery_time' => 'datetime',
        'actual_delivery_time' => 'datetime',
    ];

    // العلاقات
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function deliveryMan()
    {
        return $this->belongsTo(DeliveryMan::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isDelivered()
    {
        return $this->status === 'delivered';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_amount, 2) . ' ريال';
    }

    public function getFormattedSubtotalAttribute()
    {
        return number_format($this->subtotal, 2) . ' ريال';
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'في الانتظار',
            'confirmed' => 'مؤكد',
            'preparing' => 'قيد التحضير',
            'assigned' => 'تم التعيين',
            'picked_up' => 'تم الاستلام',
            'delivered' => 'تم التوصيل',
            'cancelled' => 'ملغي',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getPaymentStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'في الانتظار',
            'paid' => 'مدفوع',
            'failed' => 'فشل',
        ];

        return $statuses[$this->payment_status] ?? $this->payment_status;
    }
}
