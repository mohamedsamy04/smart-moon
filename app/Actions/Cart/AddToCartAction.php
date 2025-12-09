<?php

namespace App\Actions\Cart;

use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Models\Product;

class AddToCartAction
{
    public function __construct(
        protected CartRepositoryInterface $cartRepository
    ) {}

    public function execute(string $guestId, int $productId, int $quantity = 1 )
    {
        $product = Product::findOrFail($productId);

        // استخدام السعر النهائي (بعد الخصم) إذا كان موجوداً، وإلا السعر الأساسي
        $price = $product->final_price ?? $product->price;

        return $this->cartRepository
                    ->addItem($guestId, $productId, $quantity, $price);
    }
}
