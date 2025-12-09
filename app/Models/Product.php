<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends BaseModel
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'category_id',
        'main_features',
        'is_featured',
        'slug',
        'final_price',
        'discount_percentage',
    ];

    protected static function boot()
{
    parent::boot();

    static::creating(function ($product) {
        if (empty($product->slug)) {
            $baseSlug = Str::slug($product->name);
            $slug = $baseSlug;
            $count = 1;

            // تأمين تكرار المنتجات بنفس الاسم
            while (self::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $product->slug = $slug;
        }
    });
}


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    protected $casts = [
        'main_features' => 'array',
        'is_featured' => 'boolean',
    ];
}
