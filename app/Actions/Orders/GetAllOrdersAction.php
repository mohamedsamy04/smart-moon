<?php

namespace App\Actions\Orders;

use App\Repositories\Interfaces\AdminOrderRepositoryInterface;

class GetAllOrdersAction
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

    public function execute()
    {
        return $this->repo->getAllOrders();
    }
}
