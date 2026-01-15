<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

 
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }


    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
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
}
