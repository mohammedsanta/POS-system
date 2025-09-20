<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        $cashiers = Staff::latest()->paginate(10);
        return view('admin.cashier.index', compact('cashiers'));
    }

    public function dashboard()
    {
    $today = Carbon::today();

    // إجمالي المبيعات قبل خصم المرتجعات
    $totalSalesRaw = Invoice::whereDate('sold_at', $today)->sum('total');

    // مجموع المنتجات المرتجعة
    $totalReturned = Invoice::whereDate('sold_at', $today)
        ->where('is_returned', true)
        ->sum('total');

    // المبيعات الصافية بعد خصم المرتجعات
    $totalSales = $totalSalesRaw - $totalReturned;

    // باقي الإحصائيات
    $invoiceCount = Invoice::whereDate('sold_at', $today)
        ->distinct('invoice_number')
        ->count('invoice_number');

    $returnedCount = Invoice::whereDate('sold_at', $today)
        ->where('is_returned', true)
        ->count();

    // مبيعات اليوم مع الحالة
    $salesToday = Invoice::whereDate('sold_at', $today)
        ->get()
        ->groupBy('invoice_number')
        ->map(function($items) {
            $totalItems = $items->count();
            $returnedItems = $items->where('is_returned', true)->count();

            if ($returnedItems == 0) {
                $status = 'تم البيع';
            } elseif ($returnedItems == $totalItems) {
                $status = 'مرتجع كامل';
            } else {
                $status = 'مرتجع جزئي';
            }

            foreach ($items as $item) {
                $item->status = $status;
            }

            return $items;
        })
        ->flatten();

    $expensesToday = Expense::whereDate('expense_date', today())->sum('amount');


        return view('staff.dashboard', compact(
            'totalSales',
            'invoiceCount',
            'returnedCount',
            'totalReturned',
            'salesToday',
            'expensesToday',
        ));
    }


    public function create()
    {
        return view('admin.cashier.create');
    }

    public function store(Request $request)
    {
        // ✅ التحقق من البيانات
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:staffs,username',
            'password' => 'required|string|min:6',
        ]);

        // ✅ إنشاء سجل جديد (كلمة المرور ستتشفّر تلقائيًا بفضل setPasswordAttribute)
        Staff::create($validated);

        // ✅ إعادة التوجيه مع رسالة نجاح
        return redirect()
            ->route('admin.cashier')
            ->with('success', 'Cashier created successfully.');
    }

    public function edit(Request $request)
    {
        $staff = Staff::find($request->id);
        return view('admin.cashier.edit', compact('staff'));
    }

    public function update(Request $request, Staff $cashier)
    {
        $request->validate([
            'username'   => 'required|string|max:255',
            // 'phone'  => 'nullable|string|max:20',
        ]);

        $cashier->update($request->except(['_token', '_method']));

        return redirect()->route('admin.cashier')
            ->with('success', 'Cashier updated successfully.');
    }

    public function destroy(Staff $cashier)
    {
        $cashier->delete();
        return back()->with('success', 'Cashier deleted.');
    }
}
