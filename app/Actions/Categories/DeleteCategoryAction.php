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
    ) {
        //
    }

    public function execute(int $id): bool
    {
        // الحصول على الفئة أولاً لحذف الصورة
        $category = $this->categoryRepository->findById($id);

        if ($category && $category->image) {
            // حذف الصورة من التخزين
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($category->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($category->image);
            }
        }

        return $this->categoryRepository->delete($id);
    }
}
