<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Affichage d\'un utilisateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Informations de l\'utilisateur') }}
                    </h2>
                    <div class="mt-6 space-y-6">
                    <div>
                        <x-input-label for="name" :value="__('Nom et prénom')" />
                        <x-text-input disabled readonly id="name" name="name" type="text" class="mt-1 block w-full bg-gray-100" value="{{$user->name}}" autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Adresse e-mail')" />
                        <x-text-input readonly disabled id="email" name="email" type="email" class="mt-1 block w-full bg-gray-100" value="{{$user->email}}" autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="role" :value="__('Rôle')" />
                        <x-select-input readonly disabled id="role" name="role" class="mt-1 block w-full bg-gray-100">
                            <option value="user">Utilisateur</option>
                            <option value="admin">Administrateur</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />

                        <script>
                            document.getElementById('role').value = '{{$user->role}}';
                        </script>
                    </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button onclick="window.location.href='{{route('users.edit', $user)}}'">{{ __('Modifier l\'utilisateur') }}</x-primary-button>
                            <x-primary-button onclick="window.location.href='{{ url()->previous() }}'">{{ __('Revenir à la page précédente') }}</x-primary-button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
