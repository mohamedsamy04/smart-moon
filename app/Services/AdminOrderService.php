<?php

namespace App\Services;

use App\Actions\Orders\DeleteOrderAction;
use App\Actions\Orders\GetAllOrdersAction;
use App\Actions\Orders\UpdateOrderStatusAction;

class AdminOrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected GetAllOrdersAction $getAllOrdersAction,
        protected UpdateOrderStatusAction $updateOrderStatusAction,
        protected DeleteOrderAction $deleteOrderAction
    )
    {
        //
    }

    public function getAllOrders()
    {
        return $this->getAllOrdersAction->execute();
    }

    public function updateOrderStatus(int $orderId, string $status)
    {
        return $this->updateOrderStatusAction->execute($orderId, $status);
    }

    public function deleteOrder(int $orderId)
    {
        return $this->deleteOrderAction->execute($orderId);
    }
}
