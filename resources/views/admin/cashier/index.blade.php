@extends('layouts.Admin')
@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">إدارة الكاشير</h1>

        <a href="{{ route('cashiers.create') }}" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">
            + إضافة كاشير
        </a>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border text-left text-sm">
                <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">اسم المستخدم</th>
                    <th class="px-4 py-2 border">رقم الهاتف</th>
                    <th class="px-4 py-2 border">آخر تسجيل دخول</th>
                    <th class="px-4 py-2 border">الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($cashiers as $cashier)
                    <tr>
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $cashier->username }}</td>
                        <td class="border px-4 py-2">01111111110</td>
                        <td class="border px-4 py-2">{{ $cashier->last_login ?? '-' }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('cashiers.edit',$cashier) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded">تعديل</a>
                            <form action="{{ route('cashiers.destroy',$cashier) }}" method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('هل تريد حذف هذا الكاشير؟')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 text-white px-3 py-1 rounded">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center p-4 text-gray-600">
                            لا يوجد كاشير مسجل.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $cashiers->links() }}
        </div>
    </div>
</main>
@endsection
