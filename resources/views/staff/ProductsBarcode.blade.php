@extends('layouts.Cashier')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-700 mb-2">Product Barcodes</h1>
            <p class="text-sm text-gray-500">
                Search & view all barcodes (IMEI) for a single product.
            </p>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('barcodes.index') }}" class="mb-6">
            <input type="text" name="search" id="searchBarcode"
                   value="{{ request('search') }}"
                   placeholder="Search by Product or Barcode"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-green-300">
        </form>

        {{-- Table --}}
        <div class="bg-white rounded-lg shadow p-6 overflow-x-auto">
            @if($barcodes->isEmpty())
                <p class="text-center text-gray-500">No barcodes found.</p>
            @else
                <table class="w-full border text-sm">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 border w-12">#</th>
                            <th class="px-4 py-2 border">Barcode / IMEI</th>
                            <th class="px-4 py-2 border">Product Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barcodes as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border text-center">{{ $barcodes->firstItem() + $index }}</td>
                                <td class="px-4 py-2 border font-mono text-green-700">{{ $item->barcode }}</td>
                                <td class="px-4 py-2 border">{{ $item->product->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $barcodes->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
