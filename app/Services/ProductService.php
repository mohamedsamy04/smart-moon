<?php

namespace App\Services;

use App\Actions\Products\CreateProductAction;
use App\Actions\Products\ShowProductAction;
use App\Actions\Products\UpdateProductAction;
use App\Actions\Products\DeleteProductAction;
use App\Actions\Products\ListProductsAction;
use App\Actions\Products\ListProductsByCategoryAction;
use App\Actions\Products\UpdateProductImagesAction;
use App\Actions\Products\CreateProductImagesAction;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ProductService
{
    public function __construct(
        protected CreateProductAction $createProductAction,
        protected ShowProductAction $showProductAction,
        protected UpdateProductAction $updateProductAction,
        protected DeleteProductAction $deleteProductAction,
        protected ListProductsAction $listProductsAction,
        protected ListProductsByCategoryAction $listProductsByCategoryAction,
        protected UpdateProductImagesAction $updateProductImagesAction,
        protected CreateProductImagesAction $createProductImagesAction,

    ) {
        //
    }

    /**
     * Get products by category.
     */
    public function getProductsByCategory(int $categoryId, array $filters = [], int $perPage = 8): LengthAwarePaginator
    {
        return $this->listProductsByCategoryAction->execute($categoryId, $filters, $perPage);
    }


    public function createProduct(array $data, array $images = []): Product
{
    return DB::transaction(function () use ($data, $images) {
        // إنشاء المنتج الأساسي
        $product = $this->createProductAction->execute($data);

        // رفع الصور الجديدة فقط باستخدام CreateProductImagesAction
        if (!empty($images)) {
            $this->createProductImagesAction->execute($product->id, $images);
        }

        return $product->load('images');
    });
}


    public function updateProduct(int $productId, array $data, array $oldImages = [], array $newImages = []): Product
    {
        return DB::transaction(function () use ($productId, $data, $oldImages, $newImages) {
            $product = $this->updateProductAction->execute($productId, $data);

            // تحديث الصور
            $product = $this->updateProductImagesAction->execute($productId, $oldImages, $newImages);

            return $product;
        });
    }

    public function deleteProduct(int $productId): bool
    {
        return DB::transaction(function () use ($productId) {
            return $this->deleteProductAction->execute($productId);
        });
    }

    public function listProducts(array $filters = [], bool $withImages = true, int $perPage = 8): LengthAwarePaginator
    {
        return $this->listProductsAction->execute($filters, $withImages, $perPage);
    }


    public function getProduct(int $id): Product
    {
        return $this->showProductAction->execute($id);
    }
}
