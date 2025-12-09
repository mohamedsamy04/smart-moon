<?php

namespace App\Actions\Cart;

use App\Repositories\Interfaces\CartRepositoryInterface;

class UpdateCartQuantityAction
{
    public function __construct(
        protected CartRepositoryInterface $cartRepository
    ) {}

    public function execute(string $guestId, int $itemId, int $quantity)
    {
        $updatedItem = $this->cartRepository->updateQuantity($guestId, $itemId, $quantity);

        if (!$updatedItem) {
            return [
                'message' => 'Item not found in cart',
                'item' => null,
            ];
        }

        $updatedItem->total_price = $updatedItem->quantity * ($updatedItem->product->price ?? 0);

        return [
            'message' => 'Item updated in cart',
            'item' => $updatedItem,
        ];
    }

}
