{{-- resources/views/layouts/header.blade.php --}}
<header class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- الشعار --}}
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                </svg>
                <span class="font-bold text-lg">نظام نقاط البيع</span>
            </div>

            {{-- روابط التنقل --}}
            <nav class="hidden md:flex space-x-6">

                <a href="{{ route('cashier.dashboard') }}"
                   class="text-gray-700 hover:text-green-600 font-medium {{ request()->routeIs('cashier.dashboard') ? 'text-green-600 font-semibold' : '' }}">
                    لوحة التحكم
                </a>

                <a href="{{ route('invoices.create') }}"
                   class="text-gray-700 hover:text-green-600 font-medium {{ request()->routeIs('invoices.create') ? 'text-green-600 font-semibold' : '' }}">
                    عملية بيع جديدة
                </a>

                <a href="{{ route('other.invoices.index') }}"
                   class="text-gray-700 hover:text-green-600 font-medium {{ request()->routeIs('other.invoices.index') ? 'text-green-600 font-semibold' : '' }}">
                    بيع
                </a>

                <a href="{{ route('expenses.index') }}"
                   class="text-gray-700 hover:text-green-600 font-medium {{ request()->routeIs('expenses.index') ? 'text-green-600 font-semibold' : '' }}">
                    مصروف
                </a>

                <a href="{{ route('invoices.index') }}"
                   class="text-gray-700 hover:text-green-600 font-medium {{ request()->routeIs('invoices.index') ? 'text-green-600 font-semibold' : '' }}">
                    سجل المبيعات
                </a>

                <a href="{{ route('barcodes.index') }}"
                   class="text-gray-700 hover:text-green-600 font-medium {{ request()->routeIs('barcodes.index') ? 'text-green-600 font-semibold' : '' }}">
                    باركود المنتجات
                </a>

                {{-- رابط المرتجع --}}
                <a href="{{ route('returns.index') }}"
                   class="text-gray-700 hover:text-green-600 font-medium {{ request()->routeIs('returns.index') ? 'text-green-600 font-semibold' : '' }}">
                    المرتجع
                </a>
            </nav>

            {{-- الجانب الأيمن --}}
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 text-sm">
                    أهلاً، {{ auth()->user()->username ?? 'مستخدم' }}
                </span>
                <form method="POST" action="{{ route('staff.logout') }}">
                    @csrf
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
