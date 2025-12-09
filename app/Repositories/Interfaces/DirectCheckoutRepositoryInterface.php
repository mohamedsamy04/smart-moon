<?php

namespace App\Repositories\Interfaces;

interface DirectCheckoutRepositoryInterface
{
    public function createOrder(array $data);
    public function createOrderItem(int $orderId, array $itemData);
    public function getProductById(int $productId);
}
