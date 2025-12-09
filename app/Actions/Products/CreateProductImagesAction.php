<?php

namespace App\Actions\Products;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class CreateProductImagesAction
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * رفع وربط الصور بالمنتج الجديد
     *
     * @param int $productId
     * @param array $images الملفات الجديدة
     * @return Product
     */
    public function execute(int $productId, array $images = []): Product
    {
        $product = $this->productRepository->findById($productId);

        foreach ($images as $imageFile) {
            $path = $imageFile->store('products', 'public');
            $product->images()->create(['image_path' => $path]);
        }

        return $product->load('images', 'category');
    }
}
