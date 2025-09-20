{{-- resources/views/staff/expenses/edit.blade.php --}}
@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">

        <h1 class="text-2xl font-bold mb-6 text-center">تعديل المصروف</h1>

        {{-- رسائل الخطأ --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 text-red-700 border border-red-200 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('expenses.update', $expense->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- عنوان المصروف --}}
            <div>
                <label class="block mb-1 font-semibold text-gray-700">عنوان المصروف</label>
                <input type="text" name="title" value="{{ old('title', $expense->title) }}" required
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- المبلغ --}}
            <div>
                <label class="block mb-1 font-semibold text-gray-700">المبلغ</label>
                <input type="number" name="amount" step="0.01" value="{{ old('amount', $expense->amount) }}" required
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- تاريخ المصروف --}}
            <div>
                <label class="block mb-1 font-semibold text-gray-700">تاريخ المصروف</label>
                <input type="date" name="expense_date" 
                       value="{{ old('expense_date', $expense->expense_date) }}" required
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- ملاحظات --}}
            <div>
                <label class="block mb-1 font-semibold text-gray-700">ملاحظات</label>
                <textarea name="notes" rows="3"
                          class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                          placeholder="أي ملاحظات إضافية">{{ old('notes', $expense->notes) }}</textarea>
            </div>

            {{-- الأزرار --}}
            <div class="flex justify-end mt-4">
                <a href="{{ route('expenses.index') }}" class="text-gray-600 hover:underline mr-4">رجوع</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
                    تحديث المصروف
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
