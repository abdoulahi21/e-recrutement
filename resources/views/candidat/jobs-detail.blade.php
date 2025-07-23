<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 justify-between">
            <div class="flex items-center space-x-4 gap-4">
                <a href="{{ route('jobs') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-green-600 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Détails de l'offre
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 text-xs font-medium rounded-full
                    {{ $offer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $offer->status === 'active' ? 'Actif' : 'Inactif' }}
                </span>
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-800">
                    {{ ucfirst($offer->type) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Contenu principal -->
                <div class="lg:col-span-2">
                    <div class="card">
                        <div class="card-header p-6">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $offer->title }}</h1>
                            <div class="flex items-center justify-between text-sm text-gray-600 space-x-4 ">
                                <span class="flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-user-icon lucide-circle-user"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/><path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"/></svg>
                                    {{ $offer->user->name }}
                                </span>
                                <span class="flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-receipt-text-icon lucide-receipt-text"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/><path d="M14 8H8"/><path d="M16 12H8"/><path d="M13 16H8"/></svg>
                                    {{ ucfirst($offer->type) }}
                                </span>
                                <span class="flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-receipt-text-icon lucide-receipt-text"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/><path d="M14 8H8"/><path d="M16 12H8"/><path d="M13 16H8"/></svg>
                                    Expire le {{ \Carbon\Carbon::parse($offer->end_date)->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Description du poste</h3>
                                    <div class="prose text-gray-700 leading-relaxed">
                                        {{ $offer->description }}
                                    </div>
                                </div>

                                <!-- Informations supplémentaires -->
                                <div class="border-t pt-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations sur l'offre</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                            <span class="text-sm font-medium text-gray-600">Type de contrat</span>
                                            <span class="text-sm text-gray-900 font-semibold">{{ ucfirst($offer->type) }}</span>
                                        </div>
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                            <span class="text-sm font-medium text-gray-600">Date limite</span>
                                            <span class="text-sm text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($offer->end_date)->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                            <span class="text-sm font-medium text-gray-600">Publié par</span>
                                            <span class="text-sm text-gray-900 font-semibold">{{ $offer->user->compagny_name }}</span>
                                        </div>
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                            <span class="text-sm font-medium text-gray-600">Statut</span>
                                            <span class="text-sm font-semibold {{ $offer->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $offer->status === 'active' ? 'Actif' : 'Inactif' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Candidater à cette offre</h3>

                            @if($offer->status !== 'active')
                                <div class="text-center py-4">
                                    <div class="text-red-600 mb-2">
                                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-red-600 font-medium">Cette offre n'est plus disponible</p>
                                </div>
                            @elseif(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($offer->end_date)))
                                <div class="text-center py-4">
                                    <div class="text-red-600 mb-2">
                                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-red-600 font-medium">Cette offre a expiré</p>
                                </div>
                            @else
                                @auth
                                    @php
                                        $hasApplied = $offer->apply()->where('user_id', auth()->id())->exists();
                                    @endphp

                                    @if($hasApplied)
                                        <div class="text-center py-4">
                                            <div class="text-green-600 mb-2">
                                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-green-600 font-medium">Vous avez déjà postulé à cette offre</p>
                                        </div>
                                    @else
                                        <button
                                            x-data=""
                                            @click="$dispatch('open-modal', 'apply-modal')"
                                            class="w-full btn-primary flex items-center justify-center"
                                        >
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Postuler
                                        </button>
                                    @endif
                                @else
                                    <div class="space-y-4">
                                        <p class="text-sm text-gray-600 text-center">Vous devez être connecté pour postuler</p>
                                        <a href="{{ route('login') }}" class="w-full btn-primary flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                            </svg>
                                            Se connecter
                                        </a>
                                        <div class="text-center">
                                            <span class="text-sm text-gray-500">ou</span>
                                        </div>
                                        <a href="{{ route('register') }}" class="w-full btn-secondary flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                            </svg>
                                            Créer un compte
                                        </a>
                                    </div>
                                @endauth
                            @endif

                            <!-- Statistiques -->
                            <div class="mt-6 pt-6 border-t">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Statistiques</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Candidatures</span>
                                        <span class="font-medium text-gray-900">{{ $offer->apply()->count() }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Publié le</span>
                                        <span class="font-medium text-gray-900">{{ $offer->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>

                                <!-- Bouton pour voir les candidatures (propriétaire seulement) -->
                                @auth
                                    @if(auth()->id() === $offer->user_id && $offer->apply()->count() > 0)
                                        <div class="mt-4">
                                            <a href="#"
{{--                                                href="{{ route('offers.applications', $offer) }}"--}}
                                               class="w-full btn-secondary flex items-center justify-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Voir les candidatures
                                            </a>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
{{--                    A propos de l'entreprise--}}
                    <div class="card mt-6">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold text-gray-900">À propos de l'entreprise
                                <b class="text-green-600">
                                {{ $offer->user->compagny_name }}
                                </b>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="space-y-4">
                                <p class="text-gray-700">{{ $offer->user->compagny_description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de candidature -->
    @auth
        <x-modal name="apply-modal" maxWidth="md" focusable>
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        @if($offer->user->compagny_logo)
                            <img src="{{ asset('storage/' . $offer->user->compagny_logo) }}" alt="logo" class="w-10 h-10 rounded-full">
                        @else
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-orange-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Postuler à cette offre</h3>
                        <p class="text-sm text-gray-600">{{ $offer->title }}</p>
                    </div>
                </div>

                <form
                    action="{{ route('offers.apply', $offer) }}"
                    method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label for="message" class="form-label">Lettre de motivation</label>
                        <textarea
                            id="message"
                            name="message"
                            rows="4"
                            class="form-input border-gray-300 {{ $errors->has('message') ? 'border-red-500' : '' }}"
                            placeholder="Expliquez pourquoi vous êtes le candidat idéal pour ce poste..."
                            required
                        >
{{old('message',"Bonjour,

Je vous adresse ma candidature pour le poste de $offer->title qui m'intéresse tout particulièrement.

Vous trouverez ci-joint mon CV.

J'aimerai avoir l'opportunité de discuter avec vous en détail de ma candidature.

Je vous remercie pour votre considération.
Bien cordialement,") }}
                        </textarea>
                        @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="{ fileName: '', clearFile() { this.fileName = ''; $refs.fileInput.value = null; } }">
                        <label for="cv" class="form-label">CV (PDF uniquement)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2
                         border-gray-300 border-dashed rounded-lg hover:border-green-400
                          transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="cv" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                        <span>Télécharger un fichier</span>
                                        <input
                                            id="cv"
                                            name="cv"
                                            type="file"
                                            accept=".pdf"
                                            class="sr-only"
                                            @change="fileName = $event.target.files[0]?.name"
                                            required
                                        >
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <template x-if="fileName">
                                    <div class="mt-2 flex items-center justify-center gap-2 text-green-600">
                                        <span class="text-sm font-medium">Fichier sélectionné : <span x-text="fileName"></span></span>
                                        <button type="button" @click="clearFile" class="text-red-600 hover:text-red-800" title="Supprimer le fichier">
                                            <!-- Icône poubelle -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                                <p class="text-xs text-gray-500">PDF jusqu'à 10MB</p>
                            </div>
                        </div>
                        @error('cv')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                        <button
                            type="submit"
                            class="btn-primary"
                        >
                            Envoyer ma candidature
                        </button>
                    </div>
                </form>
            </div>
        </x-modal>
    @endauth
</x-app-layout>
