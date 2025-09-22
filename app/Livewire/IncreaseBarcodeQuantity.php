<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductBarcode;

class IncreaseBarcodeQuantity extends Component
{
    public $categories;
    public $selectedCategory = '';
    public $products;
    public $selectedProduct = '';

    public $barcodes;
    public $selectedBarcode = '';
    public $quantity = 1;

    public function mount()
    {
        $this->categories = Category::orderBy('name')->get();
        $this->products = collect();
        $this->barcodes = collect();
    }

    public function searchProducts()
    {
        $this->selectedProduct = '';
        $this->selectedBarcode = '';
        $this->quantity = 1;
        $this->barcodes = collect();

        if (!$this->selectedCategory) {
            session()->flash('error', 'الرجاء اختيار قسم أولاً.');
            return;
        }

        $this->products = Product::where('category_id', $this->selectedCategory)
            ->orderBy('name')
            ->get();

        if ($this->products->isEmpty()) {
            session()->flash('error', 'لا يوجد منتجات في هذا القسم.');
        }
    }

    public function loadBarcodes()
    {
        $this->selectedBarcode = '';
        $this->quantity = 1;

        if (!$this->selectedProduct) {
            session()->flash('error', 'الرجاء اختيار منتج أولاً.');
            return;
        }

        $this->barcodes = ProductBarcode::where('product_id', $this->selectedProduct)
            ->orderBy('barcode')
            ->get();
    }

    public function increaseQuantity()
    {
        if (!$this->selectedProduct || $this->quantity < 1) {
            session()->flash('error', 'الرجاء اختيار منتج وإدخال كمية صحيحة.');
            return;
        }

        $product = Product::find($this->selectedProduct);
        if (!$product) {
            session()->flash('error', 'المنتج غير موجود.');
            return;
        }

        $product->stock += $this->quantity;
        $product->save();

        session()->flash('success', '✅ تم تزويد المنتج بنجاح');
        return redirect()->route('admin.products.barcodes');
    }

    public function decreaseQuantity()
    {
        if (!$this->selectedProduct || $this->quantity < 1) {
            session()->flash('error', 'الرجاء اختيار منتج وإدخال كمية صحيحة.');
            return;
        }

        $product = Product::find($this->selectedProduct);
        if (!$product) {
            session()->flash('error', 'المنتج غير موجود.');
            return;
        }

        if ($product->stock < $this->quantity) {
            session()->flash('error', 'لا يمكن إنقاص كمية أكبر من المخزون الحالي.');
            return;
        }

        $product->stock -= $this->quantity;
        $product->save();

        session()->flash('success', '✅ تم إنقاص الكمية بنجاح');
        return redirect()->route('admin.products.barcodes');
    }

    public function render()
    {
        return view('livewire.increase-barcode-quantity');
    }
}
