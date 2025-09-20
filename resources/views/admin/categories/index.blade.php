@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">التصنيفات</h1>
            <a href="{{ route('categories.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                + إضافة تصنيف
            </a>
        </div>

        {{-- ✅ رسالة نجاح --}}
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if($categories->count())
            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-3 border-b">#</th>
                        <th class="p-3 border-b">الاسم</th>
                        <th class="p-3 border-b">الوصف</th>
                        <th class="p-3 border-b text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border-b">{{ $loop->iteration }}</td>
                            <td class="p-3 border-b">{{ $category->name }}</td>
                            <td class="p-3 border-b">{{ $category->description }}</td>
                            <td class="p-3 border-b text-center">
                                <a href="{{ route('categories.edit', $category->id) }}"
                                   class="inline-block bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                    تعديل
                                </a>

                                <form action="{{ route('categories.destroy', $category->id) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا التصنيف؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-600">لا توجد تصنيفات مضافة حتى الآن.</p>
        @endif
    </div>
</main>
@endsection
