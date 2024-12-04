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
    public function index()
    {
        $products = Product::paginate(10); 
        return view('products.index', compact('products')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'stock_quantity' => 'required|integer',
                'size' => 'required|string',
                'color' => 'required|string',
            ]);
    
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('product_images', 'public');
                $validated['image'] = $path;
            }
    
            $product = Product::create($validated);
    
            return redirect()->back()->with('success', 'Product created successfully.');
        }catch(Exception $e){
            return redirect()->back()
                ->with('error', "Error while creating product: {$e->getMessage()}");
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
