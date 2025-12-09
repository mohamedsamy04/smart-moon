<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;



class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $category_service
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search']);
        $perPage = $request->get('perPage', 15);

        $guestId = $request->guest_id;

        $categories = $this->category_service->list($filters, $perPage);
        return response()->json([
            'guest_id' => $guestId,
            'categories' => $categories]);
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $data = $request->validated();
        $category = $this->category_service->create($data);

        return response()->json(['message' => 'Category created successfully', 'category' => $category], 201);
    }



    public function show(Request $request, int $id): JsonResponse
    {
        $category = $this->category_service->show($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $guestId = $request->guest_id;
        return response()->json([
            'guest_id' => $guestId,
            'category' => $category]);
    }

    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $category = $this->category_service->update($id, $data);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return response()->json(['message' => 'Category updated successfully', 'category' => $category]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->category_service->delete($id);
        if (!$deleted) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
