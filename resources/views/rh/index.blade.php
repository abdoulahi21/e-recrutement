<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <h2 class="text-2xl font-semibold mb-6">Mes Offres et Candidatures</h2>

        {{-- Filtres --}}
        <form method="GET" class="mb-6">
            <label for="status" class="mr-2 font-medium">Filtrer par statut :</label>
            <select name="status" id="status" onchange="this.form.submit()" class="rounded border-gray-300">
                <option value="">Tous</option>
                @foreach($statuses as $key => $label)
                    <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </form>

        @foreach($offers as $offer)
            <div class="bg-white shadow rounded-lg p-4 mb-6">
                <h3 class="text-lg font-bold">{{ $offer->title }}</h3>

                @forelse($offer->apply as $apply)
                    <div class="border-t pt-2 mt-2">
                        <p><strong>Candidat :</strong> {{ $apply->user->name }}</p>
                        <p><strong>Message :</strong> {{ $apply->message }}</p>
                        <p><strong>Statut :</strong> {{ $apply->status_label }}</p>
                        <a href="{{ route('rh.applications.show', $apply) }}" class="text-blue-600 underline text-sm">
                            Voir la candidature
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500 mt-2">Aucune candidature pour cette offre.</p>
                @endforelse
            </div>
        @endforeach

        <div class="mt-6">
            {{ $offers->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
