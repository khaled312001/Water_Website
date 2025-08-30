<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'address',
        'city',
        'profile_image',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // العلاقات
    public function supplier()
    {
        return $this->hasOne(Supplier::class);
    }

    public function deliveryMan()
    {
        return $this->hasOne(DeliveryMan::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function profitDistributions()
    {
        return $this->hasMany(ProfitDistribution::class);
    }

    // Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSupplier()
    {
        return $this->role === 'supplier';
    }

    public function isDeliveryMan()
    {
        return $this->role === 'delivery';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }
}
