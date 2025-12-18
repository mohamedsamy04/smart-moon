<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function create(array $data): Category;
    public function findAll(array $filters = [], int $perPage = 8): LengthAwarePaginator;
    public function findById(int $id): ?Category;
    public function update(int $id, array $data): ?Category;
    public function delete(int $id): bool;
    public function findBySlug(string $slug): ?Category;
}
