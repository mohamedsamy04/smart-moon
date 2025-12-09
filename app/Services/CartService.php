<?php

namespace App\Services;

use App\Actions\Cart\AddToCartAction;
use App\Actions\Cart\RemoveFromCartAction;
use App\Actions\Cart\UpdateCartQuantityAction;
use App\Actions\Cart\GetCartAction;

class CartService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AddToCartAction $addToCartAction,
        protected RemoveFromCartAction $removeFromCartAction,
        protected UpdateCartQuantityAction $updateCartQuantityAction,
        protected GetCartAction $getCartAction
    ) {
    }

    public function addToCart(string $guestId, int $productId, int $quantity = 1)
    {
        return $this->addToCartAction->execute($guestId, $productId, $quantity);
    }

    public function removeFromCart(string $guestId, int $itemId)
    {
        return $this->removeFromCartAction->execute($guestId, $itemId);
    }

    public function updateCartQuantity(string $guestId, int $itemId, int $quantity)
    {
        return $this->updateCartQuantityAction->execute($guestId, $itemId, $quantity);
    }

    public function getCart(string $guestId)
    {
        return $this->getCartAction->execute($guestId);
    }
}
