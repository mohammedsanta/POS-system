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
    public $products; // Collection
    public $selectedProduct = '';

    public $barcodes; // Collection of barcodes for selected product
    public $selectedBarcode = '';
    public $quantity = 1;

    public $successMessage = '';
    public $errorMessage = '';

    public function mount()
    {
        $this->categories = Category::orderBy('name')->get();
        $this->products = collect();
        $this->barcodes = collect();
    }

    // Search products manually by button
    public function searchProducts()
    {
        $this->resetMessages();
        $this->selectedProduct = '';
        $this->selectedBarcode = '';
        $this->quantity = 1;
        $this->barcodes = collect();

        if (!$this->selectedCategory) {
            $this->errorMessage = 'Please select a category first.';
            return;
        }

        $this->products = Product::where('category_id', $this->selectedCategory)
            ->orderBy('name')
            ->get();

        if ($this->products->isEmpty()) {
            $this->errorMessage = 'No products found for this category.';
        }
    }

    // Load barcodes manually by button
    public function loadBarcodes()
    {
        $this->resetMessages();
        $this->selectedBarcode = '';
        $this->quantity = 1;

        if (!$this->selectedProduct) {
            $this->errorMessage = 'Please select a product first.';
            return;
        }

        $this->barcodes = ProductBarcode::where('product_id', $this->selectedProduct)
            ->orderBy('barcode')
            ->get();

        if ($this->barcodes->isEmpty()) {
            $this->errorMessage = 'No barcodes found for this product.';
        }
    }

    // Increase quantity of selected barcode
    public function increaseQuantity()
    {
        $this->resetMessages();

        if (!$this->selectedBarcode) {
            $this->errorMessage = 'Please select a barcode.';
            return;
        }

        if (!$this->quantity || $this->quantity < 1) {
            $this->errorMessage = 'Please enter a valid quantity.';
            return;
        }

        $barcode = ProductBarcode::find($this->selectedBarcode);
        if (!$barcode) {
            $this->errorMessage = 'Selected barcode not found.';
            return;
        }

        // Update quantity
        $barcode->quantity += $this->quantity;
        $barcode->save();

        $this->successMessage = "Quantity updated successfully!";
        $this->quantity = 1;

        // Refresh barcodes
        $this->loadBarcodes();
    }

    private function resetMessages()
    {
        $this->errorMessage = '';
        $this->successMessage = '';
    }

    public function render()
    {
        return view('livewire.increase-barcode-quantity');
    }
}
