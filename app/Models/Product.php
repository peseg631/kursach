<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Favorite;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'image', 'category_id',];

    public function favoritedBy()
    {
        return $this->hasMany(Favorite::class);
    }
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
}
