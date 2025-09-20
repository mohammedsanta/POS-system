@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-center">تعديل المورد</h1>

        {{-- عرض الأخطاء --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- نموذج التعديل --}}
        <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 font-semibold">الاسم</label>
                <input type="text" name="name" value="{{ old('name', $supplier->name) }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">الهاتف</label>
                <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">العنوان</label>
                <input type="text" name="address" value="{{ old('address', $supplier->address) }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('admin.suppliers.index') }}" 
                   class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">
                    العودة
                </a>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
