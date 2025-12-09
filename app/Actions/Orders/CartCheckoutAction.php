<?php

namespace App\Actions\Orders;

use App\Repositories\Interfaces\CartCheckoutRepositoryInterface;

class CartCheckoutAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CartCheckoutRepositoryInterface $repo
    ) {
    }

    public function execute(string $guestId, array $orderData)
    {
        $cartItems = $this->repo->getCartItemsByGuestId($guestId);

        if ($cartItems->isEmpty()) {
            throw new \Exception('Cart is empty');
        }

        // حساب الـ total price من الـ cart items
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // إضافة الـ total price للـ order data
        $orderData['total_price'] = $totalPrice;

        // إنشاء الأوردر
        $order = $this->repo->createOrder($orderData);

        // إنشاء الـ order items
        $this->repo->createOrderItems($order->id, $cartItems);

        // مسح الـ cart
        $this->repo->clearCart($guestId);

        return $order->load('items');
    }
}
