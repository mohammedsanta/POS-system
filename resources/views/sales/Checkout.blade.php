@extends('layouts.Cashier')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">💳 Cashier – New Sale</h1>
        </header>

        {{-- Customer Info --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">👤 Customer Information</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <input type="text" placeholder="Customer Name"
                       class="border p-3 rounded w-full focus:ring focus:ring-blue-300">
                <input type="text" placeholder="Customer Phone Number"
                       class="border p-3 rounded w-full focus:ring focus:ring-blue-300">
            </div>
        </div>

        {{-- Search Area --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">🔍 Search & Select Product</h2>
            <div class="grid md:grid-cols-3 gap-4 relative">
                {{-- Product Name --}}
                <div class="relative">
                    <input type="text" placeholder="Type product name..."
                           class="border p-3 rounded w-full focus:ring focus:ring-green-300">
                    {{-- Suggestion List (static) --}}
                    <ul class="absolute bg-white border w-full mt-1 rounded shadow text-sm">
                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer">📱 iPhone 15 Pro – EGP 37,000</li>
                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer">📱 Samsung A55 – EGP 12,000</li>
                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer">📱 Xiaomi Note 13 – EGP 8,000</li>
                    </ul>
                </div>

                {{-- Barcode --}}
                <input type="text" placeholder="Scan / Enter Barcode"
                       class="border p-3 rounded w-full focus:ring focus:ring-green-300">

                {{-- Categories --}}
                <select class="border p-3 rounded w-full focus:ring focus:ring-green-300">
                    <option value="">All Categories</option>
                    <option value="phones">Phones</option>
                    <option value="accessories">Accessories</option>
                    <option value="tablets">Tablets</option>
                </select>
            </div>
        </div>

        {{-- Invoice Table --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">🧾 Invoice Items</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border rounded-lg">
                    <thead class="bg-gradient-to-r from-green-500 to-green-600 text-white">
                        <tr>
                            <th class="px-3 py-2 text-left">#</th>
                            <th class="px-3 py-2 text-left">Product</th>
                            <th class="px-3 py-2 text-left">Barcode</th>
                            <th class="px-3 py-2 text-left">Category</th>
                            <th class="px-3 py-2 text-center">Qty</th>
                            <th class="px-3 py-2 text-center">Price</th>
                            <th class="px-3 py-2 text-center">Discount</th>
                            <th class="px-3 py-2 text-center">Total</th>
                            <th class="px-3 py-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2">1</td>
                            <td class="px-3 py-2 font-medium">iPhone 15 Pro</td>
                            <td class="px-3 py-2 text-gray-600">356789123456</td>
                            <td class="px-3 py-2">Phones</td>
                            <td class="px-3 py-2 text-center">
                                <input type="number" value="1" class="border p-1 w-16 rounded text-center">
                            </td>
                            <td class="px-3 py-2 text-center">EGP 37,000</td>
                            <td class="px-3 py-2 text-center">
                                <input type="text" value="0%" class="border p-1 w-16 rounded text-center">
                            </td>
                            <td class="px-3 py-2 text-center font-semibold text-green-600">EGP 37,000</td>
                            <td class="px-3 py-2 text-center">
                                <button class="text-red-600 hover:underline">Remove</button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2">2</td>
                            <td class="px-3 py-2 font-medium">Samsung A55</td>
                            <td class="px-3 py-2 text-gray-600">785421365478</td>
                            <td class="px-3 py-2">Phones</td>
                            <td class="px-3 py-2 text-center">
                                <input type="number" value="1" class="border p-1 w-16 rounded text-center">
                            </td>
                            <td class="px-3 py-2 text-center">EGP 12,000</td>
                            <td class="px-3 py-2 text-center">
                                <input type="text" value="5%" class="border p-1 w-16 rounded text-center">
                            </td>
                            <td class="px-3 py-2 text-center font-semibold text-green-600">EGP 11,400</td>
                            <td class="px-3 py-2 text-center">
                                <button class="text-red-600 hover:underline">Remove</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Invoice Summary --}}
            <div class="mt-6 flex justify-end">
                <div class="bg-gray-50 p-4 rounded shadow w-full md:w-1/3">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Subtotal:</span>
                        <span>EGP 48,400</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Invoice Discount:</span>
                        <input type="text" value="0%" class="border p-1 w-20 rounded text-right">
                    </div>
                    <hr class="my-3">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total:</span>
                        <span class="text-green-600">EGP 48,400</span>
                    </div>
                    <button class="w-full mt-4 bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
                        ✅ Complete Sale
                    </button>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
