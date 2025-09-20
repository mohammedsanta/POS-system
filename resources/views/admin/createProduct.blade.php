@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">إضافة منتج جديد</h1>

        {{-- ✅ رسالة النجاح --}}
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-50 border border-green-100 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- ❌ رسائل الأخطاء --}}
        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-red-50 border border-red-100 text-red-700 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" class="grid grid-cols-1 gap-4">
            @csrf

            {{-- اسم المنتج --}}
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   placeholder="اسم المنتج"
                   required
                   class="border rounded px-3 py-2 @error('name') border-red-500 @enderror">

            {{-- العلامة التجارية --}}
            <input type="text"
                   name="brand"
                   value="{{ old('brand') }}"
                   placeholder="العلامة التجارية"
                   class="border rounded px-3 py-2">

            {{-- ✅ قائمة الفئات --}}
            <select name="category_id" required
                    class="border rounded px-3 py-2 @error('category_id') border-red-500 @enderror">
                <option value="">-- اختر الفئة --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            {{-- الموديل --}}
            <input type="text"
                   name="model"
                   value="{{ old('model') }}"
                   placeholder="الموديل"
                   class="border rounded px-3 py-2">

            {{-- سعر الشراء --}}
            <input type="number"
                   name="purchase_price"
                   value="{{ old('purchase_price') }}"
                   placeholder="سعر الشراء"
                   required
                   class="border rounded px-3 py-2 @error('purchase_price') border-red-500 @enderror">

            {{-- سعر البيع --}}
            <input type="number"
                   name="sale_price"
                   value="{{ old('sale_price') }}"
                   placeholder="سعر البيع"
                   required
                   class="border rounded px-3 py-2 @error('sale_price') border-red-500 @enderror">

            {{-- المخزون --}}
            <input type="number"
                   name="stock"
                   value="{{ old('stock') }}"
                   placeholder="المخزون"
                   required
                   class="border rounded px-3 py-2 @error('stock') border-red-500 @enderror">

            {{-- ✅ قائمة الموردين --}}
            <select name="supplier_id" required
                    class="border rounded px-3 py-2 @error('supplier_id') border-red-500 @enderror">
                <option value="">-- اختر المورد --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>

            {{-- الوصف --}}
            <textarea name="description"
                      placeholder="الوصف"
                      class="border rounded px-3 py-2">{{ old('description') }}</textarea>

            <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                حفظ المنتج
            </button>

            <a href="{{ route('products.index') }}"
               class="text-blue-600 underline text-center">العودة إلى قائمة المنتجات</a>
        </form>
    </div>
</main>
@endsection
