<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_date',
        'status',
        'total_amount',
        'shipping_address',
        'payment_method'
    ];

    protected $casts = [
        'order_date' => 'datetime',
    ];

    /**
     * Get the user that the order belongs to.
     */
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products associated with the order.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
