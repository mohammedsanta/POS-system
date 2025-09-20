<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest()->paginate(10);
        return view('staff.expenses.index', compact('expenses'));
    }

    public function indexAdmin()
    {
        $expenses = Expense::latest()->paginate(10);
        return view('admin.expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('staff.expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'expense_date' => 'required|date',
        ]);

        Expense::create($request->all());

        return redirect()->route('expenses.index')->with('success', 'تم إضافة المصروف بنجاح.');
    }

    public function edit(Expense $expense)
    {
        return view('staff.expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'expense_date' => 'required|date',
        ]);

        $expense->update($request->all());

        return redirect()->route('expenses.index')->with('success', 'تم تعديل المصروف بنجاح.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'تم حذف المصروف.');
    }

}
