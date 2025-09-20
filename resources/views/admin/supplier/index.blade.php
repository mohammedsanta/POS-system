{{-- resources/views/suppliers/index.blade.php --}}
@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto bg-white rounded-lg shadow p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold flex-1">الموردين</h1>
            <a href="{{ route('admin.suppliers.create') }}" 
               class="ml-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
               + إضافة مورد
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border px-3 py-2">#</th>
                    <th class="border px-3 py-2">الاسم</th>
                    <th class="border px-3 py-2">الهاتف</th>
                    <th class="border px-3 py-2">العنوان</th>
                    <th class="border px-3 py-2">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $index => $supplier)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : '' }}">
                        <td class="border px-3 py-2">{{ $suppliers->firstItem() + $index }}</td>
                        <td class="border px-3 py-2">{{ $supplier->name }}</td>
                        <td class="border px-3 py-2">{{ $supplier->phone ?? '-' }}</td>
                        <td class="border px-3 py-2">{{ $supplier->address ?? '-' }}</td>
                        <td class="border px-3 py-2 space-x-2">
                            <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" 
                               class="text-blue-600 hover:underline">تعديل</a>
                            <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('هل أنت متأكد؟');" 
                                        class="text-red-600 hover:underline">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-3 py-2 text-center text-gray-500">
                            لا يوجد موردين.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $suppliers->links() }}
        </div>
    </div>
</main>
@endsection
