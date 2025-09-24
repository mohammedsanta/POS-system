@extends('layouts.Cashier')

@section('content')
<main class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-6xl mx-auto">

        {{-- رأس الصفحة --}}
        <h2 class="text-2xl font-bold mb-6 text-center">
            أهلاً بك، موظف الكاشير 👋
        </h2>

        {{-- إحصائيات سريعة --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-6 gap-6 mb-8">
            <div class="bg-white p-6 rounded shadow text-center">
                <h4 class="text-lg font-semibold mb-2">مجموع المبيعات اليوم</h4>
                <p class="text-2xl font-bold text-green-600">EGP {{ number_format($totalSales, 2) }}</p>
            </div>

            {{-- صندوق فواتير أخرى --}}
            <div class="bg-white p-6 rounded shadow text-center">
                <h4 class="text-lg font-semibold mb-2">فواتير أخرى اليوم</h4>
                <p class="text-2xl font-bold text-purple-600">EGP {{ number_format($otherInvoicesTotal, 2) }}</p>
            </div>

            <div class="bg-white p-6 rounded shadow text-center">
                <h4 class="text-lg font-semibold mb-2">عدد الفواتير اليوم</h4>
                <p class="text-2xl font-bold text-blue-600">{{ $invoiceCount }}</p>
            </div>

            <div class="bg-white p-6 rounded shadow text-center">
                <h4 class="text-lg font-semibold mb-2">المنتجات المرتجعة</h4>
                <p class="text-2xl font-bold text-red-600">{{ $returnedCount }}</p>
            </div>

            <div class="bg-white p-6 rounded shadow text-center">
                <h4 class="text-lg font-semibold mb-2">مجموع المنتجات المرتجعة</h4>
                <p class="text-2xl font-bold text-red-800">EGP {{ number_format($totalReturned, 2) }}</p>
            </div>

            {{-- صندوق المصروفات اليوم --}}
            <div class="bg-white p-6 rounded shadow text-center">
                <h4 class="text-lg font-semibold mb-2">المصروفات اليوم</h4>
                <p class="text-2xl font-bold text-orange-600">EGP {{ number_format($expensesToday, 2) }}</p>
            </div>
        </div>

        {{-- جدول المبيعات اليوم --}}
        <div class="bg-white p-6 rounded shadow mt-6">
            <h3 class="text-xl font-bold mb-4">مبيعات اليوم</h3>

            <table class="w-full text-sm text-left border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border">#</th>
                        <th class="py-2 px-4 border">المنتج</th>
                        <th class="py-2 px-4 border">العميل</th>
                        <th class="py-2 px-4 border">المبلغ</th>
                        <th class="py-2 px-4 border">الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- المبيعات العادية --}}
                    @foreach($salesToday as $index => $sale)
                    <tr class="border-b">
                        <td class="py-2 px-4 border">{{ $index + 1 }}</td>
                        <td class="py-2 px-4 border">{{ $sale->product_name }}</td>
                        <td class="py-2 px-4 border">{{ $sale->customer_name ?? '—' }}</td>
                        <td class="py-2 px-4 border">EGP {{ number_format($sale->total, 2) }}</td>
                        <td class="py-2 px-4 border
                            {{ $sale->status == 'تم البيع' ? 'text-green-600 font-bold' : ($sale->status == 'مرتجع جزئي' ? 'text-yellow-600 font-bold' : 'text-red-600 font-bold') }}">
                            {{ $sale->status }}
                        </td>
                    </tr>
                    @endforeach

                    {{-- المبيعات الأخرى --}}
                    @foreach($otherSalesToday as $otherIndex => $other)
                    <tr class="border-b bg-purple-50">
                        <td class="py-2 px-4 border">O-{{ $otherIndex + 1 }}</td>
                        <td class="py-2 px-4 border">فاتورة أخرى</td>
                        <td class="py-2 px-4 border">{{ $other->customer_name ?? '—' }}</td>
                        <td class="py-2 px-4 border text-purple-600 font-bold">EGP {{ number_format($other->total, 2) }}</td>
                        <td class="py-2 px-4 border text-purple-700 font-semibold">أخرى</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</main>
@endsection
