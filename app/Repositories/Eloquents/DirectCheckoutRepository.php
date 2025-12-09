<?php

namespace App\Repositories\Eloquents;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Repositories\Interfaces\DirectCheckoutRepositoryInterface;

class DirectCheckoutRepository implements DirectCheckoutRepositoryInterface
{
    public function createOrder(array $data)
    {
        return Order::create($data);
    }

    public function createOrderItem(int $orderId, array $itemData)
    {
        $order = Order::findOrFail($orderId);
        return $order->items()->create($itemData);
    }

    public function getProductById(int $productId)
    {
        return Product::findOrFail($productId);
    }
}

