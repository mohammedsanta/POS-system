@extends('layouts.Cashier')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">المصاريف</h1>

    <a href="{{ route('expenses.create') }}" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">
        + إضافة مصروف
    </a>

    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-50 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2 border">#</th>
                <th class="p-2 border">العنوان</th>
                <th class="p-2 border">المبلغ</th>
                <th class="p-2 border">تاريخ المصروف</th>
                <th class="p-2 border">ملاحظات</th>
                <th class="p-2 border text-center">التحكم</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
            <tr>
                <td class="p-2 border">{{ $loop->iteration }}</td>
                <td class="p-2 border">{{ $expense->title }}</td>
                <td class="p-2 border">ج.م {{ number_format($expense->amount,2) }}</td>
                <td class="p-2 border">{{ $expense->expense_date }}</td>
                <td class="p-2 border">{{ $expense->notes ?? '-' }}</td>
                <td class="p-2 border text-center">
                    <a href="{{ route('expenses.edit', $expense->id) }}" class="text-blue-600 hover:underline mr-2">تعديل</a>
                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="inline-block"
                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المصروف؟');">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">حذف</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center p-4 text-gray-500">لا توجد مصاريف</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $expenses->links() }}
    </div>
</div>
@endsection
