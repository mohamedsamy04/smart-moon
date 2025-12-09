<?php

namespace App\Http\Controllers;

use App\Http\Requests\DirectCheckoutRequest;
use App\Services\DirectCheckoutService;

class DirectCheckoutController extends Controller
{
    public function __construct(protected DirectCheckoutService $service)
    {
    }

    public function checkout(DirectCheckoutRequest $request)
    {
        $guestId = $request->guest_id;

        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $orderData = [
            'guest_id' => $guestId,
            'name' => $request->name,
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'notes' => $request->notes,
            'status' => 'processing',
            'payment_method' => 'cash_on_delivery',
        ];

        $itemData = [
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $this->service->getProductPrice($productId),
        ];

        $order = $this->service->checkout($orderData, $itemData);

        return response()->json($order, 201);
    }
}
