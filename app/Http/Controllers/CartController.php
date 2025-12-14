<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartRequest;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function index(Request $request)
    {
        $guestId = $request->header('X-Guest-ID');
        $items = $this->cartService->getCart($guestId);

        if ($items->isEmpty()) {
            return response()->json([
                'message' => 'Your cart is empty',
                'items' => [],
            ], 200);
        }

        return response()->json([
            'message' => 'Cart retrieved successfully',
            'items' => $items,
        ], 200);
    }


    public function add(AddToCartRequest $request)
    {
        $guestId = $request->attributes->get('guest_id');
        $item = $this->cartService->addToCart(
            $guestId,
            $request->product_id,
            $request->quantity ?? 1
        );

        return response()->json($item, 201);
    }

    public function remove(string $id, Request $request)
    {
        $guestId = $request->attributes->get('guest_id');

        if ($this->cartService->getCart($guestId)->isEmpty()) {
            return response()->json([
                'message' => 'Cart is already empty',
            ], 200);
        }

        $item = $this->cartService->getCart($guestId)->firstWhere('id', (int)$id);

        if (! $item) {
            return response()->json([
                'message' => 'Item not found in cart',
            ], 404);
        }
        $this->cartService->removeFromCart($guestId, $id);

        return response()->json([
            'message' => 'Item removed from cart',
        ], 200);
    }

    public function update(UpdateCartRequest $request, int $itemId)
    {
        $guestId = $request->attributes->get('guest_id');

        $response = $this->cartService->updateCartQuantity(
            $guestId,
            $itemId,
            $request->quantity
        );

        if (!$response['item']) {
            return response()->json([
                'message' => $response['message'],
            ], 404);
        }

        return response()->json($response, 200);
    }
}
