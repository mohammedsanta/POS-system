@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-lg mx-auto bg-white rounded shadow p-6">
        <h1 class="text-xl font-bold mb-4">
            تعديل عنصر لعملية الشراء رقم #{{ $purchase->id }}
        </h1>

        {{-- رسائل الخطأ --}}
        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-red-50 border border-red-100 text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('purchase-items.update', [$purchase->id, $item->id]) }}"
              class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 text-sm font-medium">اسم العنصر</label>
                <input type="text" name="item_name"
                       value="{{ old('item_name', $item->item_name) }}"
                       class="border rounded w-full px-3 py-2" required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">العلامة التجارية</label>
                <input type="text" name="brand"
                       value="{{ old('brand', $item->brand) }}"
                       class="border rounded w-full px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">IMEI</label>
                <input type="text" name="imei"
                       value="{{ old('imei', $item->imei) }}"
                       class="border rounded w-full px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">الكمية</label>
                <input type="number" name="qty" min="1"
                       value="{{ old('qty', $item->qty) }}"
                       class="border rounded w-full px-3 py-2" required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">السعر</label>
                <input type="number" name="price" step="0.01"
                       value="{{ old('price', $item->price) }}"
                       class="border rounded w-full px-3 py-2" required>
            </div>

            <div class="flex justify-between mt-4">
                <a href="{{ route('purchase-items.index', $purchase->id) }}"
                   class="text-gray-600 hover:underline">← رجوع</a>

                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    تحديث العنصر
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
