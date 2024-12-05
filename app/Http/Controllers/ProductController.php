<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $categories = Category::all();
        $brands = Brand::all();
    
        $query = Product::query();
    
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
    
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }
    
        $products = $query->get();
    
        return view('products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = Product::with(['category', 'brand'])->findOrFail($product->id);
        return view('products.view', ['product' => $product]);
    }
}
