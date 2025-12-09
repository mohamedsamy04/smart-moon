<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends BaseModel
{
    protected $fillable = ['guest_id', 'ip', 'user_agent'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'guest_id', 'guest_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'guest_id', 'guest_id');
    }
}
