<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends BaseModel
{
    protected $fillable = [
        'product_id',
        'image_path',
    ];

    protected $appends = [
        'image_url',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the full URL for the image
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return null;
        }

        // إذا كان المسار يبدأ بـ http/https (يعني URL كامل من R2 مثلاً)
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        // إذا كان مسار محلي، نرجع الـ URL الكامل
        return Storage::url($this->image_path);
    }
}
