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
<body class="font-sans text-gray-900 antialiased h-full">
<div class="min-h-screen flex flex-col bg-gradient-to-br from-green-50 via-orange-50 to-yellow-50">
    <!-- Header -->
    @include('layouts.navigation')
    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Card Container -->
            <div class="bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
                <!-- Card Header -->
                <div class="px-8 pt-8 pb-6">
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="px-8 pb-8">
                    {{ $slot }}
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    En continuant, vous acceptez nos
                    <a href="#" class="text-green-600 hover:text-green-700 font-medium">conditions d'utilisation</a>
                    et notre
                    <a href="#" class="text-green-600 hover:text-green-700 font-medium">politique de confidentialité</a>
                </p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-sm border-t border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between text-sm text-gray-600">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Tous droits réservés.</p>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-green-600 transition-colors duration-200">Aide</a>
                    <a href="#" class="hover:text-green-600 transition-colors duration-200">Support</a>
                </div>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
