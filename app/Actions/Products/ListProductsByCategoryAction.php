<?php

namespace App\Actions\Products;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ListProductsByCategoryAction
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {
        //
    }


    public function execute(int $categoryId, array $filters = [], int $perPage = 8): LengthAwarePaginator
    {
        return $this->productRepository->findByCategoryId($categoryId, $filters, $perPage);
    }
}
