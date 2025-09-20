@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">جميع المشتريات</h1>

            <a href="{{ route('purchases.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                + إضافة عملية شراء
            </a>
        </div>

        {{-- رسائل النجاح --}}
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-50 border border-green-100 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-3 border">#</th>
                    <th class="p-3 border">رقم الفاتورة</th>
                    <th class="p-3 border">المورّد</th>
                    <th class="p-3 border">الإجمالي</th>
                    <th class="p-3 border">عدد العناصر</th>
                    <th class="p-3 border text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $purchase)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border">{{ $purchase->id }}</td>
                        <td class="p-3 border">{{ $purchase->invoice_number }}</td>
                        <td class="p-3 border">{{ $purchase->supplier_name }}</td>
                        <td class="p-3 border">{{ number_format($purchase->total, 2) }}</td>
                        <td class="p-3 border">{{ $purchase->items_count }}</td>
                        <td class="p-3 border text-center">
                            {{-- إدارة العناصر --}}
                            <a href="{{ route('purchase-items.index', $purchase->id) }}"
                               class="text-indigo-600 hover:underline mr-2">
                                عرض العناصر
                            </a>

                            {{-- تعديل --}}
                            <a href="{{ route('purchases.edit', $purchase->id) }}"
                               class="text-blue-600 hover:underline mr-2">
                                تعديل
                            </a>

                            {{-- حذف --}}
                            <form action="{{ route('purchases.destroy', $purchase->id) }}"
                                  method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذه العملية؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">
                                    حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">
                            لا توجد مشتريات مسجلة.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
