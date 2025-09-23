<div class="max-w-lg mx-auto bg-white shadow p-6 rounded">
    <h2 class="text-xl font-bold mb-4">إضافة منتج سريع</h2>

    {{-- رسائل --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- النموذج --}}
    <form wire:submit.prevent="save" class="space-y-4">
        {{-- اسم المنتج --}}
        <div>
            <label class="block text-sm font-medium mb-1">اسم المنتج</label>
            <input type="text" wire:model="name" class="w-full border rounded px-3 py-2">
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- الفئة --}}
        <div>
            <label class="block text-sm font-medium mb-1">الفئة</label>
            <select wire:model="category_id" class="w-full border rounded px-3 py-2">
                <option value="">-- اختر الفئة --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- الباركود --}}
        <div>
            <label class="block text-sm font-medium mb-1">الباركود</label>
            <input type="text" wire:model="barcode" class="w-full border rounded px-3 py-2">
            @error('barcode') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- سعر الشراء --}}
        <div>
            <label class="block text-sm font-medium mb-1">سعر الشراء</label>
            <input type="number" step="0.01" wire:model="purchase_price" class="w-full border rounded px-3 py-2">
            @error('purchase_price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- سعر البيع --}}
        <div>
            <label class="block text-sm font-medium mb-1">سعر البيع</label>
            <input type="number" step="0.01" wire:model="sale_price" class="w-full border rounded px-3 py-2">
            @error('sale_price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

            {{-- الكميه --}}
        <div>
            <label class="block text-sm font-medium mb-1">الكميه</label>
            <input type="number" step="0.01" wire:model="stock" class="w-full border rounded px-3 py-2">
            @error('sale_price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- زر الحفظ --}}
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            💾 حفظ المنتج
        </button>
    </form>
</div>
