@extends('layouts.Admin')

@section('content')
<main class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">إضافة التزام جديد</h2>

        @if($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.commitments.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-medium">الوصف</label>
                <input type="text" name="description" value="{{ old('description') }}" required
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">المبلغ (EGP)</label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" required
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">الشهر</label>
                <input type="month" name="month" value="{{ old('month') }}" required
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded">
                إضافة
            </button>
        </form>
    </div>
</main>
@endsection
