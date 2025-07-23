<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Mon Tableau de bord') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Bienvenue, {{ Auth::user()->name }} ! Suivez l'état de vos candidatures.
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('jobs') }}" class="bg-gradient-to-r from-green-500 to-orange-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-green-600 hover:to-orange-600 transition-all duration-200 shadow-md hover:shadow-lg">
                    Parcourir les offres
                </a>
                <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors duration-200">
                    Mon CV
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Candidatures envoyées -->
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Candidatures envoyées</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalApplications ?? 0 }}</p>
                                <p class="text-xs text-blue-600 font-medium">{{ $thisMonthApplications ?? 0 }} ce mois</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Candidatures en attente -->
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">En attente</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $pendingApplications ?? 0 }}</p>
                                <p class="text-xs text-yellow-600 font-medium">En cours d'examen</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Candidatures acceptées -->
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Acceptées</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $acceptedApplications ?? 0 }}</p>
                                <p class="text-xs text-green-600 font-medium">
                                    {{ $acceptanceRate ?? 0 }}% de réussite
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Candidatures rejetées -->
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Rejetées</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $rejectedApplications ?? 0 }}</p>
                                <p class="text-xs text-red-600 font-medium">Feedback disponible</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Mes Candidatures Récentes -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Mes candidatures récentes</h3>
                            <a
{{--                                href="{{ route('applications.index') }}"--}}
                                class="text-sm font-medium text-green-600 hover:text-green-700">
                                Voir tout
                            </a>
                        </div>
                    </div>
                    <div class="p-0">
                        <div class="divide-y divide-gray-200">
                            @forelse($recentApplications ?? [] as $application)
                                <!-- Application Item -->
                                <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-orange-500 rounded-lg flex items-center justify-center mr-4">
                                            <span class="text-white text-sm font-bold">
                                                {{ substr($application->offer->title ?? 'OF', 0, 2) }}
                                            </span>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900">
                                                    {{ $application->offer->title ?? 'Titre non disponible' }}
                                                </h4>
                                                <p class="text-sm text-gray-500">
                                                    Postulé le {{ $application->created_at->format('d M Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($application->status === 'accepted') bg-green-100 text-green-800
                                            @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $application->status_label }}
                                        </span>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $application->offer->type ?? 'Type non spécifié' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="text-sm">Aucune candidature pour le moment</p>
                                    <a href="{{ route('jobs') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                                        Découvrir les offres
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Quick Actions & Activity -->
                <div class="space-y-6">

                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-200">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Actions rapides</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <a href="{{ route('jobs') }}" class="w-full flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-green-100 rounded-lg hover:from-green-100 hover:to-green-200 transition-all duration-200">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">Chercher des offres</span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>

                            <a href="{{ route('profile.edit') }}" class="w-full flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg hover:from-blue-100 hover:to-blue-200 transition-all duration-200">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">Mettre à jour profil</span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>

                            <a
{{--                                href="{{ route('applications.index') }}"--}}
                                class="w-full flex items-center justify-between p-3 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg hover:from-orange-100 hover:to-orange-200 transition-all duration-200">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">Mes candidatures</span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-200">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Notifications récentes</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @forelse($recentNotifications ?? [] as $notification)
                                    <div class="flex items-start">
                                        <div class="w-2 h-2 bg-{{ $notification['color'] }}-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                        <div>
                                            <p class="text-sm text-gray-900">
                                                {{ $notification['message'] }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $notification['time'] }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="flex items-start">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                        <div>
                                            <p class="text-sm text-gray-900">
                                                Candidature acceptée pour <span class="font-medium">Développeur Web</span>
                                            </p>
                                            <p class="text-xs text-gray-500">Il y a 2 heures</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                        <div>
                                            <p class="text-sm text-gray-900">
                                                Nouvelle offre correspondant à votre profil
                                            </p>
                                            <p class="text-xs text-gray-500">Il y a 4 heures</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                        <div>
                                            <p class="text-sm text-gray-900">
                                                Votre profil a été consulté 5 fois
                                            </p>
                                            <p class="text-xs text-gray-500">Hier</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Overview -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Aperçu de mes performances</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="relative inline-flex items-center justify-center w-20 h-20 mb-4">
                                <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 36 36">
                                    <path class="text-gray-200" stroke="currentColor" stroke-width="2" fill="none" d="m18,2.0845 a 15.9155,15.9155 0 0,1 0,31.831 a 15.9155,15.9155 0 0,1 0,-31.831"/>
                                    <path class="text-green-500" stroke="currentColor" stroke-width="2" fill="none" stroke-dasharray="{{ $acceptanceRate ?? 0 }}, 100" d="m18,2.0845 a 15.9155,15.9155 0 0,1 0,31.831 a 15.9155,15.9155 0 0,1 0,-31.831"/>
                                </svg>
                                <span class="absolute text-xl font-bold text-gray-900">{{ $acceptanceRate ?? 0 }}%</span>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900">Taux d'acceptation</h4>
                            <p class="text-xs text-gray-500">Candidatures acceptées</p>
                        </div>

                        <div class="text-center">
                            <div class="relative inline-flex items-center justify-center w-20 h-20 mb-4">
                                <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 36 36">
                                    <path class="text-gray-200" stroke="currentColor" stroke-width="2" fill="none" d="m18,2.0845 a 15.9155,15.9155 0 0,1 0,31.831 a 15.9155,15.9155 0 0,1 0,-31.831"/>
                                    <path class="text-blue-500" stroke="currentColor" stroke-width="2" fill="none" stroke-dasharray="{{ $responseRate ?? 70 }}, 100" d="m18,2.0845 a 15.9155,15.9155 0 0,1 0,31.831 a 15.9155,15.9155 0 0,1 0,-31.831"/>
                                </svg>
                                <span class="absolute text-xl font-bold text-gray-900">{{ $responseRate ?? 70 }}%</span>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900">Taux de réponse</h4>
                            <p class="text-xs text-gray-500">Entreprises qui répondent</p>
                        </div>

                        <div class="text-center">
                            <div class="relative inline-flex items-center justify-center w-20 h-20 mb-4">
                                <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 36 36">
                                    <path class="text-gray-200" stroke="currentColor" stroke-width="2" fill="none" d="m18,2.0845 a 15.9155,15.9155 0 0,1 0,31.831 a 15.9155,15.9155 0 0,1 0,-31.831"/>
                                    <path class="text-orange-500" stroke="currentColor" stroke-width="2" fill="none" stroke-dasharray="{{ $profileCompleteness ?? 85 }}, 100" d="m18,2.0845 a 15.9155,15.9155 0 0,1 0,31.831 a 15.9155,15.9155 0 0,1 0,-31.831"/>
                                </svg>
                                <span class="absolute text-xl font-bold text-gray-900">{{ $profileCompleteness ?? 85 }}%</span>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900">Profil complété</h4>
                            <p class="text-xs text-gray-500">Informations remplies</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
