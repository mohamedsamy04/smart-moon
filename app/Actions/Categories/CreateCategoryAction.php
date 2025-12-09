<?php

namespace App\Actions\Categories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Str;


class CreateCategoryAction
{

    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {
        //
    }

    public function execute(array $data): Category
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        return $this->categoryRepository->create($data);
    }
}
