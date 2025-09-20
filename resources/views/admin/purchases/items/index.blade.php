@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">
                العناصر الخاصة بعملية الشراء رقم #{{ $purchase->id }}
            </h1>

            <a href="{{ route('purchase-items.create', $purchase->id) }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                + إضافة عنصر
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-50 border border-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">اسم العنصر</th>
                    <th class="p-2 border">العلامة التجارية</th>
                    <th class="p-2 border">IMEI</th>
                    <th class="p-2 border">الكمية</th>
                    <th class="p-2 border">السعر</th>
                    <th class="p-2 border">الإجمالي</th>
                    <th class="p-2 border text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="border p-2">{{ $item->id }}</td>
                        <td class="border p-2">{{ $item->item_name }}</td>
                        <td class="border p-2">{{ $item->brand }}</td>
                        <td class="border p-2">{{ $item->imei }}</td>
                        <td class="border p-2">{{ $item->qty }}</td>
                        <td class="border p-2">{{ number_format($item->price, 2) }}</td>
                        <td class="border p-2">{{ number_format($item->qty * $item->price, 2) }}</td>
                        <td class="border p-2 text-center">
                            <a href="{{ route('purchase-items.edit', [$purchase->id, $item->id]) }}"
                               class="text-blue-600 hover:underline mr-2">
                                تعديل
                            </a>

                            <form action="{{ route('purchase-items.destroy', [$purchase->id, $item->id]) }}"
                                  method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا العنصر؟');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">
                                    حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-gray-500 p-4">
                            لا توجد عناصر مسجلة.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
