<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-center mb-6">جرد المنتجات</h1>

    @if(session('error'))
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="mt-4 overflow-x-auto">
        <table class="w-full border-collapse bg-white shadow rounded-lg">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-4 py-2 border">الاسم</th>
                    <th class="px-4 py-2 border">الفئة</th>
                    <th class="px-4 py-2 border">الكمية المتاحة</th>
                    <th class="px-4 py-2 border">السعر</th>
                    <th class="px-4 py-2 border">كمية الجرد</th>
                    <th class="px-4 py-2 border">الإجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="px-4 py-2 border">{{ $product['name'] }}</td>
                        <td class="px-4 py-2 border">{{ $product['category'] }}</td>
                        <td class="px-4 py-2 border">{{ $product['quantity'] }}</td>
                        <td class="px-4 py-2 border">{{ $product['price'] }} جنيه</td>
                        <td class="px-4 py-2 border">
                            <input type="number" min="1" max="{{ $product['quantity'] }}"
                                   wire:model.defer="counts.{{ $product['id'] }}"
                                   class="w-20 px-2 py-1 border rounded">
                        </td>
                        <td class="px-4 py-2 border">
                            <button wire:click="addToInventory({{ $product['id'] }})"
                                    class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700">
                                جرد
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-10 overflow-x-auto">
        <h2 class="text-xl font-bold text-gray-700 mb-2">المنتجات التي تم جردها</h2>
        <table class="w-full border-collapse bg-white shadow rounded-lg">
            <thead class="bg-green-200 text-gray-800">
                <tr>
                    <th class="px-4 py-2 border">الاسم</th>
                    <th class="px-4 py-2 border">الفئة</th>
                    <th class="px-4 py-2 border">الكمية المجردة</th>
                    <th class="px-4 py-2 border">السعر</th>
                    <th class="px-4 py-2 border">الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventoried as $p)
                    <tr>
                        <td class="px-4 py-2 border">{{ $p['name'] }}</td>
                        <td class="px-4 py-2 border">{{ $p['category'] }}</td>
                        <td class="px-4 py-2 border">{{ $p['counted'] }}</td>
                        <td class="px-4 py-2 border">{{ $p['price'] }} جنيه</td>
                        <td class="px-4 py-2 border">{{ $p['counted'] * $p['price'] }} جنيه</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
