<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold text-center mb-6">Staff Login</h1>

        {{-- رسائل الأخطاء --}}
        @if($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- رسائل النجاح --}}
        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- نموذج تسجيل الدخول --}}
        <form method="POST" action="{{ url('/staff/login') }}">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium mb-1">Username</label>
                <input type="text" id="username" name="username"
                       value="{{ old('username') }}"
                       required autofocus
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium mb-1">Password</label>
                <input type="password" id="password" name="password"
                       required
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded">
                Login
            </button>
        </form>

        <!-- زر العودة للصفحة الرئيسية -->
        <div class="mt-5 text-center">
            <a href="/home"
               class="inline-block px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded shadow-sm transition">
                ⬅ العودة للصفحة الرئيسية
            </a>
        </div>
    </div>
</body>
</html>
