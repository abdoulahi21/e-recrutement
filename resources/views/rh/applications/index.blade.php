<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                {{ __('Candidatures reçues') }}
            </h2>
            <div class="flex items-center space-x-2">
                <div class="bg-gradient-to-r from-green-500 to-orange-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                    {{ $applications->count() }} candidatures
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtres modernisés -->
            <div class="card mb-8">
                <div class="card-body">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filtres de recherche
                    </h3>

                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="form-label">Offre d'emploi</label>
                            <select name="offer_id" class="form-input border-gray-300">
                                <option value="">Toutes les offres</option>
                                @foreach ($offers as $offer)
                                    <option value="{{ $offer->id }}" {{ request('offer_id') == $offer->id ? 'selected' : '' }}>
                                        {{ $offer->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Statut</label>
                            <select name="status" class="form-input border-gray-300">
                                <option value="">Tous les statuts</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepté</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="btn-primary w-full md:w-auto">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Filtrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Liste des candidatures
                    </h3>
                </div>

                <div class="card-body">
                    @if($applications->isEmpty())
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-700 mb-2">Aucune candidature trouvée</h3>
                            <p class="text-gray-500">Il n'y a pas encore de candidatures correspondant à vos critères.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-4 px-2 font-semibold text-gray-700">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span>Candidat</span>
                                        </div>
                                    </th>
                                    <th class="text-left py-4 px-2 font-semibold text-gray-700">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 00-2 2H8a2 2 0 00-2-2V6m8 0h2a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h2"></path>
                                            </svg>
                                            <span>Offre</span>
                                        </div>
                                    </th>
                                    <th class="text-left py-4 px-2 font-semibold text-gray-700">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Statut</span>
                                        </div>
                                    </th>
                                    <th class="text-left py-4 px-2 font-semibold text-gray-700">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span>Actions</span>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                @foreach ($applications as $application)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="py-4 px-2">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-orange-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                                    {{ strtoupper(substr($application->user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $application->user->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $application->user->email ?? 'Email non renseigné' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-2">
                                            <div class="font-medium text-gray-900">{{ $application->offer->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $application->offer->location ?? 'Localisation non renseignée' }}</div>
                                        </td>
                                        <td class="py-4 px-2">
                                            <form method="POST" action="{{ route('rh.applications.update', $application) }}" class="flex items-center space-x-2">
                                                @csrf
                                                @method('PATCH')

                                                <select name="status" class="form-input border-gray-300 text-sm py-1 px-2 rounded-lg">
                                                    <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>
                                                        En attente
                                                    </option>
                                                    <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>
                                                        Accepté
                                                    </option>
                                                    <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>
                                                        Rejeté
                                                    </option>
                                                </select>

                                                <button type="submit" class="bg-gradient-to-r from-green-500 to-orange-500 hover:from-green-600 hover:to-orange-600 text-white px-3 py-1 rounded-lg text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="py-4 px-2">
                                            <a href="{{ route('rh.applications.show', $application) }}"
                                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200 group">
                                                <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Voir détails
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination si applicable -->
                        @if(method_exists($applications, 'links'))
                            <div class="mt-6 border-t border-gray-200 pt-6">
                                {{ $applications->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts pour interactions avancées -->
    <script>
        // Animation au survol des lignes du tableau
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(4px)';
                });
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });

            // Confirmation pour les changements de statut
            const statusSelects = document.querySelectorAll('select[name="status"]');
            statusSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const form = this.closest('form');
                    const button = form.querySelector('button[type="submit"]');
                    button.style.animation = 'pulse 0.5s ease-in-out';
                });
            });
        });
    </script>

    <style>
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; transform: scale(0.95); }
        }

        tbody tr {
            transition: transform 0.2s ease-in-out;
        }
    </style>
</x-app-layout>
