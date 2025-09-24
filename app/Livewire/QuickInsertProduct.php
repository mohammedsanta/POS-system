<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

class QuickInsertProduct extends Component
{
    public $categories;
    public $suppliers;

    public $name;
    public $category_id;
    public $supplier_id;
    public $barcode;
    public $brand;
    public $model;
    public $purchase_price;
    public $sale_price;
    public $stock;
    public $description;

    public function mount()
    {
        $this->categories = Category::orderBy('name')->get();
        $this->suppliers  = Supplier::orderBy('name')->get();
    }

    public function save()
    {
        $this->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'supplier_id'    => 'nullable|exists:suppliers,id',
            'barcode'        => 'required|string|max:255',
            'brand'          => 'nullable|string|max:255',
            'model'          => 'nullable|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price'     => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'description'    => 'nullable|string',
        ]);

        // إنشاء المنتج بكامل البيانات
        $product = Product::create([
            'name'           => $this->name,
            'category_id'    => $this->category_id,
            'supplier_id'    => $this->supplier_id,
            'barcode'     => $this->barcode,
            'brand'          => $this->brand,
            'model'          => $this->model,
            'purchase_price' => $this->purchase_price,
            'sale_price'     => $this->sale_price,
            'stock'          => $this->stock,
            'description'    => $this->description,
        ]);

        session()->flash('success', '✅ تم إضافة المنتج بسرعة بنجاح');
        return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.quick-insert-product');
    }
}
