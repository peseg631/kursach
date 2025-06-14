<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id'
    ];
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('name', 'like', "%{$term}%");
    }

    public function scopeByCategory($query, int $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSortByPrice($query, string $direction = 'asc')
    {
        return $query->orderBy('price', $direction);
    }
}
