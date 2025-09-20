@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-xl mx-auto bg-white rounded shadow p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">تعديل التصنيف</h1>

        {{-- ❌ رسائل الأخطاء --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('categories.update', $category->id) }}" class="grid gap-4">
            @csrf
            @method('PUT')

            {{-- اسم التصنيف --}}
            <input type="text" name="name" placeholder="اسم التصنيف"
                   value="{{ old('name', $category->name) }}" required
                   class="border rounded px-3 py-2">

            {{-- الوصف --}}
            <textarea name="description" placeholder="الوصف"
                      class="border rounded px-3 py-2">{{ old('description', $category->description) }}</textarea>

            {{-- أزرار التحكم --}}
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                حفظ التعديلات
            </button>

            <a href="{{ route('categories.index') }}" class="text-blue-600 underline text-center">
                العودة إلى التصنيفات
            </a>
        </form>
    </div>
</main>
@endsection
