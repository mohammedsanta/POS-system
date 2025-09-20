{{-- resources/views/sales/show.blade.php --}}
@extends('layouts.app')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Sale Details</h1>
            <a href="{{ route('sales.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
                ← Back to Sales
            </a>
        </div>

        {{-- Invoice Info --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Invoice #</p>
                    <p class="font-semibold text-lg text-gray-800">INV-1001</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Customer</p>
                    <p class="font-semibold text-lg text-gray-800">Mohamed Ali</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Date</p>
                    <p class="font-semibold text-lg text-gray-800">2025-09-12</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Payment Method</p>
                    <p class="font-semibold text-lg text-gray-800">Cash</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Cashier</p>
                    <p class="font-semibold text-lg text-gray-800">Admin</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800 font-semibold">
                        Completed
                    </span>
                </div>
            </div>
        </div>

        {{-- Items Table --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Items</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border">
                    <thead class="bg-gray-200 text-gray-700 uppercase">
                        <tr>
                            <th class="px-4 py-3 border">#</th>
                            <th class="px-4 py-3 border">Product</th>
                            <th class="px-4 py-3 border">Barcode</th>
                            <th class="px-4 py-3 border">Category</th>
                            <th class="px-4 py-3 border">Qty</th>
                            <th class="px-4 py-3 border">Price</th>
                            <th class="px-4 py-3 border">Discount</th>
                            <th class="px-4 py-3 border">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border">1</td>
                            <td class="px-4 py-3 border">iPhone 15 Pro</td>
                            <td class="px-4 py-3 border">356789123456</td>
                            <td class="px-4 py-3 border">Phones</td>
                            <td class="px-4 py-3 border">1</td>
                            <td class="px-4 py-3 border">EGP 37,000</td>
                            <td class="px-4 py-3 border">0%</td>
                            <td class="px-4 py-3 border font-semibold">EGP 37,000</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border">2</td>
                            <td class="px-4 py-3 border">Samsung A55</td>
                            <td class="px-4 py-3 border">785421365478</td>
                            <td class="px-4 py-3 border">Phones</td>
                            <td class="px-4 py-3 border">1</td>
                            <td class="px-4 py-3 border">EGP 12,000</td>
                            <td class="px-4 py-3 border">5%</td>
                            <td class="px-4 py-3 border font-semibold">EGP 11,400</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Summary --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Summary</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-semibold">EGP 48,400</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Discount</span>
                        <span class="font-semibold">EGP 0</span>
                    </div>
                    <hr>
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span>EGP 48,400</span>
                    </div>
                </div>
                <div class="flex items-center justify-end">
                    <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow">
                        Print Invoice
                    </button>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
