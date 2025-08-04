<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Tableau de bord RH') }}
                </h2>
                <p class="text-gray-600 mt-1">Gérez vos offres et candidatures</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('rh.offers.create') }}" class="btn-primary inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nouvelle offre
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Messages flash -->


            <!-- Statistiques principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Offres actives -->
                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Offres actives</p>
                            <p class="text-3xl font-bold text-green-600">{{ $totalOffers ?? 0 }}</p>
                            <p class="text-sm text-green-600 mt-1">
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    +{{ $thisMonthOffers ?? 0 }} ce mois
                                </span>
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Candidatures reçues -->
                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Candidatures</p>
                            <p class="text-3xl font-bold text-orange-600">{{ $totalApplications ?? 0 }}</p>
                            <p class="text-sm text-orange-600 mt-1">
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    +{{ $thisWeekApplications ?? 0 }} cette semaine
                                </span>
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- En attente -->
                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">En attente</p>
                            <p class="text-3xl font-bold text-yellow-600">{{ $pendingApplications ?? 0 }}</p>
                            <p class="text-sm text-gray-500 mt-1">À traiter</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Taux d'acceptation -->
                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Taux d'acceptation</p>
                            <p class="text-3xl font-bold text-green-600">{{ $acceptanceRate ?? 0 }}%</p>
                            <p class="text-sm {{ ($acceptanceRateChange ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                                {{ ($acceptanceRateChange ?? 0) >= 0 ? '+' : '' }}{{ $acceptanceRateChange ?? 0 }}% vs mois dernier
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Actions rapides -->
            <div class="mt-4 card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-gray-900">Actions rapides</h3>
                    <p class="text-sm text-gray-600">Raccourcis vers les fonctionnalités principales</p>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('rh.offers.create') }}" class="p-4 border border-gray-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-colors duration-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Créer une offre</h4>
                                    <p class="text-sm text-gray-600">Publier un nouveau poste</p>
                                </div>
                            </div>
                        </a>

                        <a
                            href="{{ route('rh.applications.index') }}"
                            class="p-4 border border-gray-200 rounded-lg hover:border-orange-300 hover:bg-orange-50 transition-colors duration-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v1a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2v-8a2 2 0 00-2-2v-1a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Gérer les candidatures</h4>
                                    <p class="text-sm text-gray-600">Examiner les profils</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('rh.stats') }}" class="p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-colors duration-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Voir les statistiques</h4>
                                    <p class="text-sm text-gray-600">Analyser les performances</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Graphiques et tableaux -->
            <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Graphique des candidatures -->
                <div class="lg:col-span-2 card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-900">Évolution des candidatures</h3>
                        <p class="text-sm text-gray-600">Derniers 6 mois</p>
                    </div>
                    <div class="card-body">
                        <div class="h-64 flex items-center justify-center">
                            <!-- Canvas pour le graphique -->
                            <canvas id="applicationsChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Répartition par statut -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-900">Répartition</h3>
                        <p class="text-sm text-gray-600">Par statut</p>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">En attente</span>
                                </div>
                                <span class="text-sm font-semibold">{{ $pendingApplications ?? 0 }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Acceptées</span>
                                </div>
                                <span class="text-sm font-semibold">{{ $acceptedApplications ?? 0 }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Rejetées</span>
                                </div>
                                <span class="text-sm font-semibold">{{ $rejectedApplications ?? 0 }}</span>
                            </div>
                        </div>

                        <!-- Graphique circulaire simple -->
                        <div class="mt-6 flex justify-center">
                            <div class="relative w-32 h-32">
                                <svg class="w-32 h-32 progress-ring" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="40" fill="none" stroke="#e5e7eb" stroke-width="8"/>
                                    <circle cx="50" cy="50" r="40" fill="none" stroke="#10b981" stroke-width="8"
                                            stroke-dasharray="{{ ($acceptedApplications ?? 0) * 2.51 ?? 0 }} 251.2"
                                            stroke-dashoffset="0"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-lg font-bold text-gray-900">{{ $acceptanceRate ?? 0 }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableaux des données -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Offres récentes -->
                <div class="card">
                    <div class="card-header flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Offres récentes</h3>
                            <p class="text-sm text-gray-600">Vos dernières publications</p>
                        </div>
                        <a href="{{ route('rh.offers.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                            Voir tout →
                        </a>
                    </div>
                    <div class="card-body">
                        @forelse($recentOffers ?? [] as $offer)
                            <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $offer->title }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ $offer->type }} • {{ $offer->apply_count ?? 0 }} candidatures
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $offer->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $offer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $offer->status === 'active' ? 'Active' : 'Inactive' }}
                                    </span>
                                    <a href="{{ route('rh.offers.show', $offer) }}" class="text-green-600 hover:text-green-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-500">Aucune offre publiée</p>
                                <a href="{{ route('rh.offers.create') }}" class="btn-primary mt-4 inline-flex items-center">
                                    Créer votre première offre
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Candidatures récentes -->
                <div class="card">
                    <div class="card-header flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Candidatures récentes</h3>
                            <p class="text-sm text-gray-600">Nécessitent votre attention</p>
                        </div>
                        <a
{{--                            href="{{ route('rh.applications.index') }}" --}}
                            class="text-green-600 hover:text-green-700 text-sm font-medium">
                            Voir tout →
                        </a>
                    </div>
                    <div class="card-body">
                        @forelse($recentApplications ?? [] as $application)
                            <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-orange-500 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-medium">
                                            {{ substr($application->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $application->user->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $application->offer->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $application->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                           ($application->status === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $application->status_label }}
                                    </span>
                                    <a href="{{ route('rh.offers.applications', $application) }}" class="text-green-600 hover:text-green-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-gray-500">Aucune candidature reçue</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Script pour le graphique -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Graphique des candidatures
        const ctx = document.getElementById('applicationsChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($monthlyProgress->pluck('month')),
                    datasets: [{
                        label: 'Candidatures reçues',
                        data: @json($monthlyProgress->pluck('total')),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>
