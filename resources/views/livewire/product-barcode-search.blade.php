<div class="p-4 bg-white rounded shadow">
    <h2 class="text-lg font-semibold mb-3">🔍 بحث عن المنتج بالباركود</h2>

    <div class="flex gap-2 mb-3">
        <input
            type="text"
            wire:model.debounce.300ms="barcode"
            wire:keydown.enter="searchByBarcode"
            placeholder="امسح أو أدخل الباركود ثم اضغط Enter"
            class="flex-1 border rounded px-3 py-2"
        >
        <button wire:click="searchByBarcode" class="px-4 py-2 bg-blue-600 text-white rounded">بحث</button>
        <button wire:click="$set('barcode','')" class="px-3 py-2 bg-gray-200 rounded">مسح</button>
    </div>

    @if($message)
        <div class="text-sm text-red-600 mb-3">{{ $message }}</div>
    @endif

    @if($productData)
        <div class="border rounded p-3 mb-3">
            <div class="flex justify-between items-center">
                <div>
                    <div class="font-bold text-lg">{{ $productData['name'] }}</div>
                    <div class="text-sm text-gray-600">السعر: {{ number_format($productData['price'],2) }} ج</div>
                    <div class="text-sm text-gray-500">المخزون: {{ $productData['stock'] }}</div>
                    <div class="text-xs text-gray-400">Barcode: {{ $productData['barcode'] }}</div>
                </div>

                <div class="text-right">
                    <button
                        class="bg-green-600 text-white px-3 py-1 rounded"
                        wire:click="addToInvoice({{ $productData['id'] }})"
                    >
                        ➕ أضف للفاتورة
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(count($invoiceItems))
        <h3 class="font-semibold mb-2">🧾 الفاتورة الحالية</h3>
        <table class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">المنتج</th>
                    <th class="p-2">Barcode</th>
                    <th class="p-2">الكمية</th>
                    <th class="p-2">السعر</th>
                    <th class="p-2">الإجمالي</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoiceItems as $barcode => $item)
                    <tr class="border-t">
                        <td class="p-2">{{ $item['name'] }}</td>
                        <td class="p-2">{{ $barcode }}</td>
                        <td class="p-2">
                            <input type="number" min="1" class="w-16 text-center border rounded"
                                wire:change="updateQty('{{ $barcode }}', $event.target.value)"
                                value="{{ $item['qty'] }}">
                        </td>
                        <td class="p-2">{{ number_format($item['price'],2) }}</td>
                        <td class="p-2">{{ number_format($item['price'] * $item['qty'],2) }}</td>
                        <td class="p-2 text-center">
                            <button wire:click="removeItem('{{ $barcode }}')" class="text-red-600">×</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 font-bold">
                <tr>
                    <td colspan="4" class="p-2 text-right">الإجمالي الكلي</td>
                    <td colspan="2" class="p-2">{{ number_format($grandTotal,2) }} ج</td>
                </tr>
            </tfoot>
        </table>
    @endif
</div>
