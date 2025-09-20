{{-- resources/views/returns/index.blade.php --}}
@extends('layouts.Cashier')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Returns List</h1>
            <a href="{{ route('sales.create.returns') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                + New Return
            </a>
        </div>

        {{-- Returns Table --}}
        <div class="bg-white shadow rounded-lg p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-sm border">
                    <thead class="bg-gray-200 text-gray-700 uppercase">
                        <tr>
                            <th class="px-4 py-3 border">#</th>
                            <th class="px-4 py-3 border">Return No</th>
                            <th class="px-4 py-3 border">Invoice No</th>
                            <th class="px-4 py-3 border">Customer</th>
                            <th class="px-4 py-3 border">Date</th>
                            <th class="px-4 py-3 border">Type</th>
                            <th class="px-4 py-3 border">Total Amount</th>
                            <th class="px-4 py-3 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border">1</td>
                            <td class="px-4 py-3 border">RTN-001</td>
                            <td class="px-4 py-3 border">INV-1001</td>
                            <td class="px-4 py-3 border">Mohamed Ali</td>
                            <td class="px-4 py-3 border">2025-09-12</td>
                            <td class="px-4 py-3 border">
                                <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">
                                    فاتورة كاملة
                                </span>
                            </td>
                            <td class="px-4 py-3 border">EGP 37,000</td>
                            <td class="px-4 py-3 border text-center">
                                <a href="{{ route('sales.returns.show') }}"
                                   class="text-green-600 hover:text-green-800 font-medium">
                                    View
                                </a>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border">2</td>
                            <td class="px-4 py-3 border">RTN-002</td>
                            <td class="px-4 py-3 border">INV-1005</td>
                            <td class="px-4 py-3 border">Sara Mostafa</td>
                            <td class="px-4 py-3 border">2025-09-11</td>
                            <td class="px-4 py-3 border">
                                <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                    منتج واحد
                                </span>
                            </td>
                            <td class="px-4 py-3 border">EGP 9,000</td>
                            <td class="px-4 py-3 border text-center">
                                <a href="{{ route('sales.returns.show') }}"
                                   class="text-green-600 hover:text-green-800 font-medium">
                                    View
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>
@endsection
