@extends('layouts.Cashier')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white shadow rounded p-6">
        <!-- رأس الصفحة -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">الفواتير</h1>
            <a href="{{ route('invoices.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                + إضافة فاتورة
            </a>
        </div>

        <!-- رسالة نجاح -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- لا توجد فواتير -->
        @if($invoices->isEmpty())
            <p class="text-gray-600">لا توجد فواتير حالياً.</p>
        @else
            <!-- جدول الفواتير -->
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border">
                    <thead class="bg-gray-50">
                        <tr class="text-left">
                            <th class="border px-3 py-2">#</th>
                            <th class="border px-3 py-2">رقم الفاتورة</th>
                            <th class="border px-3 py-2">اسم العميل</th>
                            <th class="border px-3 py-2">عدد المنتجات</th>
                            <th class="border px-3 py-2">الإجمالي</th>
                            <th class="border px-3 py-2">تاريخ البيع</th>
                            <th class="border px-3 py-2 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $index => $invoice)
                        <tr class="hover:bg-gray-50 
                            @if($invoice->returned_count == $invoice->items_count && $invoice->items_count > 0) bg-red-200 font-bold
                            @elseif($invoice->returned_count > 0) bg-yellow-100 font-semibold
                            @endif
                        ">
                            <td class="border px-3 py-2">{{ $invoices->firstItem() + $loop->index }}</td>
                            <td class="border px-3 py-2 font-semibold">{{ $invoice->invoice_number }}</td>
                            <td class="border px-3 py-2">{{ $invoice->customer_name ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $invoice->items_count }}</td>
                            <td class="border px-3 py-2 font-semibold">{{ number_format($invoice->total_amount, 2) }}</td>
                            <td class="border px-3 py-2">{{ \Carbon\Carbon::parse($invoice->last_sold_at)->format('Y-m-d') }}</td>
                            <td class="border px-3 py-2 text-center flex items-center justify-center gap-2">
                                <a href="{{ route('invoices.show', $invoice->invoice_number) }}" 
                                   class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                   عرض المنتجات
                                </a>

                                <!-- حالة الإرجاع -->
                                @if($invoice->returned_count == $invoice->items_count && $invoice->items_count > 0)
                                    <span class="text-red-600 font-bold">مرتجع كامل</span>
                                @elseif($invoice->returned_count > 0)
                                    <span class="text-yellow-600 font-semibold">مرتجع جزئي</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- الترقيم الصفحات -->
                <div class="mt-4">
                    {{ $invoices->links() }}
                </div>
            </div>
        @endif
    </div>
</main>
@endsection
