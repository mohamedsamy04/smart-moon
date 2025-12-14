<?php

namespace App\Services;

use App\Actions\Companies\CreateCompanyAction;
use App\Actions\Companies\ShowCompanyAction;
use App\Actions\Companies\DeleteCompanyAction;
use App\Actions\Companies\UpdateCompanyAction;
use App\Actions\Companies\ListCompaniesAction;

class CompanyService
{

    public function __construct(
        protected CreateCompanyAction $createCompanyAction,
        protected ShowCompanyAction $showCompanyAction,
        protected DeleteCompanyAction $deleteCompanyAction,
        protected UpdateCompanyAction $updateCompanyAction,
        protected ListCompaniesAction $listCompaniesAction,
    ) {}

    public function create(array $data)
    {
        return $this->createCompanyAction->execute($data);
    }

    public function show(int $id)
    {
        return $this->showCompanyAction->execute($id);
    }

    public function delete(int $id)
    {
        return $this->deleteCompanyAction->execute($id);
    }

    public function update(int $id, array $data)
    {
        return $this->updateCompanyAction->execute($id, $data);
    }

    public function list(array $filters = [])
    {
        return $this->listCompaniesAction->execute($filters);
    }
}
