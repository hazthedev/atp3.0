<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ATP 3.0')</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900">
    <main class="page-transition-in flex min-h-screen items-center justify-center p-6">
        <div class="w-full max-w-md">
            @yield('content')
        </div>
    </main>
    @livewireScriptConfig
</body>
</html>
