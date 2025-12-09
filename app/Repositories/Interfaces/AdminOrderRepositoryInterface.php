<?php

namespace App\Repositories\Interfaces;

interface AdminOrderRepositoryInterface
{
    public function getAllOrders();
    public function findOrderById(int $orderId);
    public function updateStatus(int $orderId, string $status);
    public function deleteOrder(int $orderId);
}
