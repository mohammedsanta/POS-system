<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductBarcode;

class BarcodeForm extends Component
{
    public $categories;
    public $selectedCategory = '';
    public $products;
    public $selectedProduct = '';

    public $mode = 'single'; // 'single' or 'multiple'
    public $barcode = ''; // for single barcode
    public $barcodes = ['']; // for multiple barcodes
    public $quantity = null; // quantity for single barcode

    public $errorMessage = '';
    public $successMessage = '';

    public function mount()
    {
        $this->categories = Category::orderBy('name')->get();
        $this->products = collect();
    }

    public function updatedSelectedCategory()
    {
        $this->products = collect();
        $this->selectedProduct = '';
        $this->barcode = '';
        $this->barcodes = [''];
        $this->quantity = null;
        $this->resetMessages();
    }

    public function searchProducts()
    {
        $this->resetMessages();

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

    public function addBarcodeField()
    {
        $this->barcodes[] = '';
    }

    public function removeBarcodeField($index)
    {
        if (count($this->barcodes) > 1) {
            unset($this->barcodes[$index]);
            $this->barcodes = array_values($this->barcodes);
        }
    }

    public function submit()
    {
        $this->resetMessages();

        if (!$this->selectedProduct) {
            $this->errorMessage = 'Please select a product.';
            return;
        }

        $product = Product::find($this->selectedProduct);
        $categoryId = $product->category_id;

        if ($this->mode === 'single') {
            $barcodeValue = trim($this->barcode);

            if (empty($barcodeValue)) {
                $this->errorMessage = 'Barcode cannot be empty.';
                return;
            }

            if (!is_numeric($this->quantity) || $this->quantity < 1) {
                $this->errorMessage = 'Quantity must be a number greater than 0.';
                return;
            }

            if (ProductBarcode::where('product_id', $this->selectedProduct)
                ->where('barcode', $barcodeValue)
                ->exists()
            ) {
                $this->errorMessage = 'This barcode already exists for this product.';
                return;
            }

            ProductBarcode::create([
                'product_id' => $this->selectedProduct,
                'category_id' => $categoryId,
                'barcode' => $barcodeValue,
                'quantity' => (int) $this->quantity,
            ]);

        } elseif ($this->mode === 'multiple') {
            $validBarcodes = array_filter($this->barcodes, fn($b) => trim($b) !== '');
            if (empty($validBarcodes)) {
                $this->errorMessage = 'Please add at least one barcode.';
                return;
            }

            foreach ($validBarcodes as $barcodeValue) {
                if (ProductBarcode::where('product_id', $this->selectedProduct)
                    ->where('barcode', $barcodeValue)
                    ->exists()
                ) {
                    $this->errorMessage = "Barcode '$barcodeValue' already exists.";
                    return;
                }

                ProductBarcode::create([
                    'product_id' => $this->selectedProduct,
                    'category_id' => $categoryId,
                    'barcode' => $barcodeValue,
                    'quantity' => null, // null for multiple barcode mode
                ]);
            }
        }

        $this->successMessage = 'Barcodes added successfully!';
        $this->barcode = '';
        $this->quantity = null;
        $this->barcodes = [''];
        $this->selectedProduct = '';
        $this->products = collect();
    }

    private function resetMessages()
    {
        $this->errorMessage = '';
        $this->successMessage = '';
    }

    public function render()
    {
        return view('livewire.barcode-form');
    }
}
