<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function search()
    {
        $categories = Category::orderBy('name')->get();
        return view('staff.invoice.search', compact('categories'));
    }
    /**
     * عرض جميع الفواتير
     */
    public function index()
    {
        $invoices = Invoice::select(
                'invoice_number',
                'customer_name',
                DB::raw('SUM(total) as total_amount'),
                DB::raw('MAX(sold_at) as last_sold_at'),
                DB::raw('COUNT(id) as items_count'),
                DB::raw('SUM(is_returned) as returned_count') // NEW: how many items returned
            )
            ->groupBy('invoice_number', 'customer_name')
            ->orderBy('last_sold_at', 'desc')
            ->paginate(15);

        return view('staff.invoices.index', compact('invoices'));
    }


    public function show($invoice_number)
    {
        $items = Invoice::where('invoice_number', $invoice_number)->get();
        return view('staff.invoices.show', compact('items', 'invoice_number'));
    }

    /**
     * صفحة إنشاء فاتورة جديدة
     */
    public function create()
    {
        $products   = Product::all();
        $categories = Category::all();

        return view('staff.invoices.create', compact('products', 'categories'));
    }

    /**
     * تخزين الفاتورة في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'    => 'required|exists:products,id',
            'category_id'   => 'required|exists:categories,id',
            'product_name'  => 'required|string|max:255',
            'customer_name' => 'nullable|string|max:255',
            'qty'           => 'required|integer|min:1',
            'price'         => 'required|numeric|min:0',
        ]);

        $validated['total'] = $validated['qty'] * $validated['price'];

        Invoice::create($validated);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice added successfully.');
    }

    /**
     * صفحة تعديل فاتورة
     */
    public function edit(Invoice $invoice)
    {
        $products   = Product::all();
        $categories = Category::all();

        return view('invoices.create', compact('invoice', 'products', 'categories'));
    }

    /**
     * تحديث الفاتورة
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'product_id'    => 'required|exists:products,id',
            'category_id'   => 'required|exists:categories,id',
            'product_name'  => 'required|string|max:255',
            'customer_name' => 'nullable|string|max:255',
            'qty'           => 'required|integer|min:1',
            'price'         => 'required|numeric|min:0',
        ]);

        $validated['total'] = $validated['qty'] * $validated['price'];

        $invoice->update($validated);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice updated successfully.');
    }

    /**
     * حذف فاتورة
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }
}
