@extends('layouts.Admin')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 mt-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">إضافة عملية شراء</h2>

    <form method="POST" action="{{ route('purchases.store') }}">
        @csrf
        <input type="text" name="invoice_number" placeholder="رقم الفاتورة" class="w-full mb-3 p-2 border">
        <input type="text" name="supplier_name" placeholder="اسم المورد" class="w-full mb-3 p-2 border">
        <input type="number" step="0.01" name="total" placeholder="الإجمالي" required class="w-full mb-3 p-2 border">
        <textarea name="notes" placeholder="ملاحظات" class="w-full mb-3 p-2 border"></textarea>
        <input type="datetime-local" name="purchased_at" class="w-full mb-3 p-2 border">
        <button class="bg-green-600 text-white px-4 py-2 rounded">حفظ</button>
    </form>
</div>
@endsection
