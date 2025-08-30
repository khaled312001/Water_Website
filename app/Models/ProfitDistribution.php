<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'profit_id',
        'user_id',
        'user_type',
        'amount',
        'bank_account_id',
        'status',
        'transferred_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transferred_at' => 'datetime',
    ];

    // العلاقات
    public function profit()
    {
        return $this->belongsTo(Profit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    // Methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isTransferred()
    {
        return $this->status === 'transferred';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }

    public function isForAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isForDeliveryMan()
    {
        return $this->user_type === 'delivery_man';
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'في الانتظار',
            'transferred' => 'تم التحويل',
            'failed' => 'فشل',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getUserTypeTextAttribute()
    {
        $types = [
            'admin' => 'الإدارة',
            'delivery_man' => 'مندوب التوصيل',
        ];

        return $types[$this->user_type] ?? $this->user_type;
    }

    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2) . ' ريال';
    }
} 