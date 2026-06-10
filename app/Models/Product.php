<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{

    protected $fillable = [
        'name', 'slug', 'description', 'benefits', 'ingredients',
        'usage', 'price', 'stock', 'is_active',
    ];


    protected $casts = [
        'benefits' => 'array',
        'is_active' => 'boolean',
        'price' => 'integer',
        'stock' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasMany
    {
        return $this->hasMany(ProductImage::class)->where('is_primary', true);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function stockLogs(): HasMany
    {
        return $this->hasMany(StockLog::class);
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->images->where('is_primary', true)->first()
            ?? $this->images->first();
        return $primary ? asset('storage/' . $primary->image_path) : asset('images/placeholder.png');
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }


}
