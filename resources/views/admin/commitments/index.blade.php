@extends('layouts.Admin')

@section('content')
<main class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-6xl mx-auto">

        {{-- رأس الصفحة --}}
        <h2 class="text-2xl font-bold mb-6 text-center">الالتزامات الشهرية للمحل 🏢</h2>

        {{-- فلتر بنطاق تواريخ --}}
        <form method="GET" action="{{ route('admin.commitments.index') }}" class="mb-4 flex items-center gap-4">
            <div>
                <label for="from" class="font-medium mr-1">من:</label>
                <input type="month" name="from" id="from" value="{{ request('from') }}" class="border rounded px-2 py-1">
            </div>
            <div>
                <label for="to" class="font-medium mr-1">إلى:</label>
                <input type="month" name="to" id="to" value="{{ request('to') }}" class="border rounded px-2 py-1">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">فلترة</button>
            <a href="{{ route('admin.commitments.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">إعادة ضبط</a>
        </form>

        {{-- زر إضافة جديد --}}
        <div class="mb-4 text-right">
            <a href="{{ route('admin.commitments.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded">
               إضافة التزام جديد
            </a>
        </div>

        {{-- جدول الالتزامات --}}
        <div class="bg-white p-6 rounded shadow">
            <table class="w-full text-sm text-left border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border">#</th>
                        <th class="py-2 px-4 border">الوصف</th>
                        <th class="py-2 px-4 border">المبلغ (EGP)</th>
                        <th class="py-2 px-4 border">الشهر</th>
                        <th class="py-2 px-4 border text-center">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commitments as $index => $commitment)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4 border">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 border">{{ $commitment->description }}</td>
                            <td class="py-2 px-4 border">{{ number_format($commitment->amount, 2) }}</td>
                            <td class="py-2 px-4 border">{{ \Carbon\Carbon::parse($commitment->month)->format('F Y') }}</td>
                            <td class="py-2 px-4 border text-center">
                                <a href="{{ route('admin.commitments.edit', $commitment->id) }}" class="text-blue-600 hover:underline mr-2">تعديل</a>
                                <form action="{{ route('admin.commitments.destroy', $commitment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا الالتزام؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">لا توجد التزامات مسجلة.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- إجمالي المبلغ --}}
            <div class="mt-4 text-right font-bold text-lg">
                إجمالي الالتزامات: EGP {{ number_format($total, 2) }}
            </div>
        </div>
    </div>
</main>
@endsection
