<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductBarcode;
use App\Models\Category;

class QuickInsertProduct extends Component
{
    public $categories;
    public $name;
    public $category_id;
    public $barcode;
    public $purchase_price;
    public $sale_price;
    public $stock;

    public function mount()
    {
        $this->categories = Category::orderBy('name')->get();
    }

    public function save()
    {
        $this->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'barcode'        => 'required|string|max:255|unique:product_barcodes,barcode',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price'  => 'required|numeric|min:0',
        ]);

        // إنشاء المنتج
        $product = Product::create([
            'name'        => $this->name,
            'category_id' => $this->category_id,
            'quantity'    => 0, // يبدأ بدون مخزون
            'purchase_price'       => $this->purchase_price,
            'sale_price' => $this->sale_price,
            'stock' => $this->stock,
        ]);

        // إضافة الباركود
        ProductBarcode::create([
            'product_id' => $product->id,
            'category_id' => $this->category_id,
            'barcode'    => $this->barcode,
            'quantity'   => 0,
        ]);

        session()->flash('success', '✅ تم إضافة المنتج بسرعة بنجاح');
        return redirect()->route('quick-insert-product');
    }

    public function render()
    {
        return view('livewire.quick-insert-product');
    }
}
