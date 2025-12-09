<?php

namespace App\Actions\Categories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;


class DeleteCategoryAction
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

    public function execute(int $id): bool
    {
        return $this->categoryRepository->delete($id);
    }
}
