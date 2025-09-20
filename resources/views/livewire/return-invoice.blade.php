<div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow">

    <h2 class="text-2xl font-bold mb-4">🔄 إرجاع فاتورة</h2>

    {{-- Search --}}
    <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-3">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium mb-1">رقم الفاتورة</label>
            <input type="number" wire:model.defer="invoiceNumber"
                   class="w-full border rounded px-3 py-2"
                   placeholder="أدخل رقم الفاتورة">
            @error('invoiceNumber') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-end">
            <button wire:click="searchInvoice"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                بحث
            </button>
        </div>
    </div>

    {{-- general error --}}
    @if($errorMessage)
        <div class="mb-4 p-3 bg-red-50 text-red-700 rounded">
            {{ $errorMessage }}
        </div>
    @endif

    {{-- success message --}}
    @if($message)
        <div class="mb-4 p-3 bg-green-50 text-green-700 rounded">
            {{ $message }}
        </div>
    @endif

    {{-- Invoice items table --}}
    @if($invoice && $invoice->count())
        <div class="overflow-x-auto mb-4">
            <table class="w-full text-sm table-auto border-collapse">
                <thead class="bg-gray-50">
                    <tr class="text-gray-700">
                        <th class="p-2 border">اختر</th>
                        <th class="p-2 border text-left">المنتج</th>
                        <th class="p-2 border text-left">الباركود</th>
                        <th class="p-2 border text-left">الكمية</th>
                        <th class="p-2 border text-left">السعر</th>
                        <th class="p-2 border text-left">الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice as $item)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-2 text-center">
                                <input type="checkbox"
                                       wire:model="selectedItems"
                                       value="{{ $item->id }}"
                                       @if($item->is_returned) disabled @endif>
                            </td>

                            <td class="p-2">
                                <div class="font-medium">{{ $item->product_name }}</div>
                                <div class="text-xs text-gray-500">رقم صف: {{ $item->id }}</div>
                            </td>

                            <td class="p-2">
                                @if($item->barcode && $item->barcode->barcode)
                                    <span class="inline-block px-2 py-1 rounded bg-gray-100 text-sm">{{ $item->barcode->barcode }}</span>
                                @else
                                    <span class="text-gray-400 italic">بدون باركود</span>
                                @endif
                            </td>

                            <td class="p-2">{{ $item->qty }}</td>
                            <td class="p-2">{{ number_format($item->price, 2) }} ج</td>

                            <td class="p-2">
                                @if($item->is_returned)
                                    <span class="text-red-700 bg-red-50 px-2 py-1 rounded text-xs">تم الإرجاع</span>
                                @else
                                    <span class="text-green-700 bg-green-50 px-2 py-1 rounded text-xs">نشط</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Controls --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div class="flex items-center gap-3">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" wire:model="returnAll" class="h-4 w-4">
                    <span class="text-sm">إرجاع الفاتورة بالكامل</span>
                </label>

                <span class="text-sm text-gray-500">/ أو اختر عناصر محددة ثم اضغط تأكيد</span>
            </div>

            <div class="flex items-center gap-3">
                <button
                    onclick="if(!confirm('هل أنت متأكد من تنفيذ الإرجاع؟ هذا الإجراء لا يمكن التراجع عنه بسهولة.')) { event.stopImmediatePropagation(); }"
                    wire:click="processReturn"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded disabled:opacity-50"
                    @if($invoice->every(fn($i) => $i->is_returned)) disabled @endif>
                    تأكيد الإرجاع
                </button>

                <button type="button" wire:click.prevent="$refresh"
                        class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded">
                    تحديث
                </button>
            </div>
        </div>

        {{-- show validation errors --}}
        @if($errors->has('selectedItems'))
            <div class="mt-3 text-sm text-red-600">{{ $errors->first('selectedItems') }}</div>
        @endif
        @if($errors->has('return'))
            <div class="mt-3 text-sm text-red-600">{{ $errors->first('return') }}</div>
        @endif
    @else
        @if($invoiceNumber)
            <div class="p-3 bg-yellow-50 text-yellow-700 rounded">لم يتم العثور على فاتورة بهذا الرقم.</div>
        @endif
    @endif
</div>
