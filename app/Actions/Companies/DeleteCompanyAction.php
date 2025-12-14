<?php

namespace App\Actions\Companies;

use App\Repositories\Interfaces\CompanyRepositoryInterface;


class DeleteCompanyAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CompanyRepositoryInterface $companyRepository
    ) {
        //
    }

    public function execute(int $id): bool
    {
        // الحصول على الشركة أولاً لحذف الصورة
        $company = $this->companyRepository->findById($id);

        if ($company && $company->image) {
            // حذف الصورة من التخزين
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($company->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($company->image);
            }
        }

        return $this->companyRepository->delete($id);
    }
}
