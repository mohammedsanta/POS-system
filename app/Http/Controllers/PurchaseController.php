<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    // App\Models\Purchase.php
    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function index()
    {
        // بنجيب كل المشتريات مع عدد الأصناف فى كل فاتورة
        $purchases = Purchase::withCount('items')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.purchases.index', compact('purchases'));
    }


    public function create()
    {
        return view('admin.purchases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'nullable|string|max:255',
            'supplier_name'  => 'nullable|string|max:255',
            'total'          => 'required|numeric|min:0',
            'notes'          => 'nullable|string',
            'purchased_at'   => 'nullable|date',
        ]);

        Purchase::create($validated);

        return redirect()->route('purchases.index')->with('success', 'Purchase added successfully.');
    }

    public function edit(Purchase $purchase)
    {
        return view('admin.purchases.edit', compact('purchase'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'invoice_number' => 'nullable|string|max:255',
            'supplier_name'  => 'nullable|string|max:255',
            'total'          => 'required|numeric|min:0',
            'notes'          => 'nullable|string',
            'purchased_at'   => 'nullable|date',
        ]);

        $purchase->update($validated);

        return redirect()->route('purchases.index')->with('success', 'Purchase updated.');
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted.');
    }
}
