<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryMan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'national_id',
        'vehicle_type',
        'vehicle_number',
        'license_number',
        'emergency_contact',
        'emergency_phone',
        'address',
        'city',
        'profile_image',
        'status',
        'rating',
        'total_deliveries',
        'total_earnings',
        'current_lat',
        'current_lng',
        'last_active',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'total_deliveries' => 'integer',
        'total_earnings' => 'decimal:2',
        'current_lat' => 'decimal:8',
        'current_lng' => 'decimal:8',
        'last_active' => 'datetime',
    ];

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Methods
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    public function isBusy()
    {
        return $this->status === 'busy';
    }

    public function isOffline()
    {
        return $this->status === 'offline';
    }

    public function updateLocation($lat, $lng)
    {
        $this->update([
            'current_lat' => $lat,
            'current_lng' => $lng,
            'last_active' => now(),
        ]);
    }
}
