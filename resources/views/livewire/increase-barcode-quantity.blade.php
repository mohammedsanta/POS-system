<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">زيادة كمية الباركود</h1>

    {{-- رسائل النجاح / الخطأ --}}
    @if($successMessage)
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">
            {{ $successMessage }}
        </div>
    @endif

    @if($errorMessage)
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">
            {{ $errorMessage }}
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

    {{-- المنتج --}}
    @if(!empty($products))
        <div class="mb-4">
            <label class="block mb-1 font-semibold">المنتج</label>
            <select wire:model="selectedProduct" class="w-full border rounded px-3 py-2">
                <option value="">-- اختر المنتج --</option>
                @foreach($products as $prod)
                    <option value="{{ $prod['id'] }}">{{ $prod['name'] }} ({{ $prod['quantity'] }} متاح)</option>
                @endforeach
            </select>
        </div>

        {{-- تحميل الباركودات --}}
        <button wire:click.prevent="loadBarcodes"
                class="mb-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            تحميل الباركودات
        </button>
    @endif

    {{-- الباركود --}}
    @if(!empty($barcodes))
        <div class="mb-4">
            <label class="block mb-1 font-semibold">الباركود</label>
            <select wire:model="selectedBarcode" class="w-full border rounded px-3 py-2">
                <option value="">-- اختر الباركود --</option>
                @foreach($barcodes as $b)
                    <option value="{{ $b['id'] }}">{{ $b['barcode'] }} (الكمية: {{ $b['quantity'] }})</option>
                @endforeach
            </select>
        </div>

        {{-- الكمية --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">الكمية المراد إضافتها</label>
            <input type="number" wire:model="quantity" min="1"
                   class="w-full border rounded px-3 py-2">
        </div>

        {{-- زر الحفظ --}}
        <button wire:click.prevent="increaseQuantity"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
            زيادة الكمية
        </button>
    @endif
</div>
