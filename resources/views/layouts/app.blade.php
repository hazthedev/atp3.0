<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ATP 3.0')</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="appShell()" class="bg-gray-50 text-gray-900" @keydown.escape.window="closeSidebar()" x-effect="$el.style.setProperty('--sw', (sidebarCollapsed ? 64 : sidebarWidth) + 'px')">
    <x-sidebar />

    <div class="main-content min-h-screen">
        <x-navbar />

        <main class="page-transition-in p-4 md:p-6">
            <div class="mx-auto w-full max-w-[1600px] space-y-6">
                @yield('content')
            </div>
        </main>
    </div>

    <x-toast />

    @stack('modals')
    @livewireScriptConfig
</body>
</html>
