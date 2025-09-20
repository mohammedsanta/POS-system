@extends('layouts.Cashier')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white shadow rounded p-6">
        <h1 class="text-2xl font-bold mb-4">Invoice: {{ $invoice_number }}</h1>
        <a href="{{ route('invoices.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">
            ← Back to Invoices
        </a>

        <table class="w-full border-collapse border mt-4">
            <thead class="bg-gray-50">
                <tr class="text-left">
                    <th class="border px-3 py-2">#</th>
                    <th class="border px-3 py-2">Product</th>
                    <th class="border px-3 py-2">Barcode</th>
                    <th class="border px-3 py-2">Qty</th>
                    <th class="border px-3 py-2">Price</th>
                    <th class="border px-3 py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                <tr class="border-t">
                    <td class="border px-3 py-2">{{ $index + 1 }}</td>
                    <td class="border px-3 py-2">{{ $item->product_name }}</td>
                    <td class="border px-3 py-2">{{ $item->barcode_id ? $item->barcode->barcode ?? '-' : '-' }}</td>
                    <td class="border px-3 py-2">{{ $item->qty }}</td>
                    <td class="border px-3 py-2">{{ number_format($item->price,2) }}</td>
                    <td class="border px-3 py-2 font-semibold">{{ number_format($item->total,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection
