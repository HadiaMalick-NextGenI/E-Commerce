<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($order) {
            do {
                $referenceId = strtoupper(Str::random(10));
            } while (self::where('reference_id', $referenceId)->exists());
    
            $order->reference_id = $referenceId;
        });

        static::updated(function ($order) {
            $originalStatus = $order->getOriginal('status');
        
            if ($originalStatus != 'shipped' && $order->status == 'shipped') {
                foreach ($order->products as $product) {
                    $pivot = $order->products()->where('product_id', $product->id)->first()->pivot;
                    $quantity = $pivot->quantity;
                    $product->decrement('stock_quantity', $quantity);
                }
            } elseif ($originalStatus == 'shipped' && $order->status == 'cancelled') {
                foreach ($order->products as $product) {
                    $pivot = $order->products()->where('product_id', $product->id)->first()->pivot;
                    $quantity = $pivot->quantity;
                    $product->increment('stock_quantity', $quantity);
                }
            }
        });        
    }

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
        return $this->belongsToMany(Product::class, 'order_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
