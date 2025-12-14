<?php

namespace App\Actions\Companies;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Models\Company;
use Illuminate\Support\Str;


class CreateCompanyAction
{

    public function __construct(
        protected CompanyRepositoryInterface $companyRepository
    ) {
        //
    }

    public function execute(array $data): Company
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // معالجة الصورة إن وجدت
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $image = $data['image'];
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('companies', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        return $this->companyRepository->create($data);
    }
}
