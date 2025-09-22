<div class="max-w-2xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">إدارة الكمية للمنتج</h2>

    {{-- رسائل --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- اختيار القسم --}}
    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">اختر القسم:</label>
        <select wire:model="selectedCategory" wire:change="searchProducts" class="w-full border rounded p-2">
            <option value="">-- اختر القسم --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- اختيار المنتج --}}
    @if($products->count())
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">اختر المنتج:</label>
            <select wire:model="selectedProduct" wire:change="loadBarcodes" class="w-full border rounded p-2">
                <option value="">-- اختر المنتج --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} (المخزون: {{ $product->stock }})</option>
                @endforeach
            </select>
        </div>
    @endif

    {{-- إدخال الكمية --}}
    @if($selectedProduct)
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">الكمية:</label>
            <input type="number" wire:model="quantity" min="1" class="w-full border rounded p-2">
        </div>

        <div class="flex gap-3">
            <button wire:click="increaseQuantity" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                ➕ زيادة
            </button>
            <button wire:click="decreaseQuantity" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                ➖ إنقاص
            </button>
        </div>
    @endif
</div>
