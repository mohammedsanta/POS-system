{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم')</title>
    <link href="{{ asset('css/tailwind.min.css') }}" rel="stylesheet">

    @livewireStyles
    @livewireScripts
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

    {{-- ====== الهيدر ====== --}}
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="w-full px-8">
            <div class="flex justify-between items-center h-20">

                {{-- الشعار --}}
                <div class="flex items-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-10 w-10 text-indigo-600" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                    <span class="font-extrabold text-2xl text-indigo-700">لوحة التحكم</span>
                </div>

                {{-- القائمة --}}
                <nav class="flex space-x-8 text-lg font-semibold">
                    <a href="{{ route('admin.dashboard') }}"
                       class="{{ request()->routeIs('admin.dashboard') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        الرئيسية
                    </a>
                    <a href="{{ route('admin.view.invoices') }}"
                       class="{{ request()->routeIs('admin.view.invoices') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        ادارة المبيعات
                    </a>
                    <a href="{{ route('expenses.indexAdmin') }}"
                       class="{{ request()->routeIs('expenses.indexAdmin') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        المصاريف
                    </a>
                    <a href="{{ route('admin.commitments.index') }}"
                       class="{{ request()->routeIs('admin.commitments.index') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        الالتزامات
                    </a>
                    <a href="{{ route('bookings.index') }}"
                       class="{{ request()->routeIs('bookings.index') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        الحجوزات
                    </a>
                    <a href="{{ route('admin.suppliers.index') }}"
                       class="{{ request()->routeIs('admin.suppliers.index') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        الموردين
                    </a>
                    <a href="{{ route('purchases.index') }}"
                       class="{{ request()->routeIs('purchases.index') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        المشتريات
                    </a>
                    <a href="{{ route('categories.index') }}"
                       class="{{ request()->routeIs('categories.index') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        التصنيفات
                    </a>
                    <a href="{{ route('products.index') }}"
                       class="{{ request()->routeIs('products.index') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        المنتجات
                    </a>
                    <a href="{{ route('admin.cashier') }}"
                       class="{{ request()->routeIs('admin.cashier') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        الكاشير
                    </a>
                    <a href="{{ route('admin.product-inventory') }}"
                       class="{{ request()->routeIs('admin.product-inventory') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        الجرد
                    </a>
                </nav>

                {{-- الجانب الأيمن --}}
                <div class="flex items-center space-x-6 text-lg">
                    <span class="text-gray-700 font-medium">
                        مرحبًا، المدير
                    </span>
                    <form method="POST" action="{{ route('owner.logout') }}">
                        @csrf
                        <button class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg shadow font-bold">
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- ====== المحتوى ====== --}}
    <main class="py-10 px-8">
        @yield('content')
    </main>

</body>
</html>
