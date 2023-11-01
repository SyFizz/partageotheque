<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Édition d\'un utilisateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Informations de l\'utilisateur') }}
                    </h2>
                    <form method="post" action="{{ route('users.update', $user) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="userid" value="{{$user->id}}">

                        <div>
                            <x-input-label for="name" :value="__('Nom et prénom')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{old('name', $user->name)}}" autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Adresse e-mail')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{old('email', $user->email)}}" autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="role" :value="__('Rôle')" />
                            <x-select-input id="role" name="role" class="mt-1 block w-full" value="{{old('role')}}">
                                <option value="user">Utilisateur</option>
                                <option value="admin">Administrateur</option>
                            </x-select-input>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                        <script>
                            document.getElementById('role').value = "{{old('role', $user->role)}}";
                        </script>



                        <div>
                            <x-input-label for="password" :value="__('Mot de passe')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" placeholder="Laissez vide pour garder le mot de passe actuel" value="{{old('password')}}" autocomplete="password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirmation du mot de passe')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" placeholder="Laissez vide pour garder le mot de passe actuel" autocomplete="password_confirmation" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>



                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Sauvegarder') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
