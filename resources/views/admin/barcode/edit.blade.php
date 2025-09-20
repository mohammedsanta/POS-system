@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">

        <h1 class="text-2xl font-bold mb-6 text-center">Edit Barcode</h1>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barcodes.update', $barcode->id) }}" method="POST" class="grid grid-cols-1 gap-4">
            @csrf
            @method('PUT')

            {{-- Select Category --}}
            <div>
                <label class="block text-sm font-semibold mb-1" for="category_id">Category</label>
                <select name="category_id" id="category_id"
                        class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" 
                            {{ old('category_id', $barcode->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Select Product --}}
            <div>
                <label class="block text-sm font-semibold mb-1" for="product_id">Product</label>
                <select name="product_id" id="product_id"
                        class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Select Product --</option>
                    @foreach($products as $prod)
                        <option value="{{ $prod->id }}" 
                            {{ old('product_id', $barcode->product_id) == $prod->id ? 'selected' : '' }}>
                            {{ $prod->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Barcode Input --}}
            <div>
                <label class="block text-sm font-semibold mb-1" for="barcode">Barcode</label>
                <input type="text" name="barcode" id="barcode"
                       value="{{ old('barcode', $barcode->barcode) }}"
                       placeholder="Enter barcode"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Form Actions --}}
            <div class="flex justify-between mt-4">
                <a href="{{ route('admin.products.barcodes') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                   Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Update Barcode
                </button>
            </div>

        </form>
    </div>
</main>
@endsection
