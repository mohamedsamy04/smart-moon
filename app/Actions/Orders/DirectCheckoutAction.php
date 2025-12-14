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
    ) {}

    public function execute(array $orderData, array $itemData)
{
    // حساب السعر الإجمالي للعنصر
    $itemData['total_price'] = $itemData['price'] * $itemData['quantity'];

    // حساب السعر الإجمالي للطلب (ممكن يكون نفس قيمة العنصر لو عنصر واحد)
    $orderData['total_price'] = $itemData['total_price'];

    // إنشاء الطلب
    $order = $this->repo->createOrder($orderData);

    // إنشاء العنصر وربطه بالطلب
    $orderItem = $this->repo->createOrderItem($order->id, $itemData);

    return $order->load('items');
}

}
