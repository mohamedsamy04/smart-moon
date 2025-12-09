<?php

namespace App\Services;

use App\Actions\Orders\CartCheckoutAction;

class CartCheckoutService
{
    public function __construct(protected CartCheckoutAction $action)
    {
    }

    public function checkout(string $guestId, array $orderData)
    {
        return $this->action->execute($guestId, $orderData);
    }
}
