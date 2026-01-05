<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'status'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2'
    ];

    /**
     * Get the user that owns the order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items for this order
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the games in this order through order items
     */
    public function games()
    {
        return $this->hasManyThrough(Game::class, OrderItem::class, 'order_id', 'id', 'id', 'game_id');
    }
}
