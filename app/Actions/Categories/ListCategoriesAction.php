<?php

namespace App\Actions\Categories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ListCategoriesAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    )
    {

    }

    public function execute(array $filters = [], int $perPage = 8): LengthAwarePaginator
    {
        return $this->categoryRepository->findAll($filters, $perPage);
    }
}
