<?php

use Illuminate\Support\Collection;

if (!function_exists('calculateTotalAmount')) {
    function calculateTotalAmount(Collection $cartItems): float
    {
        return $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }
}