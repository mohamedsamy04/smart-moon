<?php

namespace App\Actions\Products;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class UpdateProductImagesAction
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {
        //
    }

    public function execute(int $productId, array $oldImages = [], array $newImages = []): Product
    {
        // جلب المنتج مع الصور
        $product = $this->productRepository->findById($productId)->load('images');

        // استخراج IDs من الصور القديمة
        // الـ Frontend ممكن يبعت URLs أو IDs
        $oldImageIds = collect($oldImages)->map(function ($item) use ($product) {
            // إذا كان رقم (ID)، نرجعه مباشرة
            if (is_numeric($item)) {
                return (int) $item;
            }
            
            // إذا كان URL، نحاول نستخرج الـ ID منه
            // نبحث عن الصورة اللي الـ URL بتاعها يطابق
            $matchingImage = $product->images->first(function ($image) use ($item) {
                return $image->image_url === $item || 
                       str_contains($item, $image->image_path);
            });
            
            return $matchingImage ? $matchingImage->id : null;
        })->filter()->toArray();

        // حذف الصور التي لم يعد موجودة في oldImages
        $imagesToDelete = $product->images->whereNotIn('id', $oldImageIds);
        foreach ($imagesToDelete as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // رفع الصور الجديدة
        foreach ($newImages as $imageFile) {
            $path = $imageFile->store('products', 'public');
            $product->images()->create(['image_path' => $path]);
        }

        return $product->load('images');
    }
}
