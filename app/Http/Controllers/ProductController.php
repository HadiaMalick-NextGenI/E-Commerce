<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $categories = Category::all();
        $brands = Brand::all();
    
        $query = Product::inStock();
    
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
    
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }
    
        $products = $query->paginate(6);

        $wishlistProductIds = Auth::user()->wishlists()->select('products.id')->pluck('id')->toArray();
       
        if ($request->ajax()) {
            $html = view('partials.products_list', compact('products'))->render();
            return response()->json(['html' => $html]);
        } else {
            return view('products.index', 
        compact('products', 'categories', 'brands', 'wishlistProductIds'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = Product::with(['category', 'brand'])->findOrFail($product->id);

        $wishlistProductIds = Auth::user()->wishlists()->select('products.id')->pluck('id')->toArray();

        return view('products.view', ['product' => $product, 'wishlistProductIds' => $wishlistProductIds]);
    }
}
