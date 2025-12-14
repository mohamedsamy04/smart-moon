<?php

namespace App\Actions\Companies;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Models\Company;

class ShowCompanyAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CompanyRepositoryInterface $companyRepository
    ) {
        //
    }

    public function execute(int $id): ?Company
    {
        return $this->companyRepository->findById($id);
    }
}
