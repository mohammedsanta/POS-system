<?php

// app/Http/Controllers/OtherInvoicesController.php
namespace App\Http\Controllers;

use App\Models\OtherInvoice;
use App\Models\Product;
use Illuminate\Http\Request;

class OtherInvoicesController extends Controller
{
    // قائمة الفواتير
    public function index()
    {
        // جلب كل الفواتير مع ترتيبها حديثًا
        $otherInvoices = OtherInvoice::orderBy('created_at', 'desc')->paginate(15);

        // تمرير البيانات للـ View
        return view('staff.invoices.other.index', compact('otherInvoices'));
    }


    // إنشاء فاتورة
    public function create()
    {
        $products = Product::all(['id', 'name', 'stock']);
        return view('staff.invoices.other.create', compact('products'));
    }

    // تخزين الفاتورة
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|unique:other_invoices,invoice_number',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
        ]);

        $total = $request->price * $request->quantity;

        OtherInvoice::create([
            'invoice_number' => $request->invoice_number,
            'customer_name' => $request->customer_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'total' => $total,
            'notes' => $request->notes,
        ]);

        return redirect()->route('other.invoices.index')
                         ->with('success', 'Invoice saved successfully.');
    }

    // عرض الفاتورة
    public function show(OtherInvoice $otherInvoice)
    {
        return view('staff.invoices.other.show', compact('otherInvoice'));
    }

    // تعديل الفاتورة
    public function edit($id)
    {
        // جلب الفاتورة حسب الـ id
        $invoice = OtherInvoice::findOrFail($id);

        // تمرير البيانات للـ Blade
        return view('staff.invoices.other.edit', compact('invoice'));
    }

    public function update(Request $request, OtherInvoice $otherInvoice)
    {
        $request->validate([
            'invoice_number' => 'required|unique:other_invoices,invoice_number,' . $otherInvoice->id,
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
        ]);

        $total = $request->price * $request->quantity;

        $otherInvoice->update([
            'invoice_number' => $request->invoice_number,
            'customer_name' => $request->customer_name,
            'product_id' => $request->product_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'total' => $total,
            'notes' => $request->notes,
        ]);

        return redirect()->route('other.invoices.index')
                         ->with('success', 'Invoice updated successfully.');
    }

    // حذف الفاتورة
    public function destroy(OtherInvoice $otherInvoice)
    {
        $otherInvoice->delete();
        return redirect()->route('other.invoices.index')
                         ->with('success', 'Invoice deleted successfully.');
    }
}
