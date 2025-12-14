<?php

namespace App\Actions\Companies;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Models\Company;

class UpdateCompanyAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CompanyRepositoryInterface $companyRepository
    ) {
        //
    }

    public function execute(int $id, array $data): ?Company
    {
        $company = $this->companyRepository->findById($id);

        if (!$company) {
            return null;
        }

        // معالجة الصورة الجديدة إن وجدت
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            // حذف الصورة القديمة إن وجدت
            if ($company->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($company->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($company->image);
            }

            // رفع الصورة الجديدة
            $image = $data['image'];
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('companies', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        return $this->companyRepository->update($id, $data);
    }
}
