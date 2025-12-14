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
    ) {
        //
    }

    public function execute(int $id, array $data): ?Category
    {
        $category = $this->categoryRepository->findById($id);

        if (!$category) {
            return null;
        }

        // معالجة الصورة الجديدة إن وجدت
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            // حذف الصورة القديمة إن وجدت
            if ($category->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($category->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($category->image);
            }

            // رفع الصورة الجديدة
            $image = $data['image'];
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('categories', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        return $this->categoryRepository->update($id, $data);
    }
}
