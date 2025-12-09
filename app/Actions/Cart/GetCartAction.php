<?php

namespace App\Actions\Cart;

use App\Repositories\Interfaces\CartRepositoryInterface;

class GetCartAction
{
    public function __construct(
        protected CartRepositoryInterface $cartRepository
    ) {}

    public function execute(string $guestId)
{
    $cart = $this->cartRepository->getByGuestId($guestId)
                ->load('product'); // eager load المنتج لكل عنصر

    $cart->each(function ($item) {
        $item->total_price = $item->quantity * ($item->product->price ?? 0);
    });

    return $cart;
}

}
