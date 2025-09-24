{{-- resources/views/admin/products/search-barcode.blade.php --}}
@extends('layouts.Cashier')

@section('title', 'بحث عن منتج بالباركود')

@section('content')
<div class="max-w-3xl mx-auto bg-gradient-to-b from-gray-50 to-white shadow-xl rounded-2xl p-10 border border-gray-200">

    {{-- العنوان --}}
    <h2 class="text-3xl font-extrabold mb-8 text-center text-indigo-700">
        🔍 البحث عن منتج بالباركود
    </h2>

    {{-- الرسائل --}}
    @if(session('error'))
        <div class="mb-6 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800 text-center font-semibold">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800 text-center font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- نموذج البحث --}}
    <form method="POST" action="{{ route('products.search') }}" class="flex flex-col md:flex-row items-center gap-4">
        @csrf
        <input type="text" name="barcode" placeholder="أدخل الباركود هنا"
               class="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-right"
               value="{{ old('barcode') }}">
        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 transition-all duration-200 text-white px-8 py-3 rounded-lg shadow font-bold text-lg">
            بحث
        </button>
    </form>

    {{-- عرض المنتج --}}
    @if(session('product'))
        @php $product = session('product'); @endphp
        <div class="mt-10 border-t pt-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">📦 تفاصيل المنتج</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-lg">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                    <strong class="text-indigo-700">الاسم:</strong>
                    <span class="block mt-1 text-gray-800">{{ $product->name }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                    <strong class="text-indigo-700">سعر الشراء:</strong>
                    <span class="block mt-1 text-gray-800">{{ $product->purchase_price }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                    <strong class="text-indigo-700">سعر البيع:</strong>
                    <span class="block mt-1 text-gray-800">{{ $product->sale_price }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                    <strong class="text-indigo-700">التصنيف:</strong>
                    <span class="block mt-1 text-gray-800">{{ $product->category->name ?? 'غير محدد' }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm md:col-span-2">
                    <strong class="text-indigo-700">الباركود:</strong>
                    <span class="block mt-1 text-gray-800">{{ $product->barcode }}</span>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
