<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;


class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }


    public function index(Request $request): JsonResponse
    {
        $categoryId = $request->input('category_id');
        $filters = $request->only(['search', 'min_price', 'max_price']);
        $perPage = (int) $request->input('per_page', 15);

        $guestId = $request->guest_id;
        if ($categoryId) {
            $products = $this->productService->getProductsByCategory($categoryId, $filters, $perPage);
        } else {
            $products = $this->productService->listProducts($filters, true, $perPage);
        }

        return response()->json([
            'guest_id' => $guestId,
            'products' => $products
        ]);
    }


    public function show(Request $request, $id): JsonResponse
    {
        $guestId = $request->guest_id;
        $product = $this->productService->getProduct($id)->load('images', 'category');
        return response()->json([
            'guest_id' => $guestId,
            'product' => $product
        ]);
    }



    public function store(StoreProductRequest $request)
    {
        $data = $request->only(['name', 'description', 'price', 'category_id', 'slug', 'is_featured', 'main_features', 'discount_percentage']);
        $images = $request->file('images', []);

        $product = $this->productService->createProduct($data, $images);

        return response()->json($product->load('images'), 201);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->productService->deleteProduct($id);
        return response()->json(['message' => 'Product deleted']);
    }


    public function update(UpdateProductRequest $request, $id)
    {
        $data = $request->only(['name', 'description', 'price', 'category_id', 'slug', 'is_featured', 'main_features']);
        $oldImages = $request->input('old_images', []);
        $newImages = $request->file('new_images', []);

        $product = $this->productService->updateProduct($id, $data, $oldImages, $newImages);

        return response()->json($product->load('images'), 200);
    }
}
