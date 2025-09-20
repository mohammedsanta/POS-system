{{-- resources/views/returns/show.blade.php --}}
@extends('layouts.Cashier')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Return Details – <span class="text-green-700">RTN-001</span>
            </h1>
            <a href="{{ route('sales.returns') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
                ← Back
            </a>
        </div>

        {{-- Return Info --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Return Information</h2>
            <div class="grid md:grid-cols-2 gap-4 text-gray-700">
                <p><span class="font-semibold">Return No:</span> RTN-001</p>
                <p><span class="font-semibold">Invoice:</span> INV-1001</p>
                <p><span class="font-semibold">Customer:</span> Mohamed Ali</p>
                <p><span class="font-semibold">Date:</span> 2025-09-12</p>
                <p><span class="font-semibold">Total Amount:</span> EGP 37,000</p>
            </div>
        </div>

        {{-- Returned Items --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Returned Items</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border">
                    <thead class="bg-gray-200 text-gray-700 uppercase">
                        <tr>
                            <th class="px-4 py-3 border">#</th>
                            <th class="px-4 py-3 border">Product</th>
                            <th class="px-4 py-3 border">IMEI / Barcode</th>
                            <th class="px-4 py-3 border">Qty</th>
                            <th class="px-4 py-3 border">Unit Price</th>
                            <th class="px-4 py-3 border">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border">1</td>
                            <td class="px-4 py-3 border">iPhone 15 Pro</td>
                            <td class="px-4 py-3 border">356982456321478</td>
                            <td class="px-4 py-3 border">1</td>
                            <td class="px-4 py-3 border">EGP 37,000</td>
                            <td class="px-4 py-3 border">EGP 37,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>
@endsection
