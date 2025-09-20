<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductBarcode;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductBarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProductBarcode::with(['product', 'category']);

        // Filter by search
        if ($search = $request->input('search')) {
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })->orWhereHas('category', function($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })->orWhere('barcode', 'like', "%$search%");
        }

        $barcodes = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('admin.barcode.index', compact('barcodes', 'search'));
    }

        public function showForm()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.barcode.increase', compact('categories'));
    }

    public function increaseQuantity(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_id'  => 'required|exists:products,id',
            'barcode_id'  => 'required|exists:product_barcodes,id',
            'quantity'    => 'required|integer|min:1',
        ]);

        $barcode = ProductBarcode::find($request->barcode_id);
        $barcode->quantity += $request->quantity;
        $barcode->save();

        return back()->with('success', "Quantity updated successfully! New quantity: {$barcode->quantity}");
    }

    public function staffIndex(Request $request)
    {
        $query = ProductBarcode::query()->with('product'); // نفترض عندك علاقة product()

        // بحث حسب اسم المنتج أو الباركود
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('barcode', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $barcodes = $query->orderBy('id', 'desc')->paginate(20);

        return view('staff.ProductsBarcode', compact('barcodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        $products   = \App\Models\Product::all();

        return view('admin.barcode.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_id'  => 'required|exists:products,id',
            'barcodes'    => 'required|array|min:1',
            'barcodes.*'  => 'required|string|max:255',
        ]);

        foreach ($request->barcodes as $code) {
            \App\Models\ProductBarcode::create([
                'category_id' => $request->category_id,
                'product_id'  => $request->product_id,
                'barcode'     => $code,
            ]);
        }

        return redirect()->route('barcodes.index')
            ->with('success', 'Barcodes added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barcode = ProductBarcode::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $products = Product::orderBy('name')->get(); // You can filter by category later if needed

        return view('admin.barcode.edit', compact('barcode', 'categories', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_id'  => 'required|exists:products,id',
            'barcode'     => 'required|unique:product_barcodes,barcode,' . $id,
        ]);

        $barcode = ProductBarcode::findOrFail($id);
        $barcode->update([
            'category_id' => $request->category_id,
            'product_id'  => $request->product_id,
            'barcode'     => $request->barcode,
        ]);

        return redirect()->route('admin.products.barcodes')->with('success', 'Barcode updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductBarcode $barcode)
    {
        $barcode->delete();

        return redirect()->route('admin.products.barcodes')
                         ->with('success', 'Barcode deleted successfully.');
    }
}
