<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductBarcode;

class BarcodeForm extends Component
{
    public $categories;
    public $products;
    public $selectedCategory = '';
    public $selectedProduct = '';

    public $barcode = '';
    public $errorMessage = '';
    public $successMessage = '';

    public function mount()
    {
        $this->categories = Category::orderBy('name')->get();
        $this->products   = collect();
    }

    public function updatedSelectedCategory()
    {
        $this->products        = collect();
        $this->selectedProduct = '';
        $this->barcode         = '';
        $this->resetMessages();
    }

    public function searchProducts()
    {
        $this->resetMessages();

        if (!$this->selectedCategory) {
            $this->errorMessage = 'اختر فئة أولاً.';
            return;
        }

        $this->products = Product::where('category_id', $this->selectedCategory)
            ->orderBy('name')
            ->get();

        if ($this->products->isEmpty()) {
            $this->errorMessage = 'لا توجد منتجات لهذه الفئة.';
        }
    }

    public function submit()
    {
        $this->resetMessages();

        if (!$this->selectedProduct) {
            $this->errorMessage = 'اختر منتجاً أولاً.';
            return;
        }

        $product = Product::find($this->selectedProduct);
        if (!$product) {
            $this->errorMessage = 'المنتج غير موجود.';
            return;
        }

        $barcodeValue = trim($this->barcode);
        if ($barcodeValue === '') {
            $this->errorMessage = 'أدخل الباركود.';
            return;
        }

        if (ProductBarcode::where('product_id', $product->id)
            ->where('barcode', $barcodeValue)
            ->exists()
        ) {
            $this->errorMessage = 'هذا الباركود مسجل مسبقًا.';
            return;
        }

        ProductBarcode::create([
            'product_id'  => $product->id,
            'category_id' => $product->category_id,
            'barcode'     => $barcodeValue,
        ]);

        $this->successMessage = 'تم حفظ الباركود بنجاح!';
        $this->barcode = '';
    }

    private function resetMessages()
    {
        $this->errorMessage   = '';
        $this->successMessage = '';
    }

    public function render()
    {
        return view('livewire.barcode-form');
    }
}
