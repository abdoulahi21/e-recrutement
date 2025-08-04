<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier l\'offre') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <form action="{{ route('rh.offers.update', $offer) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Titre -->
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Titre de l\'offre')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $offer->title)" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea name="description" id="description" rows="6" class="block mt-1 w-full rounded border-gray-300">{{ old('description', $offer->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Date de fin -->
                    <div class="mb-4">
                        <x-input-label for="end_date" :value="__('Date de fin')" />
{{--                        <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date"--}}
{{--                                      :value="old('end_date', $offer->end_date->format('Y-m-d'))"--}}
{{--                                      required />--}}
                        <x-text-input
                            id="end_date"
                            class="block mt-1 w-full"
                            type="date"
                            name="end_date"
                            :value="old('end_date', \Carbon\Carbon::parse($offer->end_date)->format('Y-m-d'))"
                            required
                        />
                        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                    </div>

                    <!-- Type -->
                    <div class="mb-4">
                        <x-input-label for="type" :value="__('Type d\'offre')" />
                        <select name="type" id="type" class="block mt-1 w-full rounded border-gray-300">
                            <option value="stage" @selected(old('type', $offer->type) === 'stage')>Stage</option>
                            <option value="emploi" @selected(old('type', $offer->type) === 'emploi')>Emploi</option>
                            <option value="freelance" @selected(old('type', $offer->type) === 'freelance')>Freelance</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <!-- Statut -->
                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Statut')" />
                        <select name="status" id="status" class="block mt-1 w-full rounded border-gray-300">
                            <option value="active" @selected($offer->status === 'active')>Active</option>
                            <option value="inactive" @selected($offer->status === 'inactive')>Inactive</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <x-primary-button>{{ __('Mettre à jour l\'offre') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
