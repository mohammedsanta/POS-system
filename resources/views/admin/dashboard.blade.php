{{-- resources/views/admin/owner-dashboard.blade.php --}}
@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto space-y-10">

        {{-- البطاقات (اليوم) --}}
        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">إحصائيات اليوم</h2>
            <div class="grid sm:grid-cols-3 lg:grid-cols-4 gap-6">
                <div class="bg-gray-200 text-gray-900 p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold">المبيعات اليوم</h3>
                    <p class="text-3xl font-bold mt-2">ج.م {{ number_format($salesToday, 2) }}</p>
                </div>

                <div class="bg-gray-200 text-gray-900 p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold">المرتجعات اليوم</h3>
                    <p class="text-3xl font-bold mt-2">ج.م {{ number_format($returnsToday, 2) }}</p>
                </div>

                <div class="bg-gray-200 text-gray-900 p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold">المصروفات اليوم</h3>
                    <p class="text-3xl font-bold mt-2">ج.م {{ number_format($expensesToday, 2) }}</p>
                </div>
            </div>
        </section>

        {{-- البطاقات (هذا الأسبوع) --}}
        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">إحصائيات الأسبوع</h2>
            <div class="grid sm:grid-cols-3 lg:grid-cols-4 gap-6">
                <div class="bg-gray-200 text-gray-900 p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold">المبيعات هذا الأسبوع</h3>
                    <p class="text-3xl font-bold mt-2">ج.م {{ number_format($weeklySales, 2) }}</p>
                </div>

                <div class="bg-gray-200 text-gray-900 p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold">المرتجعات هذا الأسبوع</h3>
                    <p class="text-3xl font-bold mt-2">ج.م {{ number_format($weeklyReturns, 2) }}</p>
                </div>

                <div class="bg-gray-200 text-gray-900 p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold">المصروفات هذا الأسبوع</h3>
                    <p class="text-3xl font-bold mt-2">ج.م {{ number_format($weeklyExpenses, 2) }}</p>
                </div>
            </div>
        </section>

        {{-- المنتجات منخفضة المخزون --}}
        <section>
            <div class="bg-gray-200 text-gray-900 p-6 rounded-2xl shadow hover:shadow-lg transition text-center">
                <h3 class="text-xl font-bold">المنتجات منخفضة المخزون</h3>
                <p class="text-3xl mt-2 font-bold">{{ $lowStockCount }}</p>
            </div>
        </section>

        {{-- أفضل المنتجات مبيعًا --}}
        <section>
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">أفضل المنتجات مبيعًا</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 rounded-lg">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 border-b">المنتج</th>
                                <th class="px-4 py-3 border-b">الوحدات المباعة</th>
                                <th class="px-4 py-3 border-b">الإيراد</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($topProducts as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $product->name }}</td>
                                    <td class="px-4 py-3">{{ $product->units_sold ?? 0 }}</td>
                                    <td class="px-4 py-3">ج.م {{ number_format($product->revenue ?? 0, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-gray-500">
                                        لا توجد منتجات.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection
