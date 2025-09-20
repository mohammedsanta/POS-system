@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">تعديل بيانات الكاشير</h1>

        {{-- رسائل الخطأ --}}
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- رسائل النجاح --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- نموذج تعديل الكاشير --}}
        <form method="POST" action="{{ route('cashiers.update', $staff->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- اسم المستخدم --}}
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">اسم المستخدم</label>
                <input type="text"
                       id="username"
                       name="username"
                       value="{{ old('username', $staff->username) }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 px-4 py-2"
                       required>
            </div>

            {{-- كلمة المرور الجديدة --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    كلمة المرور الجديدة
                    <span class="text-xs text-gray-400">(اتركه فارغًا للإبقاء على كلمة المرور الحالية)</span>
                </label>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="••••••••"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 px-4 py-2"
                       autocomplete="new-password">
            </div>

            {{-- تأكيد كلمة المرور --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">تأكيد كلمة المرور</label>
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       placeholder="••••••••"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 px-4 py-2"
                       autocomplete="new-password">
            </div>

            {{-- الأزرار --}}
            <div class="flex items-center justify-between pt-4">
                <a href="{{ route('admin.cashier') }}"
                   class="inline-flex items-center text-gray-600 hover:text-gray-800 text-sm">
                    ← رجوع
                </a>

                <div class="flex gap-3">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg shadow">
                        حفظ التعديلات
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection
