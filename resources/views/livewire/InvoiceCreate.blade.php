<div class="max-w-5xl mx-auto bg-white shadow p-6 rounded">

    {{-- رسائل --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errorMessage)
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">
            {{ $errorMessage }}
        </div>
    @endif

    {{-- بيانات العميل --}}
    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">اسم العميل</label>
        <input type="text" wire:model="customerName"
               class="w-full border rounded px-3 py-2">
    </div>

    {{-- البحث بالباركود --}}
    <div class="mb-4 flex gap-2">
        <input type="text" wire:model="barcodeInput"
               wire:keydown.enter.prevent="addByBarcode"
               placeholder="📦 أدخل الباركود"
               class="flex-1 border rounded px-3 py-2">
        <button wire:click="addByBarcode"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            ➕ إضافة
        </button>
    </div>

    {{-- اختيار الفئة والبحث --}}
    <div class="mb-4 flex gap-2">
        <select wire:model="selectedCategory" class="border rounded px-3 py-2">
            <option value="">-- اختر الفئة --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <button wire:click="searchProducts"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            🔍 بحث
        </button>
    </div>

    {{-- قائمة المنتجات للفئة --}}
    @if($products && $selectedCategory && $products->count() > 0 && !$errorMessage)
        <div class="mb-4">
            <h3 class="font-bold mb-2">المنتجات:</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($products as $p)
                    <div class="border rounded p-2 flex justify-between items-center">
                        <div>
                            <div class="font-semibold">{{ $p->name }}</div>
                            <div class="text-sm text-gray-500">{{ $p->model }}</div>
                            <div class="text-sm">💵 {{ $p->sale_price }}</div>
                        </div>
                        <button wire:click="addToInvoice({{ $p->id }})"
                                class="bg-blue-500 text-white px-3 py-1 rounded">
                            إضافة
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- حالة وجود أكثر من منتج بنفس الباركود --}}
    @if($products && $products->count() > 1 && $errorMessage)
        <div class="mb-4 border p-3 rounded bg-gray-50">
            <h3 class="font-bold mb-2">اختر المنتج الصحيح:</h3>
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2">الاسم</th>
                        <th class="p-2">الموديل</th>
                        <th class="p-2">السعر</th>
                        <th class="p-2">إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                        <tr class="border-b">
                            <td class="p-2">{{ $p->name }}</td>
                            <td class="p-2">{{ $p->model }}</td>
                            <td class="p-2">{{ $p->sale_price }}</td>
                            <td class="p-2">
                                <button wire:click="addToInvoice({{ $p->id }})"
                                        class="bg-blue-500 text-white px-3 py-1 rounded">
                                    إضافة
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- جدول الفاتورة --}}
    <div class="mt-6">
        <h3 class="font-bold mb-2">🧾 تفاصيل الفاتورة</h3>
        @if(empty($invoiceItems))
            <div class="text-gray-500">لا توجد منتجات في الفاتورة.</div>
        @else
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2">الاسم</th>
                        <th class="p-2">الباركود</th>
                        <th class="p-2">الكمية</th>
                        <th class="p-2">السعر</th>
                        <th class="p-2">الإجمالي</th>
                        <th class="p-2">إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoiceItems as $key => $item)
                        <tr class="border-b">
                            <td class="p-2">{{ $item['name'] }}</td>
                            <td class="p-2">{{ $item['barcode'] }}</td>
                            <td class="p-2">
                                <input type="number" min="1"
                                       wire:change="updateQty({{ $key }}, $event.target.value)"
                                       value="{{ $item['qty'] }}"
                                       class="w-16 border rounded px-2 py-1">
                            </td>
                            <td class="p-2">
                                <input type="number" step="0.01"
                                       wire:change="updatePrice({{ $key }}, $event.target.value)"
                                       value="{{ $item['price'] }}"
                                       class="w-24 border rounded px-2 py-1">
                            </td>
                            <td class="p-2">{{ $item['price'] * $item['qty'] }}</td>
                            <td class="p-2">
                                <button wire:click="removeItem({{ $key }})"
                                        class="bg-red-500 text-white px-3 py-1 rounded">
                                    ❌ حذف
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-bold bg-gray-100">
                        <td colspan="4" class="p-2 text-right">الإجمالي الكلي:</td>
                        <td colspan="2" class="p-2">{{ $grandTotal }}</td>
                    </tr>
                </tfoot>
            </table>
        @endif
    </div>

    {{-- زر الحفظ --}}
    <div class="mt-6">
        <button wire:click="submitInvoice"
                class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            ✅ حفظ الفاتورة
        </button>
    </div>
</div>
