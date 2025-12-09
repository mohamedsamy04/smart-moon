<?php

namespace App\Repositories\Eloquents;

use App\Models\CartItem;
use App\Repositories\Interfaces\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function getByGuestId(string $guestId)
    {
        return CartItem::query()->where('guest_id', $guestId)->get();
    }

    public function findItem(string $guestId, int $id)
    {
        return CartItem::where('guest_id', $guestId)
            ->where('id', $id)
            ->first();
    }

    public function findItemByProductId(string $guestId, int $productId)
    {
        return CartItem::where('guest_id', $guestId)
            ->where('product_id', $productId)
            ->first();
    }


    public function addItem(string $guestId, int $productId, int $quantity, float $price)
    {
        $item = CartItem::where('guest_id', $guestId)
            ->where('product_id', $productId)
            ->first();

        if ($item) {
            $item->quantity += $quantity;
            $item->total_price = $item->quantity * $price;
            $item->save();
            return $item;
        }

        $item = CartItem::create([
            'guest_id' => $guestId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $price,
            'total_price' => $quantity * $price,
        ]);

        return $item;
    }
    public function updateQuantity(string $guestId, int $itemId, int $quantity)
    {
        $item = $this->findItem($guestId, $itemId);

        if (!$item) {
            return null;
        }

        $item->quantity = $quantity;
        $item->total_price = $item->quantity * $item->price;
        $item->save();

        return $item;
    }
    public function deleteItem(string $guestId, int $id)
    {
        $item = $this->findItem($guestId, $id);
        if ($item) {
            $item->delete();
        }
    }
}
