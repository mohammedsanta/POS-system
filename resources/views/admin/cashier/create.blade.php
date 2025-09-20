@extends('layouts.Admin')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">إضافة كاشير</h2>

    {{-- ✅ رسائل النجاح --}}
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-50 border border-green-100 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- ❌ رسائل الأخطاء --}}
    @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-red-50 border border-red-100 text-red-700 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('cashiers.store') }}">
        @csrf

        {{-- اسم المستخدم --}}
        <input type="text"
               name="username"
               value="{{ old('username') }}"
               placeholder="اسم المستخدم"
               class="border w-full mb-3 p-2 @error('username') border-red-500 @enderror"
               required>

        {{-- رقم الهاتف --}}
        <input type="text"
               name="phone"
               value="{{ old('phone') }}"
               placeholder="رقم الهاتف"
               class="border w-full mb-3 p-2">

        {{-- كلمة المرور --}}
        <input type="password"
               name="password"
               placeholder="كلمة المرور"
               class="border w-full mb-3 p-2 @error('password') border-red-500 @enderror">

        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            حفظ
        </button>
    </form>
</div>
@endsection
