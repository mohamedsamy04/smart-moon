<?php

namespace App\Actions\Products;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class DeleteProductAction
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {
        //
    }

    /**
     * Execute the action.
     */
    public function execute(int $productId): bool
    {
        // 1️⃣ جلب المنتج مع الصور
        $product = $this->productRepository->findById($productId)->load('images');

        // 2️⃣ حذف كل الصور من storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // 3️⃣ حذف السجل من DB عبر الـ repository
        return $this->productRepository->delete($productId);
    }
}
