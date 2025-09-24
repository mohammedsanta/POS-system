{{-- resources/views/staff/invoices/index.blade.php --}}
@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto space-y-8">

        <h2 class="text-2xl font-bold text-gray-800 mb-4">إدارة الفواتير</h2>

        {{-- الفلاتر --}}
        <form method="GET" action="{{ route('admin.invoices.index') }}" class="grid sm:grid-cols-3 gap-4 bg-white p-4 rounded shadow">
            {{-- فلتر اليوم --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">تاريخ اليوم</label>
                <input type="date" name="day" value="{{ request('day') }}" class="w-full border rounded p-2">
            </div>

            {{-- فلتر الشهر --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">الشهر</label>
                <input type="month" name="month" value="{{ request('month') }}" class="w-full border rounded p-2">
            </div>

            {{-- زر البحث --}}
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 w-full">
                    بحث
                </button>
            </div>
        </form>

        {{-- جدول الفواتير --}}
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3">رقم الفاتورة</th>
                        <th class="px-4 py-3">اسم المنتج</th>
                        <th class="px-4 py-3">اسم العميل</th>
                        <th class="px-4 py-3">الكمية</th>
                        <th class="px-4 py-3">السعر</th>
                        <th class="px-4 py-3">الإجمالي</th>
                        <th class="px-4 py-3">تاريخ البيع</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($invoices as $invoice)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $invoice->invoice_number }}</td>
                            <td class="px-4 py-3">{{ $invoice->product_name }}</td>
                            <td class="px-4 py-3">{{ $invoice->customer_name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $invoice->qty }}</td>
                            <td class="px-4 py-3">{{ number_format($invoice->price, 2) }} ج.م</td>
                            <td class="px-4 py-3 font-bold">{{ number_format($invoice->total, 2) }} ج.م</td>
                            <td class="px-4 py-3">{{ $invoice->sold_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">لا توجد فواتير</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- روابط الصفحات --}}
        <div class="mt-4">
            {{ $invoices->withQueryString()->links() }}
        </div>

    </div>
</main>
@endsection
