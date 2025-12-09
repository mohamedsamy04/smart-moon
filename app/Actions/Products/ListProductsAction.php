<?php

namespace App\Actions\Products;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ListProductsAction
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {
        //
    }

    /**
     * Execute the action.
     */
    public function execute(array $filters = [], bool $withImages = true, int $perPage = 15): LengthAwarePaginator
    {
        return $this->productRepository->findAll($filters, $withImages, $perPage);
    }
}
