<?php

namespace App\Actions\Orders;

use App\Repositories\Interfaces\AdminOrderRepositoryInterface;

class DeleteOrderAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AdminOrderRepositoryInterface $repo
    )
    {
        //
    }

    public function execute(int $orderId)
    {
        return $this->repo->deleteOrder($orderId);
    }
}
