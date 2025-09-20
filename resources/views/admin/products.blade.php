@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">المنتجات</h1>

        {{-- 🔍 البحث والفلاتر --}}
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <input type="text" id="searchProduct" placeholder="ابحث بالاسم أو الكود"
                class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
            <select id="filterStock" class="border rounded px-3 py-2">
                <option value="all">كل المخزون</option>
                <option value="low">مخزون منخفض (&lt;5)</option>
                <option value="out">نفاد المخزون</option>
            </select>
            <a href="{{ route('products.create') }}"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">إضافة منتج</a>
        </div>

        {{-- جدول المنتجات --}}
        <div class="overflow-x-auto">
            <table class="w-full border text-left text-sm">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">الاسم</th>
                        <th class="px-4 py-2 border">العلامة التجارية</th>
                        <th class="px-4 py-2 border">الفئة</th>
                        <th class="px-4 py-2 border">الموديل</th>
                        <th class="px-4 py-2 border">سعر الشراء</th>
                        <th class="px-4 py-2 border">سعر البيع</th>
                        <th class="px-4 py-2 border">المخزون</th>
                        <th class="px-4 py-2 border">المورد</th>
                        <th class="px-4 py-2 border">الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="productTable">
                    @forelse($products as $index => $product)
                        <tr>
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $product->name }}</td>
                            <td class="px-4 py-2 border">{{ $product->brand ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $product->category ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $product->model ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $product->purchase_price }}</td>
                            <td class="px-4 py-2 border">{{ $product->sale_price }}</td>
                            <td class="px-4 py-2 border {{ $product->stock < 5 ? 'text-red-600 font-bold' : '' }}">
                                {{ $product->stock }}
                            </td>
                            <td class="px-4 py-2 border">{{ $product->supplier ?? '-' }}</td>
                            <td class="px-4 py-2 border text-center">
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">تعديل</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700"
                                        onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-4 text-center text-gray-500">لا توجد منتجات.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchProduct');
        const filterStock = document.getElementById('filterStock');
        const rows = document.querySelectorAll('#productTable tr');

        searchInput.addEventListener('input', () => {
            const val = searchInput.value.toLowerCase();
            rows.forEach(r => {
                const name = r.cells[1].innerText.toLowerCase();
                const code = r.cells[2]?.innerText.toLowerCase() ?? '';
                r.style.display = name.includes(val) || code.includes(val) ? '' : 'none';
            });
        });

        filterStock.addEventListener('change', () => {
            const val = filterStock.value;
            rows.forEach(r => {
                const stock = parseInt(r.cells[7].innerText);
                if (val === 'all') r.style.display = '';
                else if (val === 'low') r.style.display = (stock > 0 && stock < 5) ? '' : 'none';
                else if (val === 'out') r.style.display = stock === 0 ? '' : 'none';
            });
        });
    </script>
</main>
@endsection
