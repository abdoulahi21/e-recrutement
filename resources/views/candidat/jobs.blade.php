<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                @if(Auth::user() && Auth::user()->role_id == 2)
                    <h1 class="text-2xl font-bold mb-4">Mes Offres</h1>
                @else
                    <h1 class="text-3xl font-bold text-gray-900">Offres d'emploi</h1>
                    <p class="mt-2 text-gray-600">Découvrez les opportunités qui correspondent à votre profil</p>
                @endif
            </div>
            <div class="flex items-center space-x-2 text-sm ">
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2M8 6v10a2 2 0 002 2h4a2 2 0 002-2V6"></path>
                    </svg>
                    <span>{{ $offers->total() }} offre{{ $offers->total() > 1 ? 's' : '' }} disponible{{ $offers->total() > 1 ? 's' : '' }}</span>
                </div>
                @if(Auth::user() && Auth::user()->role_id == 2)
                    <div class="flex space-x-4">
                        <a href="{{ route('rh.offers.create') }}" class="btn-primary inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Nouvelle offre
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Formulaire de filtres -->
            <div class="card mb-8">
                <div class="card-body">
                    <form method="GET" action="{{ route('jobs') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        <!-- Recherche par titre -->
                        <div>
                            <label class="form-label">Rechercher</label>
                            <div class="relative">
{{--                                <input type="text"--}}
{{--                                       name="search"--}}
{{--                                       value="{{ request('search') }}"--}}
{{--                                       placeholder="Titre de l'offre..."--}}
{{--                                       class="form-input pl-10">--}}
                                <x-text-input id="text" class="form-input pl-10"
                                              type="search" value="{{ request('search') }}"
                                              name="search" placeholder="Titre de l'offre..." />
                                <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Filtre par type -->
                        <div>
                            <label class="form-label">Type de contrat</label>
                            <select name="type" class="form-input">
                                <option value="">Tous les types</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tri -->
                        <div>
                            <label class="form-label">Trier par</label>
                            <select name="sort_by" class="form-input">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date de création</option>
                                <option value="end_date" {{ request('sort_by') == 'end_date' ? 'selected' : '' }}>Date de fin</option>
                                <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Titre</option>
                            </select>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-end space-x-2">
                            <button type="submit" class="btn-primary inline-flex flex-1 items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Filtrer
                            </button>
                            <a href="{{ route('jobs') }}" class="btn-secondary">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        </div>

                        <!-- Checkbox pour offres actives -->
                        <div class="md:col-span-4 flex items-center">
                            <input type="checkbox"
                                   id="active_only"
                                   name="active_only"
                                   value="1"
                                   {{ request('active_only') ? 'checked' : '' }}
                                   class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <label for="active_only" class="ml-2 text-sm text-gray-700">
                                Afficher seulement les offres non expirées
                            </label>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Liste des offres -->
            @if($offers->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($offers as $offer)
                        <div class="card hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <div class="card-body">

                                <!-- badge si offre est deja postuler -->

                                @if($offer->apply && $offer->apply->contains('user_id', auth()->id()))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-500 text-white">
                                        Déjà postulé
                                    </span>
                                @endif

                                <!-- En-tête de la carte -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                            {{ $offer->title }}
                                        </h3>
                                        <div class="flex items-center text-sm text-gray-600 mb-2">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H7m2 0v-3m6 3v-3m2-2V9m-6-2V5"></path>
                                            </svg>
                                            {{ $offer->user->name ?? 'Employeur' }}
                                        </div>
                                    </div>

                                    <!-- Badge du type -->
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ strtolower($offer->type) === 'cdi' ? 'bg-green-200 text-green-800' :
                                           (strtolower($offer->type) === 'cdd' ? 'bg-orange-200 text-orange-800' :
                                           (strtolower($offer->type) === 'stage' ? 'bg-blue-200 text-blue-800' :
                                            'bg-purple-100 text-purple-800')) }}">
                                        {{ $offer->type }}
                                    </span>
                                </div>

                                <!-- Description -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ $offer->description }}
                                </p>

                                <!-- Informations sur les dates -->
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-4 ">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4l6 6m-6-6v6a2 2 0 002 2h4a2 2 0 002-2v-6"></path>
                                        </svg>
                                        Publié {{ $offer->created_at->diffForHumans() }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Expire le {{ \Carbon\Carbon::parse($offer->end_date)->format('d/m/Y') }}
                                    </div>
                                </div>

                                <!-- Boutons d'action -->
                                <div class="flex space-x-2">
                                    @if(Auth::user() && Auth::user()->role_id == 2)
                                        <a href="{{route("rh.offers.show", $offer)}}" class="btn-primary flex-1 text-sm py-2">
                                            Voir les details l'offre
                                        </a>
                                    @else
                                    <a href="{{route("jobs-detail", $offer)}}" class="btn-primary flex-1 text-sm py-2">
                                        Voir les details l'offre
                                    </a>
                                    @endif
                                    <button class="btn-secondary px-3 py-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Indicateur d'expiration -->
                                @php
                                    $daysUntilExpiration = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($offer->end_date), false);
                                @endphp

                                @if($daysUntilExpiration <= 7 && $daysUntilExpiration >= 0)
                                    <div class="mt-3 flex items-center justify-center">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Expire dans {{ $daysUntilExpiration }} jour{{ $daysUntilExpiration > 1 ? 's' : '' }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex items-center justify-between bg-white px-6 py-4 border border-gray-200 rounded-2xl shadow-sm">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if ($offers->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 cursor-default rounded-lg">
                                Précédent
                            </span>
                        @else
                            <a href="{{ $offers->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Précédent
                            </a>
                        @endif

                        @if ($offers->hasMorePages())
                            <a href="{{ $offers->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Suivant
                            </a>
                        @else
                            <span class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 cursor-default rounded-lg">
                                Suivant
                            </span>
                        @endif
                    </div>

                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Affichage de
                                <span class="font-medium">{{ $offers->firstItem() }}</span>
                                à
                                <span class="font-medium">{{ $offers->lastItem() }}</span>
                                sur
                                <span class="font-medium">{{ $offers->total() }}</span>
                                résultats
                            </p>
                        </div>
{{--                        <div>--}}
{{--                            {{ $offers->links('pagination::tailwind') }}--}}
{{--                        </div>--}}
                        <div>
                            @if ($offers->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 cursor-default rounded-lg">
                                Précédent
                            </span>
                            @else
                                <a href="{{ $offers->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                    Précédent
                                </a>
                            @endif

                            @if ($offers->hasMorePages())
                                <a href="{{ $offers->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                    Suivant
                                </a>
                            @else
                                <span class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 cursor-default rounded-lg">
                                Suivant
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

            @else
                <!-- État vide -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2M8 6v10a2 2 0 002 2h4a2 2 0 002-2V6"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Aucune offre trouvée</h3>
                    <p class="mt-2 text-gray-500">
                        Aucune offre d'emploi ne correspond à vos critères de recherche.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('jobs') }}" class="btn-primary">
                            Voir toutes les offres
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>
