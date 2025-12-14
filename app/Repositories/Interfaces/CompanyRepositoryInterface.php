<?php

namespace App\Repositories\Interfaces;

use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;

interface CompanyRepositoryInterface
{
    public function create(array $data): Company;
    public function update(int $id, array $data): ?Company;
    public function delete(int $id): bool;
    public function findById(int $id): ?Company;
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator;
}
