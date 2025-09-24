<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoiceCreate extends Component
{
    public $categories;
    public $customerName;
    public $selectedCategory = '';
    public $products;
    public $invoiceItems = [];
    public $grandTotal = 0;
    public $barcodeInput = '';
    public $errorMessage = '';

    public function mount()
    {
        $this->categories = Category::orderBy('name')->get();
        $this->products   = collect();
        $this->invoiceItems = [];
    }

    private function getNextInvoiceNumber(): string
    {
        $last = Invoice::withTrashed()->max('id'); // id دايمًا unique
        $next = $last ? $last + 1 : 1;

        return 'INV-' . str_pad($next, 6, '0', STR_PAD_LEFT);
    }


    /** البحث حسب الفئة */
    public function searchProducts()
    {
        $this->errorMessage = '';

        if ($this->selectedCategory) {
            $this->products = Product::where('category_id', $this->selectedCategory)
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

    /** إضافة منتج للفاتورة */
    public function addToInvoice($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            $this->errorMessage = 'المنتج غير موجود.';
            return;
        }

        if ($product->stock <= 0) {
            $this->errorMessage = 'هذا المنتج غير متاح في المخزون.';
            return;
        }

        $key = $product->id;

        if (isset($this->invoiceItems[$key])) {
            if ($this->invoiceItems[$key]['qty'] < $product->stock) {
                $this->invoiceItems[$key]['qty']++;
            } else {
                $this->errorMessage = 'لا توجد كمية كافية من هذا المنتج في المخزون.';
                return;
            }
        } else {
            $this->invoiceItems[$key] = [
                'product_id'  => $product->id,
                'category_id' => $product->category_id,
                'name'        => $product->name,
                'barcode'     => $product->barcode,
                'price'       => $product->sale_price,
                'qty'         => 1,
            ];
        }

        $this->calculateTotal();
        $this->errorMessage = '';
    }

/** إضافة عبر الباركود */
public function addByBarcode()
{
    $this->errorMessage = '';
    if (!$this->barcodeInput) return;

    // رجع كل المنتجات اللي ليها نفس الباركود
    $products = Product::where('barcode', $this->barcodeInput)->get();

    if ($products->isEmpty()) {
        $this->errorMessage = 'هذا الباركود غير موجود.';
        return;
    }

    if ($products->count() > 1) {
        // لو فيه أكثر من منتج بنفس الباركود => عرضهم للمستخدم
        $this->products = $products;
        $this->errorMessage = 'يوجد أكثر من منتج بنفس الباركود، اختر المنتج المطلوب من القائمة.';
        return;
    }

    // لو منتج واحد فقط
    $product = $products->first();

    if ($product->stock <= 0) {
        $this->errorMessage = 'هذا المنتج غير متاح في المخزون.';
        return;
    }

    $key = $product->id;

    if (isset($this->invoiceItems[$key])) {
        if ($this->invoiceItems[$key]['qty'] < $product->stock) {
            $this->invoiceItems[$key]['qty']++;
        } else {
            $this->errorMessage = 'لا توجد كمية كافية من هذا المنتج في المخزون.';
            return;
        }
    } else {
        $this->invoiceItems[$key] = [
            'product_id'  => $product->id,
            'category_id' => $product->category_id,
            'name'        => $product->name,
            'barcode'     => $product->barcode,
            'price'       => $product->sale_price,
            'qty'         => 1,
        ];
    }

    $this->calculateTotal();
    $this->errorMessage = '';
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

    /** تحديث السعر */
    public function updatePrice($key, $newPrice)
    {
        $newPrice = floatval($newPrice);

        if ($newPrice <= 0) {
            $this->errorMessage = 'السعر يجب أن يكون أكبر من صفر.';
            return;
        }

        if (isset($this->invoiceItems[$key])) {
            $this->invoiceItems[$key]['price'] = $newPrice;
        }

        $this->calculateTotal();
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
                    'barcode'        => $item['barcode'],
                    'qty'            => $item['qty'],
                    'price'          => $item['price'],
                    'total'          => $item['price'] * $item['qty'],
                    'sold_at'        => now(),
                ]);

                // تحديث المخزون
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('stock', $item['qty']);
                }
            }

            DB::commit();

            $this->reset([
                'invoiceItems', 'barcodeInput', 'selectedCategory',
                'products', 'grandTotal', 'customerName'
            ]);

            session()->flash('success', 'تم إنشاء الفاتورة بنجاح!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorMessage = 'حدث خطأ أثناء حفظ الفاتورة: ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.InvoiceCreate');
    }
}
