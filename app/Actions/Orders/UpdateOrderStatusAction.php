<?php

namespace App\Actions\Orders;

use App\Repositories\Interfaces\AdminOrderRepositoryInterface;

class UpdateOrderStatusAction
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

    public function execute(int $orderId, string $status)
    {
        return $this->repo->updateStatus($orderId, $status);
    }
}
