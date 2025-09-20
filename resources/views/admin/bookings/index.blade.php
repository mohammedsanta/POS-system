{{-- resources/views/admin/bookings/index.blade.php --}}
@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">حجوزات الموبايل</h1>
            <a href="{{ route('bookings.create') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
               + إضافة حجز
            </a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-50 border border-green-100 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">اسم العميل</th>
                        <th class="px-4 py-2 border">ما يريد حجزه</th>
                        <th class="px-4 py-2 border">رقم الهاتف</th>
                        <th class="px-4 py-2 border">العنوان</th>
                        <th class="px-4 py-2 border">الديبوسيت</th>
                        <th class="px-4 py-2 border">تاريخ الحجز</th>
                        <th class="px-4 py-2 border text-center">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $booking->customer_name }}</td>
                            <td class="px-4 py-2 border">{{ $booking->item }}</td>
                            <td class="px-4 py-2 border">{{ $booking->phone }}</td>
                            <td class="px-4 py-2 border">{{ $booking->address ?? '-' }}</td>
                            <td class="px-4 py-2 border">ج.م {{ number_format($booking->deposit,2) }}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-2 border text-center">
                                <a href="{{ route('bookings.edit', $booking->id) }}" class="text-blue-600 hover:underline mr-2">تعديل</a>
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="inline-block" 
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الحجز؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500">لا توجد حجوزات.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    </div>
</main>
@endsection
