{{-- resources/views/sales/index.blade.php --}}
@extends('layouts.Cashier')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">

        {{-- Filters --}}
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" placeholder="Search by Invoice # or Customer"
                       class="border p-2 rounded w-full">
                <input type="date" class="border p-2 rounded w-full">
                <input type="date" class="border p-2 rounded w-full">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Filter
                </button>
            </div>
        </div>

        {{-- Sales Table --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-200 text-gray-700 uppercase">
                    <tr>
                        <th class="px-4 py-3">Invoice #</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Items</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Payment</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">INV-1001</td>
                        <td class="px-4 py-3">Mohamed Ali</td>
                        <td class="px-4 py-3">3</td>
                        <td class="px-4 py-3 text-green-600 font-semibold">EGP 2,500</td>
                        <td class="px-4 py-3">Cash</td>
                        <td class="px-4 py-3">2025-09-12</td>
                        <td class="px-4 py-3 text-center">
                            <a href="#" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">INV-1002</td>
                        <td class="px-4 py-3">Sara Ahmed</td>
                        <td class="px-4 py-3">1</td>
                        <td class="px-4 py-3 text-green-600 font-semibold">EGP 900</td>
                        <td class="px-4 py-3">Card</td>
                        <td class="px-4 py-3">2025-09-11</td>
                        <td class="px-4 py-3 text-center">
                            <a href="#" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                    {{-- Add dynamic rows here later --}}
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-end">
            <nav class="inline-flex rounded-md shadow">
                <a href="#"
                   class="px-3 py-1 bg-white border border-gray-300 text-gray-600 hover:bg-gray-50">Prev</a>
                <a href="#"
                   class="px-3 py-1 bg-green-600 text-white border border-green-600">1</a>
                <a href="#"
                   class="px-3 py-1 bg-white border border-gray-300 text-gray-600 hover:bg-gray-50">2</a>
                <a href="#"
                   class="px-3 py-1 bg-white border border-gray-300 text-gray-600 hover:bg-gray-50">Next</a>
            </nav>
        </div>

    </div>
</main>
@endsection
