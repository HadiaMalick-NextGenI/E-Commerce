<?php

use Illuminate\Support\Collection;

if (!function_exists('getProductPrice')) {
    function getProductPrice($product): float
    {
        return $product->on_sale ? $product->discounted_price : $product->price;
    }
}

if (!function_exists('calculateTotalAmount')) {
    function calculateTotalAmount(Collection $cartItems): float
    {
        return $cartItems->sum(function ($item) {
            return $item->quantity * getProductPrice($item->product);
        });
    }
}