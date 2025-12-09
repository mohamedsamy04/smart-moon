<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;


interface ProductRepositoryInterface
{
    public function create(array $data): Product;
    public function findAll(array $filters = [], bool $withImages = true, int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id): Product;
    public function update(int $id, array $data): Product;
    public function findByCategoryId(int $categoryId, array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function delete(int $id): bool;
    public function findBySlug(string $slug): Product;
    public function findByCategory(int $categoryId, array $filters = [], int $perPage = 15): LengthAwarePaginator;
}
