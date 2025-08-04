<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full bg-gradient-to-br from-gray-50 to-gray-100">
<div class="min-h-screen flex flex-col">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    {{ $header }}
                </div>
            </div>
        </header>
    @endif
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-full mt-6">
{{--    @if(session('success'))--}}
{{--        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 w-full rounded-lg">--}}
{{--            {{ session('success') }}--}}
{{--        </div>--}}
{{--    @endif--}}
{{--    @if(session('error'))--}}
{{--        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">--}}
{{--            {{ session('error') }}--}}
{{--        </div>--}}
{{--    @endif--}}
        @if(session('success'))
            <div id="success-alert" class="mb-6 bg-green-50 border border-green-200
            text-green-700 px-4 py-3 w-full rounded-lg flex items-center justify-between">
                {{ session('success') }}
                <button onclick="document.getElementById('success-alert').style.display='none'"
                        class="text-green-700 hover:text-green-900">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x">
                        <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="error-alert" class="mb-6 bg-red-50 border border-red-200
            text-red-700 px-4 py-3 w-full rounded-lg flex items-center justify-between">
                {{ session('error') }}
                <button onclick="document.getElementById('error-alert').style.display='none'"
                        class="text-red-700 hover:text-red-900">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x">
                        <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>
        @endif

    </div>
    <!-- Page Content -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between text-sm text-gray-600">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Tous droits réservés.</p>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-green-600 transition-colors duration-200">Conditions</a>
                    <a href="#" class="hover:text-green-600 transition-colors duration-200">Confidentialité</a>
                    <a href="#" class="hover:text-green-600 transition-colors duration-200">Contact</a>
                </div>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
