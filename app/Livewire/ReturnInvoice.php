<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\ProductBarcode;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReturnInvoice extends Component
{
    public $invoiceNumber;        // number entered by user
    public $invoice;              // Collection of invoice rows for that number
    public $selectedItems = [];   // selected invoice row IDs for partial return
    public $returnAll = false;    // checkbox: full invoice return
    public $message = '';         // success message
    public $errorMessage = '';    // generic error message

    protected $rules = [
        'invoiceNumber' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->invoice = collect();
        $this->selectedItems = [];
        $this->returnAll = false;
        $this->message = '';
        $this->errorMessage = '';
    }

    /**
     * Load invoice rows by invoice_number (called when user presses Search).
     */
    public function searchInvoice()
    {
        $this->resetStateBeforeSearch();

        // validate invoiceNumber
        $this->validateOnly('invoiceNumber');

        // attempt to load invoice rows with barcode relation to avoid N+1
        $items = Invoice::with('barcode')
            ->where('invoice_number', $this->invoiceNumber)
            ->orderBy('id')
            ->get();

        if ($items->isEmpty()) {
            $this->addError('invoiceNumber', 'لم يتم العثور على فاتورة بهذا الرقم.');
            $this->invoice = collect();
            return;
        }

        $this->invoice = $items;
    }

    /**
     * Process the return (full invoice or selected items).
     * Robust checks to prevent re-returning.
     */
    public function processReturn()
    {
        $this->resetErrorBag();
        $this->message = '';
        $this->errorMessage = '';

        // must have loaded invoice first
        if (!$this->invoice || $this->invoice->isEmpty()) {
            $this->addError('invoice', 'الرجاء البحث عن الفاتورة أولاً.');
            return;
        }

        // Transaction for safety
        DB::beginTransaction();
        try {
            if ($this->returnAll) {
                // If any item already returned -> block full return to avoid double returning
                $alreadyReturned = $this->invoice->filter->is_returned;
                if ($alreadyReturned->isNotEmpty()) {
                    throw new \Exception('بعض عناصر الفاتورة تم إرجاعها مسبقًا. لإرجاع بقية العناصر استخدم الإرجاع الجزئي.');
                }

                // return all items
                foreach ($this->invoice as $item) {
                    $this->markItemReturned($item);
                }

                $this->message = 'تم إرجاع الفاتورة بالكامل بنجاح.';
            } else {
                // partial return
                if (empty($this->selectedItems)) {
                    $this->addError('selectedItems', 'الرجاء اختيار عنصر واحد على الأقل للإرجاع.');
                    DB::rollBack();
                    return;
                }

                // ensure chosen IDs exist in current invoice and none already returned
                $selected = $this->invoice->whereIn('id', $this->selectedItems);

                if ($selected->count() !== count($this->selectedItems)) {
                    throw new \Exception('تم اختيار عناصر غير صالحة أو غير مرتبطة بهذه الفاتورة.');
                }

                $already = $selected->filter->is_returned;
                if ($already->isNotEmpty()) {
                    $names = $already->pluck('product_name')->join(', ');
                    throw new \Exception("بعض العناصر المحددة تم إرجاعها مسبقًا: {$names}.");
                }

                // perform return on selected items
                foreach ($selected as $item) {
                    $this->markItemReturned($item);
                }

                $this->message = 'تم إرجاع العناصر المحددة بنجاح.';
            }

            DB::commit();

            // reload invoice to reflect changes
            $this->refreshInvoice();

            // clear selection and returnAll after success
            $this->selectedItems = [];
            $this->returnAll = false;
        } catch (ValidationException $ve) {
            DB::rollBack();
            throw $ve; // let Livewire display field errors
        } catch (\Exception $e) {
            DB::rollBack();
            // set error messages (also add to validation bag for display)
            $this->errorMessage = $e->getMessage();
            $this->addError('return', $e->getMessage());
        }
    }

    /**
     * Mark single invoice row as returned and release barcode (if any).
     * Throws exception on unexpected state.
     */
    private function markItemReturned(Invoice $item)
    {
        // re-fetch fresh row inside transaction to avoid stale state
        $fresh = Invoice::with('barcode')->find($item->id);
        if (!$fresh) {
            throw new \Exception("العنصر برقم {$item->id} غير موجود.");
        }

        if ($fresh->is_returned) {
            throw new \Exception("العنصر {$fresh->product_name} (ID: {$fresh->id}) تم إرجاعه مسبقًا.");
        }

        // mark invoice row returned
        $fresh->update(['is_returned' => true]);

        // if there's a barcode associated, mark it unsold (available) — handle gracefully if barcode missing
        if ($fresh->barcode_id) {
            $barcode = ProductBarcode::find($fresh->barcode_id);
            if ($barcode) {
                // Only change if it was marked sold previously; we won't throw if it's already false
                $barcode->sold = false;
                $barcode->save();
            }
        }
    }

    /**
     * Refresh internal invoice data from DB.
     */
    private function refreshInvoice()
    {
        $this->invoice = Invoice::with('barcode')
            ->where('invoice_number', $this->invoiceNumber)
            ->orderBy('id')
            ->get();
    }

    /**
     * Reset state before new search.
     */
    private function resetStateBeforeSearch()
    {
        $this->selectedItems = [];
        $this->returnAll = false;
        $this->message = '';
        $this->errorMessage = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.return-invoice');
    }
}
