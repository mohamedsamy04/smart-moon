<?php

namespace App\Services;

use App\Actions\Orders\DirectCheckoutAction;
use App\Repositories\Interfaces\DirectCheckoutRepositoryInterface;

class DirectCheckoutService
{
    public function __construct(
        protected DirectCheckoutAction $action,
        protected DirectCheckoutRepositoryInterface $repo
    ) {
    }

    public function checkout(array $orderData, array $itemData)
    {
        return $this->action->execute($orderData, $itemData);
    }

    public function getProductPrice(int $productId): float
    {
        $product = $this->repo->getProductById($productId);
        
        // استخدام السعر النهائي (بعد الخصم) إذا كان موجوداً، وإلا السعر الأساسي
        return $product->final_price ?? $product->price;
    }
}
