<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;



class CompanyController extends Controller
{
    public function __construct(
        protected CompanyService $company_service
    ) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search']);
        $perPage = $request->get('perPage', 15);

        $guestId = $request->attributes->get('guest_id');

        $companies = $this->company_service->list($filters, $perPage);
        return response()->json([
            'guest_id' => $guestId,
            'companies' => $companies
        ]);
    }

    public function store(StoreCompanyRequest $request): JsonResponse
    {
        $data = $request->validated();

        // إضافة الصورة إلى البيانات إن وجدت
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $company = $this->company_service->create($data);

        return response()->json(['message' => 'Company created successfully', 'company' => $company], 201);
    }



    public function show(Request $request, int $id): JsonResponse
    {
        $company = $this->company_service->show($id);
        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }
        $guestId = $request->attributes->get('guest_id');
        return response()->json([
            'guest_id' => $guestId,
            'company' => $company
        ]);
    }

    public function update(UpdateCompanyRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        // إضافة الصورة إلى البيانات إن وجدت
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $company = $this->company_service->update($id, $data);
        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }
        return response()->json(['message' => 'Company updated successfully', 'company' => $company]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->company_service->delete($id);
        if (!$deleted) {
            return response()->json(['error' => 'Company not found'], 404);
        }
        return response()->json(['message' => 'Company deleted successfully']);
    }
}
