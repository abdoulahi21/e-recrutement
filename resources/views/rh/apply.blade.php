<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Candidatures reçues') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Liste des candidatures</h3>

                    @if($applications->isEmpty())
                        <p class="text-gray-600">Aucune candidature trouvée.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto border border-gray-200 text-sm text-left">
                                <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-3 border-b">Candidat</th>
                                    <th class="px-4 py-3 border-b">Offre</th>
                                    <th class="px-4 py-3 border-b">Date</th>
                                    <th class="px-4 py-3 border-b">Statut</th>
                                    <th class="px-4 py-3 border-b text-right">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($applications as $apply)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 border-b">
                                            {{ $apply->user->name }}
                                        </td>
                                        <td class="px-4 py-3 border-b">
                                            {{ $apply->offer->title }}
                                        </td>
                                        <td class="px-4 py-3 border-b">
                                            {{ $apply->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-4 py-3 border-b">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $apply->status_color }}-100 text-{{ $apply->status_color }}-800">
                                                    {{ $apply->status_label }}
                                                </span>
                                        </td>
                                        <td class="px-4 py-3 border-b text-right">
                                            <a href="{{ route('rh.applications.show', $apply->id) }}" class="text-green-600 hover:underline text-sm">
                                                Voir
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
