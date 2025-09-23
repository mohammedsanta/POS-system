{{-- resources/views/admin/products.blade.php --}}
@extends('layouts.admin')

@section('title', 'المنتجات')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto">
        <!-- العنوان -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">قائمة المنتجات</h1>
            <a href="{{ route('products.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
                + إضافة منتج
            </a>
        </div>

        <!-- جدول المنتجات -->
        <div class="bg-white rounded-2xl shadow p-6 overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 text-center">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">الاسم</th>
                        <th class="px-4 py-2 border">الماركة</th>
                        <th class="px-4 py-2 border">الموديل</th>
                        <th class="px-4 py-2 border">الباركود</th>
                        <th class="px-4 py-2 border">سعر الشراء</th>
                        <th class="px-4 py-2 border">سعر البيع</th>
                        <th class="px-4 py-2 border">المخزون</th>
                        <th class="px-4 py-2 border">الوصف</th>
                        <th class="px-4 py-2 border">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border">{{ $product->id }}</td>
                            <td class="px-4 py-2 border">{{ $product->name }}</td>
                            <td class="px-4 py-2 border">{{ $product->brand }}</td>
                            <td class="px-4 py-2 border">{{ $product->model }}</td>
                            <td class="px-4 py-2 border">{{ $product->barcode ?? '—' }}</td>
                            <td class="px-4 py-2 border">{{ $product->purchase_price }}</td>
                            <td class="px-4 py-2 border">{{ $product->sale_price }}</td>
                            <td class="px-4 py-2 border">{{ $product->stock }}</td>
                            <td class="px-4 py-2 border">{{ $product->description }}</td>
                            <td class="px-4 py-2 border space-x-2">
                                <!-- زر تعديل -->
                                <a href="{{ route('products.edit', $product->id) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg">
                                    تعديل
                                </a>

                                <!-- زر حذف -->
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('هل أنت متأكد من الحذف؟')" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg">
                                        حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-2 border text-gray-500">
                                لا توجد منتجات متاحة
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
