<?php

namespace App\Repositories\Eloquents;

use App\Models\Order;
use App\Repositories\Interfaces\AdminOrderRepositoryInterface;

class AdminOrderRepository implements AdminOrderRepositoryInterface
{
    public function getAllOrders()
    {
        return Order::with('items')->orderBy('created_at', 'desc')->get();
    }

    public function findOrderById(int $orderId)
    {
        return Order::with('items')->findOrFail($orderId);
    }

    public function updateStatus(int $orderId, string $status)
    {
        $order = $this->findOrderById($orderId);
        $order->update(['status' => $status]);
        return $order;
    }

    public function deleteOrder(int $orderId)
    {
        $order = $this->findOrderById($orderId);
        $order->delete();
        return true;
    }
}
