@extends('layouts.Cashier')

@section('content')
<main class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-6xl mx-auto px-4">

        {{-- ===== Title ===== --}}
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Create Return</h1>
            <p class="text-gray-500">Search invoice → select products → add to return list</p>
        </div>

        {{-- ===== Search Invoice ===== --}}
        <div class="bg-white rounded-xl shadow p-6 mb-10">
            <h2 class="text-xl font-semibold mb-4">🔍 Search Invoice</h2>
            <form class="flex gap-4">
                <input type="text" placeholder="Enter Invoice Number"
                       class="flex-1 border rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                <button type="button" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium">
                    Search
                </button>
            </form>
        </div>

        {{-- ===== Invoice Table ===== --}}
        <div class="bg-white rounded-xl shadow p-6 mb-10">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-700">Invoice Items</h2>

                {{-- زر إرجاع كل الفاتورة --}}
                <button type="button"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
                    Return Entire Invoice
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border rounded">
                    <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3">Barcode</th>
                            <th class="px-4 py-3 text-center">Qty</th>
                            <th class="px-4 py-3 text-right">Price</th>
                            <th class="px-4 py-3 text-center">Return Qty</th>
                            <th class="px-4 py-3 text-center">Add</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-3">1</td>
                            <td class="px-4 py-3 font-medium">iPhone 15 Pro</td>
                            <td class="px-4 py-3">356789123456789</td>
                            <td class="px-4 py-3 text-center">1</td>
                            <td class="px-4 py-3 text-right font-semibold">EGP 37,000</td>
                            <td class="px-4 py-3 text-center">
                                <input type="number" value="1"
                                    class="w-16 border rounded px-2 py-1 text-center">
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">+</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3">2</td>
                            <td class="px-4 py-3 font-medium">AirPods Pro</td>
                            <td class="px-4 py-3">222333444555</td>
                            <td class="px-4 py-3 text-center">1</td>
                            <td class="px-4 py-3 text-right font-semibold">EGP 5,000</td>
                            <td class="px-4 py-3 text-center">
                                <input type="number" value="1"
                                    class="w-16 border rounded px-2 py-1 text-center">
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">+</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===== Return Table ===== --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-6">Return List</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border rounded">
                    <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3">Barcode</th>
                            <th class="px-4 py-3 text-center">Qty</th>
                            <th class="px-4 py-3 text-right">Price</th>
                            <th class="px-4 py-3 text-center">Remove</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-3">1</td>
                            <td class="px-4 py-3 font-medium">iPhone 15 Pro</td>
                            <td class="px-4 py-3">356789123456789</td>
                            <td class="px-4 py-3 text-center">1</td>
                            <td class="px-4 py-3 text-right font-semibold">EGP 37,000</td>
                            <td class="px-4 py-3 text-center">
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">x</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3">2</td>
                            <td class="px-4 py-3 font-medium">Case Cover</td>
                            <td class="px-4 py-3">999888777666</td>
                            <td class="px-4 py-3 text-center">1</td>
                            <td class="px-4 py-3 text-right font-semibold">EGP 300</td>
                            <td class="px-4 py-3 text-center">
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">x</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Total & Submit --}}
            <div class="mt-6 flex justify-end">
                <div class="text-right">
                    <div class="mb-3">
                        <span class="font-semibold text-gray-600">Total Refund:</span>
                        <span class="text-xl font-bold text-gray-800 ml-2">EGP 37,300</span>
                    </div>
                    <button class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-medium shadow">
                        Process Return
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
