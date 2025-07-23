<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Tableau de bord') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Bienvenue, {{ Auth::user()->name }} ! Voici un aperçu de votre activité.
                </p>
            </div>
            <div class="flex space-x-3">
                <button class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-md hover:shadow-lg">
                    Nouveau projet
                </button>
                <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors duration-200">
                    Exporter
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
    </div>
</x-app-layout>
