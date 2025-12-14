<?php

namespace App\Actions\Products;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class UpdateProductAction
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function execute(int $productId, array $data): Product
    {
        $product = $this->productRepository->findById($productId);

        $price = $data['price'] ?? $product->price;

        $discount = $data['discount_percentage'] ?? $product->discount_percentage;

        if (!empty($discount) && $discount > 0) {
            $finalPrice = $price - (($price * $discount) / 100);
        } else {
            $finalPrice = $price;
        }

        $product->update([
            'name' => $data['name'] ?? $product->name,
            'description' => $data['description'] ?? $product->description,
            'price' => $price,
            'discount_percentage' => $discount,
            'final_price' => $finalPrice,
            'category_id' => $data['category_id'] ?? $product->category_id,
            'slug' => $data['slug'] ?? $product->slug,
            'is_featured' => $data['is_featured'] ?? $product->is_featured,
            'main_features' => $data['main_features'] ?? $product->main_features,
        ]);

        return $this->productRepository->findById($product->id)->load('images');
    }
}
