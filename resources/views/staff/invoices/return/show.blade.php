@extends('layouts.Cashier')

@section('content')
<div class="max-w-5xl mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">
        تفاصيل الفاتورة رقم {{ $invoice_number }}
    </h1>

    <table class="w-full text-right border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">#</th>
                <th class="p-2 border">اسم المنتج</th>
                <th class="p-2 border">الباركود</th>
                <th class="p-2 border">الكمية</th>
                @if($hasPending)
                    <th class="p-2 border">إجراء</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($invoiceItems as $index => $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2 border">{{ $index + 1 }}</td>
                    <td class="p-2 border">{{ $item->product_name }}</td>
                    <td class="p-2 border">{{ $item->barcode->barcode ?? '-' }}</td>
                    <td class="p-2 border">{{ $item->qty }}</td>

                    @if($hasPending)
                        <td class="p-2 border">
                            @if($item->can_return)
                                <form method="POST" action="{{ route('returns.process', $item->id) }}">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('هل تريد إرجاع هذا البند؟');"
                                        class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded">
                                        إرجاع البند
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500 text-sm">تم إرجاعه</span>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        <a href="{{ route('returns.index') }}"
           class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded shadow">
            رجوع
        </a>
    </div>
</div>
@endsection
