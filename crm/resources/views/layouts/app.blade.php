<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Hamyar CRM') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto">Hamyar CRM</div>
    </nav>
    <div class="flex flex-1">
        <aside class="w-64 bg-gray-800 text-white hidden md:block">
            <!-- Sidebar -->
        </aside>
        <main class="flex-1 p-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
