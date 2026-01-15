<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'genre',
        'image'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

   
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlistItems()
    {
        return $this->hasMany(Wishlist::class);
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

   
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

   
    public function reviewCount()
    {
        return $this->reviews()->count();
    }
}
