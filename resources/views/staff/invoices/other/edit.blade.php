{{-- resources/views/staff/invoices/other/edit.blade.php --}}
@extends('layouts.Cashier')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-2xl shadow">

        <h1 class="text-2xl font-bold text-center mb-6">تعديل فاتورة بيع</h1>

        {{-- رسائل الأخطاء --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 text-red-700 border border-red-200 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('other.invoices.update', $invoice->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- رقم الفاتورة --}}
            <div>
                <label class="block mb-1 font-semibold text-sm text-gray-700">رقم الفاتورة</label>
                <input type="text" name="invoice_number" value="{{ old('invoice_number', $invoice->invoice_number) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            {{-- اسم العميل --}}
            <div>
                <label class="block mb-1 font-semibold text-sm text-gray-700">اسم العميل</label>
                <input type="text" name="customer_name" value="{{ old('customer_name', $invoice->customer_name) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- وصف المنتج/الخدمة --}}
            <div>
                <label class="block mb-1 font-semibold text-sm text-gray-700">وصف ما تم بيعه</label>
                <textarea name="description" rows="3"
                          class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                          placeholder="اكتب وصف ما تم بيعه">{{ old('description', $invoice->description) }}</textarea>
            </div>

            {{-- السعر --}}
            <div>
                <label class="block mb-1 font-semibold text-sm text-gray-700">السعر للوحدة</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $invoice->price) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            {{-- الكمية --}}
            <div>
                <label class="block mb-1 font-semibold text-sm text-gray-700">الكمية</label>
                <input type="number" min="1" name="quantity" value="{{ old('quantity', $invoice->quantity) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            {{-- الملاحظات --}}
            <div>
                <label class="block mb-1 font-semibold text-sm text-gray-700">ملاحظات</label>
                <textarea name="notes" rows="3"
                          class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                          placeholder="اكتب أي ملاحظة تخص الفاتورة">{{ old('notes', $invoice->notes) }}</textarea>
            </div>

            {{-- زر الحفظ --}}
            <div class="flex justify-end">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
                    تحديث الفاتورة
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
