@extends('layouts.Cashier')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">جميع المرتجعات</h1>

            <a href="{{ route('returns.chooseInvoice') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                + إنشاء إرجاع جديد
            </a>
        </div>

        {{-- نموذج الفلترة --}}
        <form method="GET" action="{{ route('returns.index') }}" class="mb-6">
            <div class="flex flex-wrap gap-3">
                <input type="text" name="invoice_number" value="{{ request('invoice_number') }}"
                       class="px-4 py-2 border rounded w-48"
                       placeholder="بحث برقم الفاتورة">

                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="today" value="1"
                           @checked(request('today'))>
                    <span>إظهار مرتجعات اليوم فقط</span>
                </label>

                <button type="submit"
                        class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded">
                    تطبيق الفلتر
                </button>

                <a href="{{ route('returns.index') }}"
                   class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">
                    إعادة تعيين
                </a>
            </div>
        </form>

        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-50 border border-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if($returnedItems->isEmpty())
            <div class="bg-white p-6 rounded shadow text-gray-600 text-center">
                لا توجد أي مرتجعات مطابقة للبحث.
            </div>
        @else
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="w-full text-sm text-center">
                    <thead class="bg-gray-50">
                        <tr class="text-gray-600">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">رقم الفاتورة</th>
                            <th class="px-4 py-3">اسم المنتج</th>
                            <th class="px-4 py-3">الكمية المرتجعة</th>
                            <th class="px-4 py-3">تاريخ الإرجاع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($returnedItems as $idx => $item)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $returnedItems->firstItem() + $idx }}</td>
                                <td class="px-4 py-3 font-medium">{{ $item->invoice_number }}</td>
                                <td class="px-4 py-3">{{ $item->product_name }}</td>
                                <td class="px-4 py-3">{{ $item->qty }}</td>
                                <td class="px-4 py-3">{{ $item->updated_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $returnedItems->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
