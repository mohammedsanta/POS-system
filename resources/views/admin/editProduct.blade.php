@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">تعديل المنتج</h1>

        {{-- ❌ رسائل الأخطاء --}}
        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" class="grid grid-cols-1 gap-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold mb-1">اسم المنتج</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">الماركة</label>
                <input type="text" name="brand" value="{{ old('brand', $product->brand) }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">التصنيف</label>
                <select name="category_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- اختر التصنيف --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">الموديل</label>
                <input type="text" name="model" value="{{ old('model', $product->model) }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">سعر الشراء</label>
                <input type="number" name="purchase_price" step="0.01"
                       value="{{ old('purchase_price', $product->purchase_price) }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">سعر البيع</label>
                <input type="number" name="sale_price" step="0.01"
                       value="{{ old('sale_price', $product->sale_price) }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">المخزون</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">المورّد</label>
                <select name="supplier_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- اختر المورّد --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">الوصف</label>
                <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    إلغاء
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    تحديث المنتج
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
