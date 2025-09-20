@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white shadow rounded p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Invoices</h1>
            <a href="{{ route('invoices.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                + Add Invoice
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($invoices->isEmpty())
            <p class="text-gray-600">No invoices found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border">
                    <thead class="bg-gray-50">
                        <tr class="text-left">
                            <th class="border px-3 py-2">#</th>
                            <th class="border px-3 py-2">Invoice Number</th>
                            <th class="border px-3 py-2">Customer</th>
                            <th class="border px-3 py-2">Items</th>
                            <th class="border px-3 py-2">Total</th>
                            <th class="border px-3 py-2">Last Sold</th>
                            <th class="border px-3 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $index => $invoice)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2">{{ $invoices->firstItem() + $index }}</td>
                            <td class="border px-3 py-2 font-semibold">{{ $invoice->invoice_number }}</td>
                            <td class="border px-3 py-2">{{ $invoice->customer_name ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $invoice->items_count }}</td>
                            <td class="border px-3 py-2 font-semibold">{{ number_format($invoice->total_amount, 2) }}</td>
                            <td class="border px-3 py-2">{{ \Carbon\Carbon::parse($invoice->last_sold_at)->format('Y-m-d') }}</td>
                            <td class="border px-3 py-2 text-center">
                                <a href="{{ route('invoices.show', $invoice->invoice_number) }}" 
                                   class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                   View Products
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $invoices->links() }}
                </div>
            </div>
        @endif
    </div>
</main>
@endsection
