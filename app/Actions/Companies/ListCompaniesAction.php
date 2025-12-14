<?php

namespace App\Actions\Companies;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ListCompaniesAction
{
    public function __construct(
        protected CompanyRepositoryInterface $companyRepository
    ) {
        //
    }

    public function execute(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->companyRepository->list($filters, $perPage);
    }
}
