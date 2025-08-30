<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'name',
        'description',
        'brand',
        'size',
        'quantity_per_box',
        'price_per_box',
        'price_per_bottle',
        'image',
        'barcode',
        'type',
        'status',
        'stock_quantity',
        'rating',
        'total_sales',
        'is_featured',
    ];

    protected $casts = [
        'price_per_box' => 'decimal:2',
        'price_per_bottle' => 'decimal:2',
        'stock_quantity' => 'integer',
        'quantity_per_box' => 'integer',
        'rating' => 'decimal:2',
        'total_sales' => 'integer',
        'is_featured' => 'boolean',
    ];

    // العلاقات
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
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
        return $this->status === 'available' && $this->stock_quantity > 0;
    }

    public function isOutOfStock()
    {
        return $this->stock_quantity <= 0;
    }

    public function isFeatured()
    {
        return $this->is_featured;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price_per_box, 2) . ' ريال';
    }

    public function getFormattedBottlePriceAttribute()
    {
        return number_format($this->price_per_bottle, 2) . ' ريال';
    }
}
