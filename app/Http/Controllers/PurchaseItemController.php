<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;

class PurchaseItemController extends Controller
{
    public function index(Purchase $purchase)
    {
        $items = $purchase->items;
        return view('admin.purchases.items.index', compact('purchase', 'items'));
    }

    public function create(Purchase $purchase)
    {
        return view('admin.purchases.items.create', compact('purchase'));
    }

    public function store(Request $request, Purchase $purchase)
    {
        // ✅ التحقق من صحة البيانات بما في ذلك الحقول الجديدة
        $validated = $request->validate([
            'item_name'      => 'required|string|max:255',
            'brand'          => 'nullable|string|max:255',
            'imei'           => 'nullable|string|max:255',
            'qty'            => 'required|integer|min:1',
            'price' => 'required|numeric|min:0', // 👈 سعر الشراء (جملة)
            'sale_price'  => 'required|numeric|min:0', // 👈 سعر البيع للزبون
        ]);

        // ✅ إنشاء العنصر وربطه بالشراء
        $purchase->items()->create($validated);

        return redirect()
            ->route('purchase-items.index', $purchase->id)
            ->with('success', 'تمت إضافة العنصر بنجاح ✅');
    }

    public function edit(Purchase $purchase, PurchaseItem $item)
    {
        return view('admin.purchases.items.edit', compact('purchase', 'item'));
    }

    public function update(Request $request, Purchase $purchase, PurchaseItem $item)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'brand'     => 'nullable|string|max:255',
            'imei'      => 'nullable|string|max:255',
            'qty'       => 'required|integer|min:1',
            'price'     => 'required|numeric|min:0',
        ]);

        $item->update($validated);

        return redirect()->route('purchase-items.index', $purchase->id)
            ->with('success', 'Item updated successfully.');
    }

    public function destroy(Purchase $purchase, PurchaseItem $item)
    {
        $item->delete();

        return redirect()->route('purchase-items.index', $purchase->id)
            ->with('success', 'Item deleted.');
    }
}
