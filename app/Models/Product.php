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
        'discount_type', 'discount_value', 'discount_start_at',
        'discount_end_at', 'is_discount_active',
    ];


    protected $casts = [
        'benefits' => 'array',
        'is_active' => 'boolean',
        'price' => 'integer',
        'stock' => 'integer',
        'discount_value' => 'integer',
        'discount_start_at' => 'datetime',
        'discount_end_at' => 'datetime',
        'is_discount_active' => 'boolean',
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

    public function getDiscountedPriceAttribute(): ?int
    {
        if (!$this->is_discount_active || !$this->discount_type || !$this->discount_value) {
            return null;
        }

        $now = now();
        if ($this->discount_start_at && $now->lt($this->discount_start_at)) {
            return null;
        }
        if ($this->discount_end_at && $now->gt($this->discount_end_at)) {
            return null;
        }

        if ($this->discount_type === 'percentage') {
            return (int) round($this->price * (100 - $this->discount_value) / 100);
        }

        if ($this->discount_type === 'fixed') {
            return max(0, $this->price - $this->discount_value);
        }

        return null;
    }

    public function getDiscountPercentageAttribute(): ?int
    {
        if (!$this->discounted_price) {
            return null;
        }

        return (int) round(($this->price - $this->discounted_price) / $this->price * 100);
    }

    public function getFormattedDiscountedPriceAttribute(): ?string
    {
        return $this->discounted_price
            ? 'Rp ' . number_format($this->discounted_price, 0, ',', '.')
            : null;
    }

    public function scopeDiscounted($query)
    {
        return $query->where('is_discount_active', true)
            ->where(function ($q) {
                $q->whereNull('discount_start_at')
                  ->orWhere('discount_start_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('discount_end_at')
                  ->orWhere('discount_end_at', '>=', now());
            });
    }

    public function scopeNotDiscounted($query)
    {
        return $query->where(function ($q) {
            $q->where('is_discount_active', false)
              ->orWhere('discount_start_at', '>', now())
              ->orWhere('discount_end_at', '<', now());
        });
    }

    public function getEffectivePriceAttribute(): int
    {
        return $this->discounted_price ?? $this->price;
    }

    public function getFormattedEffectivePriceAttribute(): string
    {
        return 'Rp ' . number_format($this->effective_price, 0, ',', '.');
    }


}
