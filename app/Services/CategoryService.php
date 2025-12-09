<?php

namespace App\Services;

use App\Actions\Categories\CreateCategoryAction;
use App\Actions\Categories\ShowCategoryAction;
use App\Actions\Categories\DeleteCategoryAction;
use App\Actions\Categories\UpdateCategoryAction;
use App\Actions\Categories\ListCategoriesAction;

class CategoryService
{

    public function __construct(
        protected CreateCategoryAction $createCategoryAction,
        protected ShowCategoryAction $showCategoryAction,
        protected DeleteCategoryAction $deleteCategoryAction,
        protected UpdateCategoryAction $updateCategoryAction,
        protected ListCategoriesAction $listCategoriesAction,
    ) {}

    public function create(array $data)
    {
        return $this->createCategoryAction->execute($data);
    }

    public function show(int $id)
    {
        return $this->showCategoryAction->execute($id);
    }

    public function delete(int $id)
    {
        return $this->deleteCategoryAction->execute($id);
    }

    public function update(int $id, array $data)
    {
        return $this->updateCategoryAction->execute($id, $data);
    }

    public function list(array $filters = [])
    {
        return $this->listCategoriesAction->execute($filters);
    }
}
