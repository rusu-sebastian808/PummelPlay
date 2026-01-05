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

    /**
     * Get the order items for this game
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the cart items for this game
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the wishlist items for this game
     */
    public function wishlistItems()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get the reviews for this game
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the average rating for this game
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    /**
     * Get the count of reviews for this game
     */
    public function reviewCount()
    {
        return $this->reviews()->count();
    }
}
