<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نظام نقاط البيع - الصفحة الرئيسية</title>
    <link href="{{ asset('css/tailwind.min.css') }}" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 flex items-center justify-center">

    <div class="bg-white/90 backdrop-blur-md p-10 rounded-3xl shadow-2xl w-full max-w-md text-center">
        <!-- الشعار -->
        <div class="mb-6">
            <div class="mx-auto w-20 h-20 bg-gradient-to-tr from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 3h18v18H3V3z M16 8h2v8h-2V8z M6 8h2v8H6V8z M11 8h2v8h-2V8z"/>
                </svg>
            </div>
        </div>

        <!-- العنوان -->
        <h1 class="text-3xl font-extrabold text-gray-800 mb-3">مرحبًا بك 👋</h1>
        <p class="text-gray-600 text-lg mb-8">اختر طريقة تسجيل الدخول لنظام نقاط البيع</p>

        <!-- الأزرار -->
        <div class="space-y-4">
            <a href="{{ route('owner.login') }}"
               class="block w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-3 rounded-xl text-lg font-semibold shadow transition">
                👑 دخول المالك (Owner)
            </a>

            <a href="{{ route('login') }}"
               class="block w-full bg-gradient-to-r from-green-400 to-emerald-500 hover:from-green-500 hover:to-emerald-600 text-white py-3 rounded-xl text-lg font-semibold shadow transition">
                👨‍💼 دخول الموظف (Staff)
            </a>
        </div>

        <!-- نص سفلي -->
        <div class="mt-8 text-sm text-gray-500">
            &copy; {{ date('Y') }} Santa جميع الحقوق محفوظة - نظام نقاط البيع
        </div>
    </div>

</body>
</html>
