<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'brand_id',
        'image',
        'stock_quantity',
        'size',
        'color',
        'discount_type',
        'discount_percentage',
        'discount_price',
        'discount_end_date'
    ];

    protected $casts = [
        'discount_end_date' => 'date',
    ];

    public function getOnSaleAttribute()
    {
        $hasDiscount = $this->discount_type 
            && $this->discount_end_date 
            && Carbon::now()->lte(Carbon::parse($this->discount_end_date));
        
        if ($hasDiscount) {
            if ($this->discount_type === 'percentage' && $this->discount_percentage > 0) {
                return true;
            }
    
            if ($this->discount_type === 'flat' && $this->discount_price > 0) {
                return true;
            }
        }
    
        return false;
    }

    public function getDiscountedPriceAttribute()
    {
        if ($this->on_sale) {
            if ($this->discount_type === 'percentage' && $this->discount_percentage > 0) {
                return $this->price - ($this->price * ($this->discount_percentage / 100));
            }
    
            if ($this->discount_type === 'flat' && $this->discount_price > 0) {
                return $this->price - $this->discount_price;
            }
        }
    
        return $this->price; 
    }

    /**
     * Get the category that owns the product.
     */
    public function category(){
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the product.
     */
    public function brand(){
        return $this->belongsTo(Brand::class);
    }


    /**
     * Get the orders that the product belongs to.
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function wishlists()
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }

    /**
     * Scope a query to only include available products in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }
}
