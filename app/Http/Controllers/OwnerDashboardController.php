<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\OtherInvoice;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OwnerDashboardController extends Controller
{

    public function index()
    {
        // Dates
        $today = Carbon::today();
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();

        // === Today ===
        $salesToday = (float) Invoice::whereDate('sold_at', $today)
            ->where('is_returned', false)
            ->sum('total');

        $invoicesToday = Invoice::whereDate('sold_at', $today)
            ->where('is_returned', false)
            ->count();

        $returnsToday = (float) Invoice::whereDate('sold_at', $today)
            ->where('is_returned', true)
            ->sum('total');

        $expensesToday = (float) Expense::whereDate('expense_date', $today)
            ->sum('amount');

        // === This week ===
        $weeklySales = (float) Invoice::whereBetween('sold_at', [$startWeek, $endWeek])
            ->where('is_returned', false)
            ->sum('total');

        $weeklyReturns = (float) Invoice::whereBetween('sold_at', [$startWeek, $endWeek])
            ->where('is_returned', true)
            ->sum('total');

        $weeklyExpenses = (float) Expense::whereBetween('expense_date', [$startWeek, $endWeek])
            ->sum('amount');

        // إجمالي المبالغ اليوم
        $otherInvoicesToday = OtherInvoice::whereDate('created_at', today())->sum('total');

        // إجمالي المبالغ هذا الأسبوع
        $otherInvoicesWeekly = OtherInvoice::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->sum('total');

        // عدد الفواتير (لو محتاجه)
        $otherInvoicesCountToday = OtherInvoice::whereDate('created_at', today())->count();
        $otherInvoicesCountWeekly = OtherInvoice::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();


        // === Overall totals ===
        $totalSales = (float) Invoice::where('is_returned', false)->sum('total');

        // === Low stock count ===
        if (Schema::hasColumn('products', 'stock')) {
            $lowStockCount = Product::where('stock', '<', 10)->count();
        } elseif (Schema::hasColumn('products', 'quantity')) {
            $lowStockCount = Product::where('quantity', '<', 10)->count();
        } else {
            $lowStockCount = 0;
        }

        // === Top selling products ===
        $topProducts = Invoice::join('products', 'invoices.product_id', '=', 'products.id')
            ->select(
                'products.name as name',
                DB::raw('SUM(invoices.qty) as units_sold'),
                DB::raw('SUM(invoices.total) as revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('units_sold')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'salesToday',
            'invoicesToday',
            'returnsToday',
            'expensesToday',
            'weeklySales',
            'weeklyReturns',
            'weeklyExpenses',
            'totalSales',
            'lowStockCount',
            'topProducts',
            'otherInvoicesToday',
            'otherInvoicesWeekly',
            'otherInvoicesCountToday',
            'otherInvoicesCountWeekly',
        ));
    }

}
