<?php

namespace App\Actions\Products;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ShowProductAction
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {
        //
    }

    /**
     * Execute the action.
     */
    public function execute(int $id): Product
    {
        return $this->productRepository->findById($id);
    }
}
