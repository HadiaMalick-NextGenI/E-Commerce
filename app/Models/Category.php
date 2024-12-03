<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id'
    ];

    /**
     * Get the parent category.
     */
    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the subcategories for the current category.
     */
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    /**
     * Scope a query to only include top-level categories.
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }
}
