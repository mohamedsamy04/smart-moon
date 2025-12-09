<?php

namespace App\Actions\Orders;

use App\Repositories\Interfaces\DirectCheckoutRepositoryInterface;

class DirectCheckoutAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected DirectCheckoutRepositoryInterface $repo
    ) {
    }

    public function execute(array $orderData, array $itemData)
    {
        $order = $this->repo->createOrder($orderData);
        $orderItem = $this->repo->createOrderItem($order->id, $itemData);
        
        // حساب السعر الإجمالي للطلب
        $totalPrice = $itemData['price'] * $itemData['quantity'];
        $order->update(['total_price' => $totalPrice]);

        return $order->load('items');
    }
}
