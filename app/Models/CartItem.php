<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo};

class CartItem extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    protected $casts = [
        'quantity' => 'integer'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalPriceAttribute(): float
    {
        return $this->product->price * $this->quantity;
    }
}
