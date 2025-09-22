<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductBarcode;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    // البحث بالتصنيف
    public function getByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)
            ->select('id', 'name', 'sale_price', 'stock') // الحقول اللي محتاجها
            ->orderBy('name')
            ->get();

        return response()->json($products);
    }

    // البحث بالباركود
    public function getByBarcode($barcode)
    {
        $product = ProductBarcode::where('barcode', $barcode)
            ->select('id', 'barcode')
            ->first();

        if (!$product) {
            return response()->json(['message' => 'المنتج غير موجود'], 404);
        }

        return response()->json($product);
    }

    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::latest()->get();

        return view('admin.products', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $suppliers  = Supplier::orderBy('name')->get(); // Assuming you have a Supplier model
        return view('admin.createProduct', compact('categories', 'suppliers'));
    }


    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'    => 'nullable|string|max:255',
            'supplier_id'    => 'nullable',
            'name'           => 'required|string|max:255',
            'brand'          => 'nullable|string|max:255',
            'model'          => 'nullable|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price'     => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'description'    => 'nullable|string',
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.showProduct', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('admin.editProduct', compact('product', 'categories', 'suppliers'));
    }


    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_id'    => 'nullable|string|max:255',
            'supplier_id'    => 'nullable',
            'name'           => 'required|string|max:255',
            'brand'          => 'nullable|string|max:255',
            'model'          => 'nullable|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price'     => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'description'    => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
