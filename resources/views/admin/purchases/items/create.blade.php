@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-lg mx-auto bg-white rounded shadow p-6">
        <h1 class="text-xl font-bold mb-4">
            إضافة عنصر لعملية الشراء رقم #{{ $purchase->id }}
        </h1>

        {{-- رسائل الأخطاء --}}
        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-red-50 border border-red-100 text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('purchase-items.store', $purchase->id) }}" class="space-y-4">
            @csrf

            {{-- اسم العنصر --}}
            <div>
                <label class="block mb-1 text-sm font-medium">اسم العنصر</label>
                <input type="text" name="item_name" value="{{ old('item_name') }}"
                       class="border rounded w-full px-3 py-2" required>
            </div>

            {{-- العلامة التجارية --}}
            <div>
                <label class="block mb-1 text-sm font-medium">العلامة التجارية</label>
                <input type="text" name="brand" value="{{ old('brand') }}"
                       class="border rounded w-full px-3 py-2">
            </div>

            {{-- IMEI أو الباركود --}}
            <div>
                <label class="block mb-1 text-sm font-medium">IMEI / الباركود</label>
                <input type="text" name="imei" value="{{ old('imei') }}"
                       class="border rounded w-full px-3 py-2">
            </div>

            {{-- الكمية --}}
            <div>
                <label class="block mb-1 text-sm font-medium">الكمية</label>
                <input type="number" name="qty" value="{{ old('qty',1) }}"
                       class="border rounded w-full px-3 py-2" min="1" required>
            </div>

            {{-- سعر الشراء (جملة) --}}
            <div>
                <label class="block mb-1 text-sm font-medium">سعر الشراء (جملة)</label>
                <input type="number" name="price" step="0.01"
                       value="{{ old('price') }}"
                       class="border rounded w-full px-3 py-2" required>
            </div>

            {{-- سعر البيع للزبون --}}
            <div>
                <label class="block mb-1 text-sm font-medium">سعر البيع للزبون</label>
                <input type="number" name="sale_price" step="0.01"
                       value="{{ old('sale_price') }}"
                       class="border rounded w-full px-3 py-2" required>
            </div>

            {{-- أزرار التحكم --}}
            <div class="flex justify-between mt-4">
                <a href="{{ route('purchase-items.index', $purchase->id) }}"
                   class="text-gray-600 hover:underline">← رجوع</a>

                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    حفظ العنصر
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
