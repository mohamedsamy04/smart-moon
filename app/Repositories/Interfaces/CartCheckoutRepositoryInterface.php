<?php

namespace App\Repositories\Interfaces;

interface CartCheckoutRepositoryInterface
{
    public function getCartItemsByGuestId(string $guestId);
    public function createOrder(array $orderData);
    public function createOrderItems(int $orderId, $items);
    public function clearCart(string $guestId);
}
