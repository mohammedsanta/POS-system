@extends('layouts.Admin')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 mt-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">تعديل عملية شراء</h2>

    <form method="POST" action="{{ route('purchases.update', $purchase->id) }}">
        @csrf
        @method('PUT')

        <input type="text"
               name="invoice_number"
               value="{{ old('invoice_number', $purchase->invoice_number) }}"
               placeholder="رقم الفاتورة"
               class="w-full mb-3 p-2 border">

        <input type="text"
               name="supplier_name"
               value="{{ old('supplier_name', $purchase->supplier_name) }}"
               placeholder="اسم المورد"
               class="w-full mb-3 p-2 border">

        <input type="number"
               step="0.01"
               name="total"
               value="{{ old('total', $purchase->total) }}"
               placeholder="الإجمالي"
               class="w-full mb-3 p-2 border">

        <textarea name="notes"
                  placeholder="ملاحظات"
                  class="w-full mb-3 p-2 border">{{ old('notes', $purchase->notes) }}</textarea>

        <input type="datetime-local"
               name="purchased_at"
               value="{{ old('purchased_at', $purchase->purchased_at) }}"
               class="w-full mb-3 p-2 border">

        <button class="bg-blue-600 text-white px-4 py-2 rounded">تحديث</button>
    </form>
</div>
@endsection
