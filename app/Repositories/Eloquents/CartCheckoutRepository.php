<?php

namespace App\Repositories\Eloquents;

use App\Models\CartItem;
use App\Models\Order;
use App\Repositories\Interfaces\CartCheckoutRepositoryInterface;

class CartCheckoutRepository implements CartCheckoutRepositoryInterface
{
    public function getCartItemsByGuestId(string $guestId)
    {
        return CartItem::with('product')->where('guest_id', $guestId)->get();
    }

    public function createOrder(array $orderData)
    {
        return Order::create($orderData);
    }

    public function createOrderItems(int $orderId, $items)
    {
        $order = Order::findOrFail($orderId);
        foreach ($items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total_price' =>  $item->price * $item->quantity,
            ]);
        }
    }

    public function clearCart(string $guestId)
    {
        CartItem::where('guest_id', $guestId)->delete();
    }
}
