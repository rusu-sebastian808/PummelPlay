<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'game_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    /**
     * Get the order that owns the order item
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the game that owns the order item
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Get the total price for this line item
     */
    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->price;
    }
}
