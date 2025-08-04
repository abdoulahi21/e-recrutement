<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center space-x-4">
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    {{ __('Tableau de bord RH') }}
                </h2>
                <div class="bg-gradient-to-r from-green-500 to-orange-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                    Analytiques
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <div class="bg-white rounded-lg shadow-sm px-3 py-2 text-sm text-gray-600">
                    <span class="font-medium">Période:</span> 12 derniers mois
                </div>
                <button onclick="exportStats()" class="btn-secondary text-sm">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Exporter
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Statistiques générales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $totalApplications = 0;
                    $acceptedApplications = 0;
                    $pendingApplications = 0;
                    $rejectedApplications = 0;

                    foreach($monthlyStats as $year => $months) {
                        foreach($months as $month => $statuses) {
                            foreach($statuses as $stat) {
                                $totalApplications += $stat->count;
                                if($stat->status === 'accepted') $acceptedApplications += $stat->count;
                                if($stat->status === 'pending') $pendingApplications += $stat->count;
                                if($stat->status === 'rejected') $rejectedApplications += $stat->count;
                            }
                        }
                    }

                    $conversionRate = $totalApplications > 0 ? round(($acceptedApplications / $totalApplications) * 100, 1) : 0;
                @endphp

                    <!-- Total candidatures -->
                <div class="stat-card group hover:shadow-green">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 group-hover:text-green-700 transition-colors">Total candidatures</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalApplications) }}</p>
                            <p class="text-xs text-gray-500 mt-1">Sur 12 mois</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Candidatures acceptées -->
                <div class="stat-card group hover:shadow-green">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 group-hover:text-green-700 transition-colors">Acceptées</p>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($acceptedApplications) }}</p>
                            <p class="text-xs text-green-600 mt-1">{{ $conversionRate }}% de conversion</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Candidatures en attente -->
                <div class="stat-card group hover:shadow-orange">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 group-hover:text-orange-700 transition-colors">En attente</p>
                            <p class="text-2xl font-bold text-orange-600">{{ number_format($pendingApplications) }}</p>
                            <p class="text-xs text-orange-600 mt-1">À traiter</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-100 to-orange-200 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Candidatures rejetées -->
                <div class="stat-card group hover:shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 group-hover:text-red-700 transition-colors">Rejetées</p>
                            <p class="text-2xl font-bold text-red-600">{{ number_format($rejectedApplications) }}</p>
                            <p class="text-xs text-red-600 mt-1">{{ $totalApplications > 0 ? round(($rejectedApplications / $totalApplications) * 100, 1) : 0 }}% du total</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-red-100 to-red-200 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Évolution mensuelle -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Évolution mensuelle
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Répartition par type -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                            Répartition par type d'offre
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="typeChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Analyse détaillée -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Top performing offers -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            Tendances mensuelles
                        </h3>
                    </div>
                    <div class="card-body">
                        @php
                            $monthNames = [
                                '01' => 'Jan', '02' => 'Fév', '03' => 'Mar', '04' => 'Avr',
                                '05' => 'Mai', '06' => 'Jun', '07' => 'Jul', '08' => 'Aoû',
                                '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Déc'
                            ];
                            $monthlyTotals = [];

                            foreach($monthlyStats as $year => $months) {
                                foreach($months as $month => $statuses) {
                                    $total = $statuses->sum('count');
                                    $monthlyTotals[$monthNames[$month] ?? $month] = $total;
                                }
                            }

                            // Trier par mois chronologique (approximation)
                            ksort($monthlyTotals);
                        @endphp

                        <div class="space-y-4">
                            @foreach(array_slice($monthlyTotals, -6, 6, true) as $month => $total)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">{{ $month }}</span>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-green-500 to-orange-500 h-2 rounded-full"
                                                 style="width: {{ $total > 0 ? min(($total / max($monthlyTotals)) * 100, 100) : 0 }}%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900 w-8">{{ $total }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Types d'offres performance -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 00-2 2H8a2 2 0 00-2-2V6m8 0h2a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h2"></path>
                            </svg>
                            Performance par type
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            @foreach($typeStats as $type => $statuses)
                                @php
                                    $totalForType = $statuses->sum('count');
                                    $acceptedForType = $statuses->where('status', 'accepted')->sum('count');
                                    $conversionForType = $totalForType > 0 ? round(($acceptedForType / $totalForType) * 100, 1) : 0;
                                @endphp
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-gray-700">{{ $type ?: 'Non spécifié' }}</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $totalForType }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-gradient-to-r from-green-500 to-orange-500 h-2 rounded-full"
                                                 style="width: {{ $conversionForType }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $conversionForType }}%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Insights et recommandations -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            Insights
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            @if($conversionRate >= 20)
                                <div class="flex items-start space-x-3 p-3 bg-green-50 rounded-lg">
                                    <svg class="w-5 h-5 text-green-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-green-800">Excellent taux de conversion</p>
                                        <p class="text-xs text-green-600">Vos offres attirent des candidats qualifiés</p>
                                    </div>
                                </div>
                            @endif

                            @if($pendingApplications > 10)
                                <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg">
                                    <svg class="w-5 h-5 text-orange-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-orange-800">Candidatures en attente</p>
                                        <p class="text-xs text-orange-600">{{ $pendingApplications }} candidatures nécessitent votre attention</p>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg">
                                <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-800">Conseil</p>
                                    <p class="text-xs text-blue-600">Traitez les candidatures rapidement pour améliorer votre image employeur</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // Données pour les graphiques
        const monthlyData = @json($monthlyStats);
        const typeData = @json($typeStats);

        // Configuration des couleurs
        const colors = {
            primary: '#10b981',
            secondary: '#f97316',
            success: '#059669',
            warning: '#d97706',
            danger: '#dc2626',
            gradient: {
                primary: 'linear-gradient(135deg, #10b981, #f97316)',
                success: 'linear-gradient(135deg, #059669, #10b981)',
                warning: 'linear-gradient(135deg, #d97706, #f59e0b)',
                danger: 'linear-gradient(135deg, #dc2626, #ef4444)'
            }
        };

        // Graphique mensuel
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');

        // Préparer les données mensuelles
        const monthLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
        const monthlyAccepted = new Array(12).fill(0);
        const monthlyPending = new Array(12).fill(0);
        const monthlyRejected = new Array(12).fill(0);

        Object.keys(monthlyData).forEach(year => {
            Object.keys(monthlyData[year]).forEach(month => {
                const monthIndex = parseInt(month) - 1;
                monthlyData[year][month].forEach(stat => {
                    if (stat.status === 'accepted') monthlyAccepted[monthIndex] += stat.count;
                    if (stat.status === 'pending') monthlyPending[monthIndex] += stat.count;
                    if (stat.status === 'rejected') monthlyRejected[monthIndex] += stat.count;
                });
            });
        });

        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Acceptées',
                    data: monthlyAccepted,
                    borderColor: colors.success,
                    backgroundColor: colors.success + '20',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'En attente',
                    data: monthlyPending,
                    borderColor: colors.warning,
                    backgroundColor: colors.warning + '20',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Rejetées',
                    data: monthlyRejected,
                    borderColor: colors.danger,
                    backgroundColor: colors.danger + '20',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
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
                            color: '#f3f4f6'
                        }
                    }
                }
            }
        });

        // Graphique par type
        const typeCtx = document.getElementById('typeChart').getContext('2d');

        const typeLabels = Object.keys(typeData);
        const typeTotals = typeLabels.map(type => {
            return typeData[type].reduce((sum, stat) => sum + stat.count, 0);
        });

        new Chart(typeCtx, {
            type: 'doughnut',
            data: {
                labels: typeLabels.map(type => type || 'Non spécifié'),
                datasets: [{
                    data: typeTotals,
                    backgroundColor: [
                        colors.primary,
                        colors.secondary,
                        colors.success,
                        colors.warning,
                        colors.danger,
                        '#8b5cf6',
                        '#06b6d4'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Fonction d'export
        function exportStats() {
            // Simulation d'export - vous pouvez implémenter la logique réelle
            alert('Fonctionnalité d\'export en cours de développement');
        }

        // Animation au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.stat-card, .card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>

    <style>
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
        }

        .hover\:shadow-green:hover {
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.15);
        }

        .hover\:shadow-orange:hover {
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.15);
        }

        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .animate-pulse-slow {
            animation: pulse-slow 2s ease-in-out infinite;
        }
    </style>
</x-app-layout>
