<x-guest-layout>
    <div class="mb-2 text-xl text-gray-600 font-bold">
        {{ __('Compte non valide !')}}
    </div>
    <div class="mb-4 text-m text-gray-600">
        {{ __('Afin d\'activer votre compte, vous devez cliquer sur le lien que nous vous avons envoyé par e-mail.') }} <br>
        {{ __('Si vous ne l\'avez pas reçu, cliquez sur le bouton ci-dessous pour renvoyer un lien.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Un nouveau lien de vérification a été envoyé sur votre adresse e-mail utilisée lors de la création de votre compte.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Renvoyer l\'e-mail de vérification') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Déconnexion') }}
            </button>
        </form>
    </div>
</x-guest-layout>
