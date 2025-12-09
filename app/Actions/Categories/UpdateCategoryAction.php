<?php

namespace App\Actions\Categories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class UpdateCategoryAction
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

    public function execute(int $id, array $data): ?Category
    {
        return $this->categoryRepository->update($id, $data);
    }
}
