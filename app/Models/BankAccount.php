<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'iban',
        'account_holder_name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profitDistributions()
    {
        return $this->hasMany(ProfitDistribution::class);
    }

    // Methods
    public function isActive()
    {
        return $this->is_active;
    }

    public function getFormattedAccountNumberAttribute()
    {
        return substr($this->account_number, 0, 4) . '****' . substr($this->account_number, -4);
    }
} 