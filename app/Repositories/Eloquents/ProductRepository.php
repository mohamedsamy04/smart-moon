<?php

namespace App\Repositories\Eloquents;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;


class ProductRepository implements ProductRepositoryInterface
{
    public function create(array $data): Product
    {
        return Product::create($data);
    }



    public function findAll(array $filters = [], bool $withImages = true, int $perPage = 8): LengthAwarePaginator
    {
        $query = Product::query();
        if ($withImages) {
            $query = $query->with('images');
        }


        // search
        if (!empty($filters['search'])) {
            $query->where('name', 'like', "%{$filters['search']}%");
        }

        // featured products
        if (isset($filters['featured'])) {
            $query->where('is_featured', (bool)$filters['featured']);
        }

        // price range
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        // Sorting
        if (!empty($filters['sort']) && $filters['sort'] === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif (!empty($filters['sort']) && $filters['sort'] === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('created_at', 'desc'); // default
        }

        return $query->paginate($perPage);
    }

    public function findById(int $id): Product
    {

        $product = Product::find($id);
        if (!$product) {
            throw new \Exception('Product not found');
        }
        return $product;
    }

    public function update(int $id, array $data): Product
    {
        $product = Product::find($id);
        if (!$product) {
            throw new \Exception('Product not found');
        }

        $product->update($data);
        return $product;
    }

    public function delete(int $id): bool
    {
        $product = Product::with('images')->find($id);
        if (!$product) {
            throw new \Exception('Product not found');
        }

        // حذف الصور من storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        return $product->delete();
    }

    public function findBySlug(string $slug): Product
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            throw new \Exception('Product not found');
        }
        return $product;
    }


    public function findByCategory(int $categoryId, array $filters = [], int $perPage = 8): LengthAwarePaginator
    {
        $query = Product::where('category_id', $categoryId);

        if (!empty($filters['search'])) {
            $query->where('name', 'like', "%{$filters['search']}%");
        }

        if (isset($filters['featured'])) {
            $query->where('is_featured', (bool)$filters['featured']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        if (!empty($filters['sort']) && $filters['sort'] === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif (!empty($filters['sort']) && $filters['sort'] === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($perPage);
    }

    public function findByCategoryId(int $categoryId, array $filters = [], int $perPage = 8): LengthAwarePaginator
    {
        return $this->findByCategory($categoryId, $filters, $perPage);
    }
}
