@extends('layouts.Cashier')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow mt-6">

    <h1 class="text-2xl font-bold mb-6 text-center">إضافة مصروف جديد</h1>

    {{-- رسائل الأخطاء --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 text-red-700 border border-red-100 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('expenses.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-semibold text-gray-700">عنوان المصروف</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">المبلغ</label>
            <input type="number" name="amount" step="0.01" value="{{ old('amount') }}" required
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">تاريخ المصروف</label>
            <input type="date" name="expense_date" value="{{ old('expense_date') }}" required
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">ملاحظات</label>
            <textarea name="notes" rows="3"
                      class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                      placeholder="أي ملاحظات إضافية">{{ old('notes') }}</textarea>
        </div>

        <div class="flex justify-end mt-4">
            <a href="{{ route('expenses.index') }}" class="text-gray-600 hover:underline mr-4">رجوع</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">
                حفظ المصروف
            </button>
        </div>
    </form>
</div>
@endsection
