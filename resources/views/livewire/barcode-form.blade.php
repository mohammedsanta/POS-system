<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">إضافة باركود (باركودات) للمنتج</h1>

    {{-- رسائل الخطأ / النجاح --}}
    @if($errorMessage)
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">
            {{ $errorMessage }}
        </div>
    @endif
    @if($successMessage)
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">
            {{ $successMessage }}
        </div>
    @endif

    {{-- الفئة --}}
    <div class="mb-4">
        <label class="block mb-1 font-semibold">الفئة</label>
        <select wire:model="selectedCategory" class="w-full border rounded px-3 py-2">
            <option value="">-- اختر الفئة --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- البحث عن المنتجات --}}
    <button wire:click.prevent="searchProducts"
            class="mb-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        بحث عن المنتجات
    </button>

    {{-- المنتجات --}}
    @if($products->isNotEmpty())
        <div class="mb-4">
            <label class="block mb-1 font-semibold">المنتج</label>
            <select wire:model="selectedProduct" class="w-full border rounded px-3 py-2">
                <option value="">-- اختر المنتج --</option>
                @foreach($products as $prod)
                    <option value="{{ $prod->id }}">{{ $prod->name }} ({{ $prod->quantity }} متاح)</option>
                @endforeach
            </select>
        </div>

        {{-- اختيار الوضع --}}
        <div class="mb-4 flex gap-2">
            <button type="button" wire:click="$set('mode', 'single')"
                    class="px-4 py-2 rounded {{ $mode === 'single' ? 'bg-green-600 text-white' : 'bg-gray-200' }}">
                باركود واحد لكل الكمية
            </button>
            <button type="button" wire:click="$set('mode', 'multiple')"
                    class="px-4 py-2 rounded {{ $mode === 'multiple' ? 'bg-green-600 text-white' : 'bg-gray-200' }}">
                باركودات متعددة
            </button>
        </div>

        {{-- إدخال باركود واحد --}}
        @if($mode === 'single')
            <div class="mb-4">
                <label class="block mb-1 font-semibold">الباركود</label>
                <input type="text" wire:model="barcode"
                       placeholder="أدخل الباركود"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">الكمية لهذا الباركود</label>
                <input type="number" wire:model="quantity"
                       placeholder="أدخل الكمية (أرقام فقط)"
                       min="1"
                       max="{{ $selectedProduct ? $products->firstWhere('id', $selectedProduct)->quantity : '' }}"
                       class="w-full border rounded px-3 py-2">
            </div>
        @endif

        {{-- إدخال باركودات متعددة --}}
        @if($mode === 'multiple')
            <div class="mb-4">
                <label class="block mb-1 font-semibold">الباركودات</label>
                @foreach($barcodes as $index => $b)
                    <div class="flex mb-2 gap-2">
                        <input type="text" wire:model="barcodes.{{ $index }}"
                               placeholder="أدخل الباركود"
                               class="w-full border rounded px-3 py-2">
                        @if(count($barcodes) > 1)
                            <button type="button" wire:click.prevent="removeBarcodeField({{ $index }})"
                                    class="bg-red-600 text-white px-3 rounded hover:bg-red-700">حذف</button>
                        @endif
                    </div>
                @endforeach
                <button type="button" wire:click.prevent="addBarcodeField"
                        class="mt-1 bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                    + إضافة باركود آخر
                </button>
            </div>
        @endif

        {{-- زر الحفظ --}}
        <button wire:click.prevent="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
            حفظ الباركود(ات)
        </button>
    @endif
</div>
