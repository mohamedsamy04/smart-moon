<?php

namespace App\Actions\Products;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class CreateProductAction
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {
        //
    }


    public function execute(array $data): Product
    {
        if (!empty($data['discount_percentage']) && $data['discount_percentage'] > 0) {
            $discount = ($data['price'] * $data['discount_percentage']) / 100;
            $data['final_price'] = $data['price'] - $discount;
        } else {
            $data['final_price'] = $data['price'];
        }

        $product = $this->productRepository->create($data);

        return $this->productRepository->findById($product->id)->load('images');
    }
}
