<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductBarcode;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoiceCreate extends Component
{
    public $categories;
    public $customerName;
    public $selectedCategory = '';
    public $products;                   
    public $selectedProductBarcodes = []; 
    public $selectedBarcodeId = [];       
    public $invoiceItems = [];            
    public $grandTotal = 0;
    public $barcodeInput = '';
    public $errorMessage = '';

    public function mount()
    {
        $this->categories              = Category::orderBy('name')->get();
        $this->products                = collect();
        $this->invoiceItems            = [];
        $this->selectedProductBarcodes = [];
        $this->selectedBarcodeId       = [];
    }

    private function getNextInvoiceNumber(): int
    {
        $last = Invoice::orderByDesc('invoice_number')->first();
        return $last ? $last->invoice_number + 1 : 1;
    }

    /** البحث حسب الفئة */
    public function searchProducts()
    {
        $this->errorMessage = '';

        if ($this->selectedCategory) {
            $this->products = Product::where('category_id', $this->selectedCategory)
                ->with('barcodes')
                ->orderBy('name')
                ->get();

            if ($this->products->isEmpty()) {
                $this->errorMessage = 'لا توجد منتجات لهذه الفئة.';
            }
        } else {
            $this->errorMessage = 'اختر الفئة أولاً.';
            $this->products = collect();
        }
    }

    /** تحميل الباركودات المتاحة لمنتج */
    public function loadBarcodes($productId)
    {
        $barcodes = ProductBarcode::where('product_id', $productId)
            ->where(function ($q) {
                $q->whereNull('sold')->orWhere('sold', false);
            })
            ->get();

        $this->selectedProductBarcodes[$productId] = $barcodes->count() ? $barcodes : null;
    }

    /** إضافة منتج للفاتورة */
    public function addToInvoice($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            $this->errorMessage = 'المنتج غير موجود.';
            return;
        }

        // كل الباركودات
        $allBarcodes = ProductBarcode::where('product_id', $productId)->get();
        $unsold      = $allBarcodes->where(fn($b) => !$b->sold);

        // لو المنتج مرتبط بباركودات لكن كلها مباعة
        if ($allBarcodes->count() > 0 && $unsold->count() === 0) {
            $this->errorMessage = 'تم بيع جميع النسخ من هذا المنتج.';
            return;
        }

        // لو المنتج ملوش باركود أصلاً → لا يمكن إضافته (لا يوجد مخزون)
        if ($allBarcodes->count() === 0) {
            $this->errorMessage = 'هذا المنتج غير متاح بالمخزون.';
            return;
        }

        // لو فيه باركودات غير مباعة لازم يختار
        $barcodeId = $this->selectedBarcodeId[$productId] ?? null;
        if (!$barcodeId) {
            $this->errorMessage = 'اختر الباركود للمنتج قبل إضافته.';
            return;
        }

        $key = $barcodeId;

        if (isset($this->invoiceItems[$key])) {
            $this->invoiceItems[$key]['qty']++;
        } else {
            $this->invoiceItems[$key] = [
                'product_id'  => $productId,
                'category_id' => $product->category_id,
                'name'        => $product->name,
                'barcode_id'  => $barcodeId,
                'barcode'     => ProductBarcode::find($barcodeId)->barcode,
                'price'       => $product->sale_price,
                'qty'         => 1,
            ];
        }

        $this->calculateTotal();
        $this->errorMessage = '';
    }

    /** إضافة عبر مسح باركود */
    public function addByBarcode()
    {
        $this->errorMessage = '';
        if (!$this->barcodeInput) return;

        $barcode = ProductBarcode::where('barcode', $this->barcodeInput)->first();

        if (!$barcode) {
            $this->errorMessage = 'هذا الباركود غير موجود.';
            return;
        }

        if ($barcode->sold) {
            $this->errorMessage = 'هذا الباركود تم بيعه من قبل.';
            return;
        }

        $this->selectedBarcodeId[$barcode->product_id] = $barcode->id;
        $this->addToInvoice($barcode->product_id);

        $this->barcodeInput = '';
    }

    /** تحديث الكمية */
    public function updateQty($key, $qty)
    {
        if (isset($this->invoiceItems[$key])) {
            $this->invoiceItems[$key]['qty'] = max(1, (int)$qty);
            $this->calculateTotal();
        }
    }

    /** حذف عنصر */
    public function removeItem($key)
    {
        unset($this->invoiceItems[$key]);
        $this->calculateTotal();
    }

    /** حساب الإجمالي */
    private function calculateTotal()
    {
        $this->grandTotal = collect($this->invoiceItems)
            ->sum(fn($item) => $item['price'] * $item['qty']);
    }

    /** حفظ الفاتورة */
    public function submitInvoice()
    {
        $this->errorMessage = '';

        if (empty($this->invoiceItems)) {
            $this->errorMessage = 'لا توجد منتجات لإضافتها إلى الفاتورة.';
            return;
        }

        DB::beginTransaction();
        try {
            $invoiceNumber = $this->getNextInvoiceNumber();

            foreach ($this->invoiceItems as $item) {
                Invoice::create([
                    'invoice_number' => $invoiceNumber,
                    'product_id'     => $item['product_id'],
                    'category_id'    => $item['category_id'],
                    'product_name'   => $item['name'],
                    'customer_name'  => $this->customerName ?? null,
                    'barcode_id'     => $item['barcode_id'],
                    'qty'            => $item['qty'],
                    'price'          => $item['price'],
                    'total'          => $item['price'] * $item['qty'],
                    'sold_at'        => now(),
                ]);

                // تحديث حالة الباركود
                if (!empty($item['barcode_id'])) {
                    ProductBarcode::where('id', $item['barcode_id'])
                        ->update(['sold' => true]);
                }
            }

            DB::commit();

            $this->reset([
                'invoiceItems', 'barcodeInput', 'selectedCategory',
                'products', 'selectedProductBarcodes',
                'selectedBarcodeId', 'grandTotal', 'customerName'
            ]);

            session()->flash('success', 'تم إنشاء الفاتورة بنجاح!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorMessage = 'حدث خطأ أثناء حفظ الفاتورة: ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.invoiceCreate');
    }
}
