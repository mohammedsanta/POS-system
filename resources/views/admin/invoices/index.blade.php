@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto bg-white shadow rounded p-6">
    <h1 class="text-2xl font-bold mb-4">📄 إدارة الفواتير</h1>

    {{-- ✅ رسائل --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- الفواتير الحالية --}}
    <h2 class="text-xl font-semibold mb-2">الفواتير الحالية</h2>
    <table class="w-full border mb-6">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">العميل</th>
                <th class="px-4 py-2 border">الإجمالي</th>
                <th class="px-4 py-2 border">الحالة</th>
                <th class="px-4 py-2 border">الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $invoice)
                <tr>
                    <td class="border px-4 py-2">{{ $invoice->id }}</td>
                    <td class="border px-4 py-2">{{ $invoice->customer_name }}</td>
                    <td class="border px-4 py-2">{{ $invoice->total }}</td>
                    <td class="border px-4 py-2">{{ $invoice->status }}</td>
                    <td class="border px-4 py-2">
                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('هل أنت متأكد؟')"
                                    class="px-3 py-1 bg-red-600 text-white rounded">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-gray-500 py-4">لا توجد فواتير</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- الفواتير المحذوفة --}}
    <h2 class="text-xl font-semibold mb-2 text-red-600">🗑️ الفواتير المحذوفة</h2>
    <table class="w-full border">
        <thead class="bg-red-100">
            <tr>
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">العميل</th>
                <th class="px-4 py-2 border">الإجمالي</th>
                <th class="px-4 py-2 border">تاريخ الحذف</th>
                <th class="px-4 py-2 border">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($deletedInvoices as $invoice)
                <tr>
                    <td class="border px-4 py-2">{{ $invoice->id }}</td>
                    <td class="border px-4 py-2">{{ $invoice->customer_name }}</td>
                    <td class="border px-4 py-2">{{ $invoice->total }}</td>
                    <td class="border px-4 py-2">{{ $invoice->deleted_at->diffForHumans() }}</td>
                    <td class="border px-4 py-2">
                        <form action="{{ route('invoices.restore', $invoice->id) }}" method="POST">
                            @csrf
                            <button class="px-3 py-1 bg-green-500 text-white rounded">استرجاع</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-gray-500 py-4">لا توجد فواتير محذوفة</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
