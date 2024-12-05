<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
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
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try{
            $validated = $request->validated();
            
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('product_images', 'public');
                $validated['image'] = $path;
            }
    
            $product = Product::create($validated);
    
            return redirect()->route('products.index')
                ->with('success', 'Product created successfully.');
        }catch(Exception $e){
            return redirect()->route('products.index')
                ->with('error', "Error while creating product: {$e->getMessage()}");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.view', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
                'image' => 'nullable|image|max:2048',
                'stock_quantity' => 'required|integer|min:0',
                'size' => 'required|string',
                'color' => 'required|string',
            ]);
    
            $data = $request->all();

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('product_images', 'public');
                $data['image'] = $imagePath;
            }
    
            $product->update($data);
    
            return redirect()->route('products.index')
                ->with('success', 'Product updated successfully');
        }catch(Exception $e){
            return redirect()->back()
                ->with('error', "Error while updating product: {$e->getMessage()}");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try{
            $product->delete();
            return redirect()->route('products.index')
                ->with('success', 'Product deleted successfully');
        }catch(Exception $e){
            return redirect()->route('products.index')
                ->with('success', "Error deleting product: {$e->getMessage()}");
        }
    }
}
