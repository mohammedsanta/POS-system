<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProductBarcode;

class ProductBarcodeSearch extends Component
{
    public $barcode = '';
    public $productData = null;
    public $message = '';
    public $invoiceItems = []; // array: key=unique id for barcode scan
    public $grandTotal = 0;

    public function updatedBarcode($value)
    {
        $this->searchByBarcode();
    }

    public function searchByBarcode()
    {
        $this->message = '';
        $this->productData = null;

        $trim = trim($this->barcode);
        if ($trim === '') return;

        $barcodeRecord = ProductBarcode::with('product', 'category')
            ->where('barcode', $trim)
            ->first();

        if ($barcodeRecord && $barcodeRecord->product) {
            $this->productData = [
                'id'       => $barcodeRecord->product->id,
                'name'     => $barcodeRecord->product->name,
                'price'    => $barcodeRecord->product->sale_price,
                'stock'    => $barcodeRecord->product->stock,
                'brand'    => $barcodeRecord->product->brand,
                'model'    => $barcodeRecord->product->model,
                'category' => $barcodeRecord->category->name ?? '',
                'barcode'  => $barcodeRecord->barcode,
            ];
        } else {
            $this->message = 'لا يوجد منتج بهذا الباركود';
        }
    }

    public function addToInvoice($productId)
    {
        if (!$this->productData || $this->productData['id'] != $productId) return;

        // Use barcode as unique key in invoiceItems
        $key = $this->productData['barcode'];

        if (isset($this->invoiceItems[$key])) {
            $this->invoiceItems[$key]['qty']++;
        } else {
            $this->invoiceItems[$key] = [
                'name'    => $this->productData['name'],
                'price'   => $this->productData['price'],
                'qty'     => 1,
                'barcode' => $this->productData['barcode'],
            ];
        }

        $this->calculateTotal();
        $this->barcode = ''; // clear input
        $this->productData = null;
    }

    public function removeItem($barcode)
    {
        unset($this->invoiceItems[$barcode]);
        $this->calculateTotal();
    }

    public function updateQty($barcode, $qty)
    {
        if (isset($this->invoiceItems[$barcode])) {
            $this->invoiceItems[$barcode]['qty'] = max(1, (int)$qty);
            $this->calculateTotal();
        }
    }

    private function calculateTotal()
    {
        $this->grandTotal = collect($this->invoiceItems)->sum(function ($item) {
            return $item['price'] * $item['qty'];
        });
    }

    public function render()
    {
        return view('livewire.product-barcode-search');
    }
}
