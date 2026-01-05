<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'game_id',
        'quantity'
    ];

    /**
     * Get the user that owns the cart item
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the game that owns the cart item
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Get the total price for this cart item
     */
    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->game->price;
    }
}
