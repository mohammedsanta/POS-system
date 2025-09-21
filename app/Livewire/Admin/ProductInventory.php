<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;

class ProductInventory extends Component
{
    public $products = [];
    public $counts = [];
    public $inventoried = [];

    public function mount()
    {
        // جلب جميع المنتجات مع حساب الكمية من الباركود إذا موجودة
        $this->products = Product::with('category')->get()->map(function($product) {
            // فرضًا أن لديك relation barcodes لإجمالي عدد المنتجات
            $quantity = $product->barcodes->count() ?? $product->stock;
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category->name,
                'quantity' => $quantity,
                'price' => $product->sale_price,
            ];
        })->toArray();
    }

    public function addToInventory($productId)
    {
        $product = collect($this->products)->firstWhere('id', $productId);
        if (!$product) return;

        $qty = $this->counts[$productId] ?? 0;

        if ($qty <= 0 || $qty > $product['quantity']) {
            session()->flash('error', 'الكمية غير صحيحة أو أكبر من المتاح!');
            return;
        }

        // إضافة للمنتجات المجردة
        $existing = collect($this->inventoried)->firstWhere('id', $productId);
        if ($existing) {
            $key = array_search($existing, $this->inventoried);
            $this->inventoried[$key]['counted'] += $qty;
        } else {
            $this->inventoried[] = array_merge($product, ['counted' => $qty]);
        }

        // خصم الكمية من الجدول
        foreach ($this->products as $key => &$p) {
            if ($p['id'] == $productId) {
                $p['quantity'] -= $qty;

                // إذا أصبحت الكمية 0 نحذف المنتج من الجدول
                if ($p['quantity'] <= 0) {
                    unset($this->products[$key]);
                }
            }
        }

        // إعادة ترتيب المصفوفة بعد unset
        $this->products = array_values($this->products);

        // إعادة تعيين قيمة الإدخال
        $this->counts[$productId] = null;
    }

    public function render()
    {
        return view('livewire.admin.product-inventory');
    }
}
