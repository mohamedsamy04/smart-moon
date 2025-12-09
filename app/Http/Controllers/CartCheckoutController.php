<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartCheckoutRequest;
use App\Services\CartCheckoutService;

class CartCheckoutController extends Controller
{
    public function __construct(
        protected CartCheckoutService $service
    ) {
    }

    public function checkout(CartCheckoutRequest $request)
    {
        $guestId = $request->header('X-Guest-ID');

        $orderData = [
            'name' => $request->name,
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'notes' => $request->notes,
            
            'status' => 'processing',
            'payment_method' => 'cash_on_delivery',
        ];

        $order = $this->service->checkout($guestId, $orderData);

        return response()->json($order, 201);
    }
}
