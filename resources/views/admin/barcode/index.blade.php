@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto bg-white rounded-lg shadow p-6">

        {{-- العنوان والأزرار --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-center flex-1">باركود المنتجات</h1>

            <div class="flex gap-2">
                {{-- زر إنشاء باركود جديد --}}
                <a href="{{ route('admin.products.barcode.add') }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                   + إضافة باركود
                </a>

                {{-- زر زيادة الكمية --}}
                <a href="{{ route('barcode.increase') }}" 
                   class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                   + زيادة الكمية
                </a>
            </div>
        </div>

        {{-- نموذج البحث --}}
        <form method="GET" class="mb-4 flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="ابحث بالمنتج أو الفئة أو الباركود"
                   class="border rounded px-3 py-2 flex-1">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                بحث
            </button>
            <a href="{{ route('admin.products.barcodes') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                إعادة تعيين
            </a>
        </form>

        {{-- رسالة النجاح --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- جدول الباركودات --}}
        <table class="w-full border-collapse text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border px-3 py-2">#</th>
                    <th class="border px-3 py-2">الفئة</th>
                    <th class="border px-3 py-2">المنتج</th>
                    <th class="border px-3 py-2">الباركود</th>
                    <th class="border px-3 py-2">الكمية</th>
                    <th class="border px-3 py-2">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barcodes as $index => $barcode)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : '' }}">
                        <td class="border px-3 py-2">{{ $barcodes->firstItem() + $index }}</td>
                        <td class="border px-3 py-2">{{ $barcode->category->name ?? '-' }}</td>
                        <td class="border px-3 py-2">{{ $barcode->product->name ?? '-' }}</td>
                        <td class="border px-3 py-2">{{ $barcode->barcode }}</td>
                        <td class="border px-3 py-2">{{ $barcode->quantity ?? '-' }}</td>
                        <td class="border px-3 py-2 space-x-2">
                            <a href="{{ route('admin.products.barcode.edit', $barcode->id) }}" 
                               class="text-blue-600 hover:underline">تعديل</a>
                            <form action="{{ route('barcodes.destroy', $barcode->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('هل أنت متأكد من الحذف؟');" 
                                        class="text-red-600 hover:underline">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border px-3 py-2 text-center text-gray-500">
                            لا توجد باركودات مسجلة.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- ترقيم الصفحات --}}
        <div class="mt-4">
            {{ $barcodes->withQueryString()->links() }}
        </div>

    </div>
</main>
@endsection
