<?php

namespace App\Actions\Categories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;


class ShowCategoryAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    )
    {
        //
    }

    public function execute(int $id): ?Category
    {
        return $this->categoryRepository->findById($id);
    }
}
