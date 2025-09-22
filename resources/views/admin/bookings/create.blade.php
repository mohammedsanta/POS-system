{{-- resources/views/admin/bookings/create.blade.php --}}
@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">

        <h1 class="text-2xl font-bold mb-6">إضافة حجز جديد</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 text-red-700 border border-red-200 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('bookings.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-semibold text-gray-700">اسم العميل</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-700">ما يريد حجزه</label>
                <input type="text" name="item" value="{{ old('item') }}" required
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                       placeholder="مثل: موبايل Samsung S23">
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-700">رقم الهاتف</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-700">العنوان</label>
                <input type="text" name="address" value="{{ old('address') }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-700">الديبوسيت</label>
                <input type="number" name="deposit" step="0.01" value="{{ old('deposit') }}" required
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- 👇 حقل سعر البيع --}}
            <div>
                <label class="block mb-1 font-semibold text-gray-700">سعر البيع</label>
                <input type="number" name="selling_price" step="0.01" value="{{ old('selling_price') }}" required
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                       placeholder="اكتب السعر النهائي للعميل">
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-700">تاريخ الحجز</label>
                <input type="date" name="booking_date" value="{{ old('booking_date', date('Y-m-d')) }}" required
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            <div class="flex justify-end mt-4">
                <a href="{{ route('bookings.index') }}" class="text-gray-600 hover:underline mr-4">رجوع</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">
                    حفظ الحجز
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
