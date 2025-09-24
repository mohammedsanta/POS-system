<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;
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

    public function adminViewInvoices()
    {
        $invoices = Invoice::latest()->get();
        $deletedInvoices = Invoice::onlyTrashed()->latest()->get();

        return view('admin.invoices.index', compact('invoices', 'deletedInvoices'));
    }

        public function AdminIndex(Request $request)
    {
        $query = Invoice::query();

        // فلتر حسب اليوم
        if ($request->filled('day')) {
            $day = Carbon::parse($request->day)->toDateString();
            $query->whereDate('sold_at', $day);
        }

        // فلتر حسب الشهر
        if ($request->filled('month')) {
            $month = Carbon::parse($request->month);
            $query->whereMonth('sold_at', $month->month)
                  ->whereYear('sold_at', $month->year);
        }

        $invoices = $query->orderBy('sold_at', 'desc')->paginate(15);

        return view('admin.invoices.all', compact('invoices'));
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
     * تحديث الفاتورة
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'invoice_number' => 'required|numeric|unique:invoices,invoice_number,' . $invoice->id,
            'product_id'     => 'required|exists:products,id',
            'category_id'    => 'required|exists:categories,id',
            'qty'            => 'required|integer|min:1',
            'price'          => 'required|numeric|min:0',
            'customer_name'  => 'nullable|string|max:255',
        ]);

        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'product_id'     => $request->product_id,
            'category_id'    => $request->category_id,
            'customer_name'  => $request->customer_name,
            'qty'            => $request->qty,
            'price'          => $request->price,
            'total'          => $request->qty * $request->price,
        ]);

        return redirect()->route('admin.invoices.edit', $invoice->id)
                         ->with('success', 'تم تعديل الفاتورة بنجاح ✅');
    }

    /**
     * حذف فاتورة
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('admin.view.invoices')
            ->with('success', 'Invoice deleted successfully.');
    }

    public function restore($id)
    {
        $invoice = Invoice::onlyTrashed()->findOrFail($id);
        $invoice->restore();

        return redirect()->route('admin.view.invoices')->with('success', 'تم استرجاع الفاتورة بنجاح');
    }
}
