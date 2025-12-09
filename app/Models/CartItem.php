<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends BaseModel
{
    protected $fillable = ['guest_id', 'product_id', 'quantity' , 'price', 'total_price'];

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id', 'guest_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
