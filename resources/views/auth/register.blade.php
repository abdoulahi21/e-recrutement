<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Prenom -->
        <div>
            <x-input-label for="first_name" :value="__('Prenom')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text"
                          name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>
        <!-- Nom -->
        <div>
            <x-input-label for="last_name" :value="__('Nom')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text"
                          name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Numero Telephone -->
        <div>
            <x-input-label for="number_phone" :value="__('Numero Telephone')" />
            <x-text-input id="number_phone" class="block mt-1 w-full" type="text"
                          name="number_phone" :value="old('number_phone')" required autofocus autocomplete="number_phone" />
            <x-input-error :messages="$errors->get('number_phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
