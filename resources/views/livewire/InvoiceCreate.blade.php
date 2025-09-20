<div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow">

    <h2 class="text-2xl font-bold mb-4">🧾 إنشاء فاتورة جديدة</h2>

    {{-- Barcode input --}}
    <div class="mb-4 flex gap-2 items-center">
        <input type="text" wire:model.lazy="barcodeInput"
               placeholder="امسح أو أدخل الباركود"
               wire:keydown.enter="addByBarcode"
               class="border rounded px-3 py-2 flex-1">
        <button wire:click="addByBarcode"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            أضف بالباركود
        </button>
    </div>

    {{-- Category search --}}
    <div class="flex gap-2 mb-4">
        <select wire:model="selectedCategory"
                class="border rounded px-3 py-2 flex-1">
            <option value="">-- اختر الفئة --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <button wire:click="searchProducts"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            بحث
        </button>
    </div>

    {{-- Error message --}}
    @if($errorMessage)
        <div class="mb-4 p-2 bg-red-100 text-red-700 rounded">
            {{ $errorMessage }}
        </div>
    @endif

    {{-- Products list --}}
    @if($products && $products->count())
        <h3 class="font-semibold mb-2">📦 المنتجات المرتبطة بالفئة</h3>
        <ul class="mb-4">
            @foreach($products as $product)
                @php
                    $allBarcodes   = $product->barcodes;
                    $unsoldBarcodes = $allBarcodes->where('sold', false);
                @endphp

                <li class="flex justify-between items-center border-b py-2">
                    <span>{{ $product->name }} ({{ number_format($product->sale_price,2) }} ج)</span>

                    <div class="flex gap-2 items-center">
                        {{-- منتج له باركودات --}}
                        @if($allBarcodes->count() > 0)
                            {{-- يوجد باركودات غير مباعة --}}
                            @if($unsoldBarcodes->count() > 0)
                                <button wire:click="loadBarcodes({{ $product->id }})"
                                        class="px-2 py-1 bg-gray-200 rounded text-gray-700 text-sm">
                                    اختر الباركود
                                </button>

                                @if(isset($selectedProductBarcodes[$product->id]) && $selectedProductBarcodes[$product->id])
                                    <select wire:model="selectedBarcodeId.{{ $product->id }}"
                                            class="border rounded px-2 py-1 text-sm">
                                        <option value="">-- اختر --</option>
                                        @foreach($selectedProductBarcodes[$product->id] as $barcode)
                                            <option value="{{ $barcode->id }}">{{ $barcode->barcode }}</option>
                                        @endforeach
                                    </select>
                                @endif

                                <button class="px-2 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm"
                                        wire:click="addToInvoice({{ $product->id }})">
                                    أضف للفاتورة
                                </button>
                            @else
                                <span class="text-red-500 text-sm">تم بيع جميع النسخ</span>
                            @endif

                        {{-- منتج بدون باركودات --}}
                        @else
                            <span class="text-gray-500 text-sm">غير متاح بالمخزون</span>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @elseif($selectedCategory)
        <div class="text-gray-500 mb-4">
            لا توجد منتجات لهذه الفئة.
        </div>
    @endif

    {{-- Invoice items --}}
    @if(count($invoiceItems))
        <h3 class="font-semibold mb-2">📝 الفاتورة الحالية</h3>
        <table class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">المنتج</th>
                    <th class="p-2">الباركود</th>
                    <th class="p-2">الكمية</th>
                    <th class="p-2">السعر</th>
                    <th class="p-2">الإجمالي</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoiceItems as $key => $item)
                    <tr class="border-t">
                        <td class="p-2">{{ $item['name'] }}</td>
                        <td class="p-2">{{ $item['barcode'] ?? '-' }}</td>
                        <td class="p-2">
                            <input type="number" min="1"
                                   class="w-16 text-center border rounded"
                                   wire:change="updateQty('{{ $key }}', $event.target.value)"
                                   value="{{ $item['qty'] }}">
                        </td>
                        <td class="p-2">{{ number_format($item['price'],2) }}</td>
                        <td class="p-2">{{ number_format($item['price'] * $item['qty'],2) }}</td>
                        <td class="p-2 text-center">
                            <button wire:click="removeItem('{{ $key }}')"
                                    class="text-red-600 hover:underline">
                                ×
                            </button>
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

        {{-- Customer name --}}
        <div class="mt-4 mb-2">
            <input type="text" wire:model.lazy="customerName"
                   placeholder="اسم العميل (اختياري)"
                   class="border rounded px-3 py-2 w-full">
        </div>

        {{-- Submit invoice --}}
        <button wire:click="submitInvoice"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mt-2">
            💾 حفظ الفاتورة
        </button>
    @endif
</div>
