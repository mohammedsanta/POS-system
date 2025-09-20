<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnInvoiceController extends Controller
{
    /** عرض جميع الفواتير التي بها مرتجعات */
    public function index(Request $request)
    {
        $query = Invoice::where('is_returned', true);

        // فلتر حسب تاريخ اليوم
        if ($request->filled('today')) {
            $query->whereDate('updated_at', today());
        }

        // فلتر حسب رقم الفاتورة
        if ($request->filled('invoice_number')) {
            $query->where('invoice_number', 'like', "%{$request->invoice_number}%");
        }

        $returnedItems = $query->orderBy('updated_at', 'desc')->paginate(15);

        return view('staff.invoices.return.index', compact('returnedItems'));
    }



    /** عرض تفاصيل فاتورة معينة */
    public function show($invoice_number)
    {
        $items = Invoice::where('invoice_number', $invoice_number)
            ->with('barcode')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('returns.index')
                ->withErrors(['not_found' => 'لم يتم العثور على هذه الفاتورة.']);
        }

        // Build a collection that adds a flag for each row
        $itemsWithFlags = $items->map(function ($item) {
            $item->can_return = !$item->is_returned; // true only if item not returned
            return $item;
        });

        // Check if at least one item can be returned
        $hasPending = $itemsWithFlags->contains(fn($i) => $i->can_return);

        return view('staff.invoices.return.show', [
            'invoice_number' => $invoice_number,
            'invoiceItems'   => $itemsWithFlags,
            'hasPending'     => $hasPending,
        ]);
    }

    public function chooseInvoice(Request $request)
    {
        $query = Invoice::select('invoice_number')
            ->groupBy('invoice_number')
            ->latest();

        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', "%{$request->search}%");
        }

        $invoices = $query->paginate(10);

        return view('staff.invoices.return.choose-invoice', compact('invoices'));
    }

    /** معالجة عملية الإرجاع لعنصر معين */
    public function process(Request $request, $itemId)
    {
        DB::beginTransaction();

        try {
            $item = Invoice::findOrFail($itemId);

            if ($item->is_returned) {
                return back()->with('error', 'هذا العنصر تم إرجاعه مسبقًا.');
            }

            // إذا كان المنتج مربوط بباركود يجب تحريره
            if ($item->barcode_id) {
                $barcode = \App\Models\ProductBarcode::find($item->barcode_id);
                if ($barcode) {
                    $barcode->sold = false;
                    $barcode->save();
                }
            }

            $item->is_returned = true;
            $item->save();

            DB::commit();
            return back()->with('success', 'تم إرجاع العنصر بنجاح.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return back()->with('error', 'العنصر المطلوب غير موجود.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ غير متوقع أثناء الإرجاع: ' . $e->getMessage());
        }
    }

    /** ✅ إرجاع الفاتورة بالكامل */
    public function returnInvoice($invoice_number)
    {
        DB::beginTransaction();

        try {
            $items = Invoice::where('invoice_number', $invoice_number)->get();

            if ($items->isEmpty()) {
                return back()->with('error', 'الفاتورة غير موجودة.');
            }

            foreach ($items as $item) {
                // إذا لم يتم إرجاع العنصر مسبقًا
                if (!$item->is_returned) {
                    if ($item->barcode_id) {
                        $barcode = \App\Models\ProductBarcode::find($item->barcode_id);
                        if ($barcode) {
                            $barcode->sold = false;
                            $barcode->save();
                        }
                    }
                    $item->is_returned = true;
                    $item->save();
                }
            }

            DB::commit();
            return back()->with('success', 'تم إرجاع الفاتورة بالكامل بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء إرجاع الفاتورة: ' . $e->getMessage());
        }
    }
}
