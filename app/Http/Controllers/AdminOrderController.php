<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderStatusRequest;
use App\Services\AdminOrderService;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function __construct(
        protected AdminOrderService $adminOrderService
    ) {
    }

    public function index()
    {
        $orders = $this->adminOrderService->getAllOrders();
        return response()->json($orders);
    }

    public function updateStatus(UpdateOrderStatusRequest $request, int $orderId)
    {
        $this->adminOrderService->updateOrderStatus($orderId, $request->status);
        return response()->json(['success' => 'Order status updated successfully']);
    }

    public function deleteOrder(int $orderId)
    {
        $this->adminOrderService->deleteOrder($orderId);
        return response()->json(['success' => 'Order deleted successfully']);
    }
}
