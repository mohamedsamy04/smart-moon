<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends BaseModel
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
