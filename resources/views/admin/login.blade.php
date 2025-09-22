<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 via-white to-green-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-green-100 text-green-700 mb-3">
                <!-- simple icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 11c0-1.657-1.343-3-3-3S6 9.343 6 11s1.343 3 3 3 3-1.343 3-3zm6 0c0-1.657-1.343-3-3-3s-3 1.343-3 3 1.343 3 3 3 3 3-1.343 3-3zM6 19h12v2H6v-2z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-800">Owner Login</h1>
            <p class="text-gray-500 text-sm mt-1">Access your dashboard securely</p>
        </div>

        <form method="POST" action="{{ route('owner.login') }}" class="space-y-5">
            @csrf

            {{-- username --}}
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="username" id="username" name="username"
                       class="w-full rounded-lg border-gray-300 focus:border-green-400 focus:ring-green-300 shadow-sm"
                       placeholder="owner@example.com" required autofocus>
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password"
                       class="w-full rounded-lg border-gray-300 focus:border-green-400 focus:ring-green-300 shadow-sm"
                       placeholder="••••••••" required>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full py-2.5 px-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-1 transition">
                Login
            </button>
        </form>

        <div class="mt-6 text-center text-sm">
            <span class="text-gray-600">Don’t have an account?</span>
            <a href="{{ route('owner.signup') }}" class="text-green-600 hover:underline font-medium">Sign up</a>
        </div>

        <!-- زر التوجّه مباشرة إلى الصفحة الرئيسية -->
        <div class="mt-4 text-center">
            <a href="/home"
               class="inline-block px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg shadow-sm transition">
                ⬅ العودة للصفحة الرئيسية
            </a>
        </div>
    </div>

</body>
</html>
