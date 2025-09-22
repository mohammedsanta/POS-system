<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">إضافة باركود للمنتج</h1>

    {{-- رسائل --}}
    @if($errorMessage)
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ $errorMessage }}</div>
    @endif
    @if($successMessage)
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ $successMessage }}</div>
    @endif

    {{-- اختيار الفئة --}}
    <div class="mb-4">
        <label class="block mb-1 font-semibold">الفئة</label>
        <select wire:model="selectedCategory" class="w-full border rounded px-3 py-2">
            <option value="">-- اختر الفئة --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- زر البحث --}}
    <button wire:click.prevent="searchProducts"
            class="mb-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        بحث عن المنتجات
    </button>

    {{-- إذا تم تحميل المنتجات --}}
    @if($products->isNotEmpty())
        {{-- اختيار المنتج --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">المنتج</label>
            <select wire:model="selectedProduct" class="w-full border rounded px-3 py-2">
                <option value="">-- اختر المنتج --</option>
                @foreach($products as $prod)
                    <option value="{{ $prod->id }}">
                        {{ $prod->name }} (المتوفر: {{ $prod->stock ?? 0 }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- حقل الباركود --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">الباركود</label>
            <input type="text" wire:model.defer="barcode"
                   placeholder="أدخل الباركود"
                   class="w-full border rounded px-3 py-2">
        </div>

        {{-- زر الحفظ --}}
        <button wire:click.prevent="submit"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
            حفظ الباركود
        </button>
    @endif
</div>
