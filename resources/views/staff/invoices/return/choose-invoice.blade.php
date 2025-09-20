@extends('layouts.Cashier')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">اختر فاتورة للإرجاع</h1>
            <a href="{{ route('returns.index') }}"
               class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
                ← العودة لقائمة المرتجعات
            </a>
        </div>

        {{-- البحث --}}
        <form method="GET" action="{{ route('returns.chooseInvoice') }}" class="mb-4">
            <div class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="flex-1 px-4 py-2 border rounded"
                       placeholder="ابحث برقم الفاتورة">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                    بحث
                </button>
            </div>
        </form>

        @if($invoices->isEmpty())
            <div class="bg-white p-6 rounded shadow text-center text-gray-600">
                لا توجد فواتير.
            </div>
        @else
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="w-full text-sm text-center">
                    <thead class="bg-gray-50">
                        <tr class="text-gray-600">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">رقم الفاتورة</th>
                            <th class="px-4 py-3">عدد العناصر</th>
                            <th class="px-4 py-3">عدد المرتجع</th>
                            <th class="px-4 py-3">إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $idx => $invoiceRow)
                            @php
                                $items = \App\Models\Invoice::where('invoice_number', $invoiceRow->invoice_number)->get();
                                $countAll = $items->count();
                                $countReturned = $items->where('is_returned', true)->count();
                            @endphp
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $invoices->firstItem() + $idx }}</td>
                                <td class="px-4 py-3 font-medium">{{ $invoiceRow->invoice_number }}</td>
                                <td class="px-4 py-3">{{ $countAll }}</td>
                                <td class="px-4 py-3">{{ $countReturned }}</td>
                                <td class="px-4 py-3">
                                    @if($countAll === $countReturned)
                                        <span class="text-gray-500">تم إرجاع الفاتورة بالكامل</span>
                                    @else
                                        <a href="{{ route('returns.show', $invoiceRow->invoice_number) }}"
                                           class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                                            متابعة الإرجاع
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
