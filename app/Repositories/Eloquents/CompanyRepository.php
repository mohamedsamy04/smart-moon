<?php

namespace App\Repositories\Eloquents;

use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function create(array $data): Company
    {
        return Company::create($data);
    }

    public function update(int $id, array $data): ?Company
    {
        $company = $this->findById($id);
        if ($company) {
            $company->update($data);
            return $company;
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $company = $this->findById($id);
        if ($company) {
            return $company->delete();
        }
        return false;
    }

    public function findById(int $id): ?Company
    {
        return Company::find($id);
    }

    public function list(array $filters = [], int $perPage = 8): LengthAwarePaginator
    {
        $query = Company::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }
}
