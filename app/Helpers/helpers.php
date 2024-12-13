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

if (!function_exists('orderStatusBadge')) {
    function orderStatusBadge($status)
    {
        switch ($status) {
            case 'pending':
                return 'warning';
            case 'shipped':
                return 'primary';
            case 'delivered':
                return 'success';
            case 'cancelled':
                return 'danger';
            default:
                return 'secondary';
        }
    }
}