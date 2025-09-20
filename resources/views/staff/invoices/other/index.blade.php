@extends('layouts.Cashier')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow">

        {{-- العنوان --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">فواتير أخرى</h1>
            <a href="{{ route('other.invoices.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
               + إضافة فاتورة
            </a>
        </div>

        {{-- رسالة النجاح --}}
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-50 border border-green-100 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- الجدول --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">رقم الفاتورة</th>
                        <th class="px-4 py-2 border">اسم العميل</th>
                        <th class="px-4 py-2 border">الإجمالي</th>
                        <th class="px-4 py-2 border">الملاحظة</th>
                        <th class="px-4 py-2 border text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($otherInvoices as $invoice)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $invoice->invoice_number }}</td>
                            <td class="px-4 py-2 border">{{ $invoice->customer_name ?? '-' }}</td>
                            <td class="px-4 py-2 border">ج.م {{ number_format($invoice->total, 2) }}</td>
                            <td class="px-4 py-2 border">{{ $invoice->note ?? '-' }}</td>
                            <td class="px-4 py-2 border text-center">
                                <a href="{{ route('other.invoices.edit', $invoice->id) }}"
                                   class="text-blue-600 hover:underline mr-2">تعديل</a>

                                <form action="{{ route('other.invoices.destroy', $invoice->id) }}"
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذه الفاتورة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                لا توجد فواتير.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- الترقيم --}}
        <div class="mt-4">
            {{ $otherInvoices->links() }}
        </div>
    </div>
</main>
@endsection
