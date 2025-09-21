<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commitment;

class CommitmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('owner'); // المالك فقط
    }

    public function index(Request $request)
    {
        $query = Commitment::query();

        if ($request->filled('from')) {
            $from = $request->from . '-01'; // بداية الشهر
            $query->where('month', '>=', $from);
        }

        if ($request->filled('to')) {
            $to = $request->to . '-01'; // بداية الشهر المطلوب
            $query->where('month', '<=', $to);
        }

        $commitments = $query->orderBy('month', 'desc')->get();
        $total = $commitments->sum('amount');

        return view('admin.commitments.index', compact('commitments', 'total'));
    }



    public function create()
    {
        return view('admin.commitments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric',
            'month'       => 'required|date_format:Y-m',
        ]);

        Commitment::create($validated);

        return redirect()->route('admin.commitments.index')
                         ->with('success', 'تم إضافة الالتزام بنجاح.');
    }

    public function edit(Commitment $commitment)
    {
        return view('admin.commitments.edit', compact('commitment'));
    }

    public function update(Request $request, Commitment $commitment)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric',
            'month'       => 'required|date_format:Y-m',
        ]);

        $commitment->update($validated);

        return redirect()->route('admin.commitments.index')
                         ->with('success', 'تم تحديث الالتزام بنجاح.');
    }

    public function destroy(Commitment $commitment)
    {
        $commitment->delete();
        return redirect()->route('admin.commitments.index')
                         ->with('success', 'تم حذف الالتزام بنجاح.');
    }
}
