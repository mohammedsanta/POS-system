{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
    @livewireScripts
</head>
<body class="bg-gray-100 text-gray-800">

    {{-- ====== الهيدر ====== --}}
    <header class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                {{-- الشعار --}}
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-8 w-8 text-indigo-600" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                    <span class="font-bold text-lg text-indigo-700">لوحة التحكم</span>
                </div>

                {{-- القائمة --}}
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('admin.dashboard') }}"
                       class="hover:text-indigo-600 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600 font-semibold' : 'text-gray-700' }}">
                        الرئيسية
                    </a>

                    <a href="{{ route('expenses.indexAdmin') }}"
                       class="hover:text-indigo-600 {{ request()->routeIs('expenses.indexAdmin') ? 'text-indigo-600 font-semibold' : 'text-gray-700' }}">
                        المصاريف
                    </a>

                    <a href="{{ route('admin.commitments.index') }}"
                       class="hover:text-indigo-600 {{ request()->routeIs('admin.commitments.index') ? 'text-indigo-600 font-semibold' : 'text-gray-700' }}">
                        الالتزامات
                    </a>

                    <a href="{{ route('bookings.index') }}"
                       class="hover:text-indigo-600 {{ request()->routeIs('bookings.index') ? 'text-indigo-600 font-semibold' : 'text-gray-700' }}">
                        حجوزات
                    </a>

                    <a href="{{ route('admin.suppliers.index') }}"
                        class="hover:text-indigo-600 {{ request()->routeIs('admin.suppliers.index') ? 'text-indigo-600 font-semibold' : 'text-gray-700' }}">
                        الموردين
                    </a>

                    <a href="{{ route('purchases.index') }}"
                       class="hover:text-indigo-600 {{ request()->routeIs('purchases.index') ? 'text-indigo-600 font-semibold' : 'text-gray-700' }}">
                        المشتريات
                    </a>

                    <a href="{{ route('categories.index') }}"
                       class="hover:text-indigo-600 {{ request()->routeIs('categories.index') ? 'text-indigo-600 font-semibold' : 'text-gray-700' }}">
                        التصنيفات
                    </a>

                    <a href="{{ route('products.index') }}"
                       class="hover:text-indigo-600 {{ request()->routeIs('products.index') ? 'text-indigo-600 font-semibold' : 'text-gray-700' }}">
                        المنتجات
                    </a>

                    <a href="{{ route('admin.cashier') }}"
                       class="hover:text-indigo-600 {{ request()->routeIs('admin.cashier') ? 'text-indigo-600 font-semibold' : 'text-gray-700' }}">
                        الكاشير
                    </a>

                    <a href="{{ route('admin.products.barcodes') }}"
                       class="hover:text-indigo-600 {{ request()->routeIs('admin.products.barcodes') ? 'text-indigo-600 font-semibold' : 'text-gray-700' }}">
                        الباركود
                    </a>
                </nav>

                {{-- الجانب الأيمن --}}
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">
                        مرحبًا، المدير
                    </span>
                    <form method="POST" action="{{ route('owner.logout') }}">
                        @csrf
                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- ====== المحتوى ====== --}}
    <main class="py-8 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

</body>
</html>
