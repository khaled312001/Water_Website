<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'amount',
        'status',
        'transaction_id',
        'receipt_image',
        'notes',
        'paid_at',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    // العلاقات
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isVerified()
    {
        return $this->status === 'verified';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'في الانتظار',
            'paid' => 'مدفوع',
            'verified' => 'مؤكد',
            'failed' => 'فشل',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getPaymentMethodTextAttribute()
    {
        $methods = [
            'visa' => 'فيزا',
            'bank_transfer' => 'تحويل بنكي',
            'cash' => 'نقداً',
        ];

        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2) . ' ريال';
    }
} 