<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends BaseModel
{
    protected $fillable = [
        'guest_id',
        'name',
        'phone',
        'city',
        'address',
        'notes',
        'status',
        'payment_method',
        'total_price',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id', 'guest_id');
    }

    public function getTotalPriceAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    public function getFormattedTotalPriceAttribute()
    {
        return number_format($this->getOriginal('total_price') ?? 0, 2) . ' EGP';
    }
}
