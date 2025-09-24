<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductBarcode;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    // البحث بالباركود
    // صفحة البحث
    public function searchBarcodeForm()
    {
        return view('staff.ProductsBarcode');
    }

    // البحث بالباركود
    public function searchBarcode(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string|max:255',
        ]);

        $barcode = $request->barcode;

        // البحث مباشرة في جدول المنتجات
        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            return back()->with('error', '🚫 لم يتم العثور على منتج بهذا الباركود');
        }

        return back()->with('success', '✅ تم العثور على المنتج')
                     ->with('product', $product);
    }

    /**
     * Display a listing of the products.
     */
    public function index()
    {
        // يجيب كل المنتجات فقط من جدول products
        $products = Product::latest()->get();

        return view('admin.products', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('admin.quick-insert-product');
    }


    /**
     * Store a newly created product in storage.
     */
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'category_id'    => 'nullable|string|max:255',
    //         'supplier_id'    => 'nullable',
    //         'name'           => 'required|string|max:255',
    //         'brand'          => 'nullable|string|max:255',
    //         'model'          => 'nullable|string|max:255',
    //         'purchase_price' => 'required|numeric|min:0',
    //         'sale_price'     => 'required|numeric|min:0',
    //         'stock'          => 'required|integer|min:0',
    //         'description'    => 'nullable|string',
    //     ]);

    //     dd($validated);

    //     Product::create($validated);

    //     return redirect()
    //         ->route('products.index')
    //         ->with('success', 'Product created successfully.');
    // }

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
            'category_id'    => 'nullable|integer|exists:categories,id',
            'supplier_id'    => 'nullable|integer|exists:suppliers,id',
            'name'           => 'required|string|max:255',
            'brand'          => 'nullable|string|max:255',
            'model'          => 'nullable|string|max:255',
            'barcode'        => 'nullable|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price'     => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'description'    => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'تم تحديث المنتج بنجاح.');
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
