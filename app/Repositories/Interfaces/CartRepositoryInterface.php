<?php

namespace App\Repositories\Interfaces;

interface CartRepositoryInterface
{
    public function getByGuestId(string $guestId);
    public function findItem(string $guestId, int $id);
    public function findItemByProductId(string $guestId, int $productId);
    public function addItem(string $guestId, int $productId, int $quantity, float $price);
    public function deleteItem(string $guestId, int $id);
    public function updateQuantity(string $guestId, int $itemId, int $quantity);
}

