<x-guest-layout>
    <div class="mb-2 text-xl text-gray-600 font-bold">
        {{ __('Vous avez oublié votre mot de passe ?')}}
    </div>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Aucun problème, renseignez simplement votre adresse e-mail afin de réinitialiser votre mot de passe.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse e-mail')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Envoyer le lien de réinitialisation') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
