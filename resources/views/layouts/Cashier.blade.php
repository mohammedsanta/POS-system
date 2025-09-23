<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier System</title>

    {{-- Tailwind CDN or your custom CSS --}}
            <link href="{{ asset('css/tailwind.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100">

    @include('layouts.Header')  {{-- ✅ include header here --}}

    <main>
        @yield('content')
    </main>

</body>
</html>
