<?php

namespace App\Actions\Cart;

use App\Repositories\Interfaces\CartRepositoryInterface;

class RemoveFromCartAction
{
    public function __construct(
        protected CartRepositoryInterface $cartRepository
    ) {}

    public function execute(string $guestId, int $itemId)
    {
        return $this->cartRepository->deleteItem($guestId, $itemId);
    }
}

