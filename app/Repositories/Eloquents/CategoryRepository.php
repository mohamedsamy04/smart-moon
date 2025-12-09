<?php

namespace App\Repositories\Eloquents;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;


class CategoryRepository implements CategoryRepositoryInterface
{
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function findAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Category::query()
            ->when(
                $filters['search'] ?? null,
                fn($query, $search) =>
                $query->where('name', 'like', "%$search%")
                    ->orWhere('slug', 'like', "%$search%")
            )
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function findById(int $id): ?Category
    {
        return Category::find($id);
    }

    public function update(int $id, array $data): Category
    {
        $category = $this->findById($id);
        if (!$category) {
            throw new \Exception("Category not found");
        }

        $category->update($data);
        return $category;
    }

    public function delete(int $id): bool
    {
        $category = $this->findById($id);
        if (!$category) {
            return false;
        }
        return $category->delete();
    }

    public function findBySlug(string $slug): ?Category
    {
        return Category::where('slug', $slug)->firstOrFail();
    }

}
