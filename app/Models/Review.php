<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'customer_name',
        'rating', 'comment', 'admin_reply', 'is_visible',
    ];

    protected $casts = [
        'rating'     => 'integer',
        'is_visible' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /** Returns filled star HTML string */
    public function getStarsHtmlAttribute(): string
    {
        $filled = str_repeat('★', $this->rating);
        $empty  = str_repeat('☆', 5 - $this->rating);
        return $filled . $empty;
    }
}
