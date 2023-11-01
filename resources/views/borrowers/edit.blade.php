<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Édition d\'un emprunteur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Informations de l\'emprunteur') }}
                    </h2>
                    <form method="post" action="{{ route('borrowers.update', $borrower) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="borrowerid" value="{{$borrower->id}}">

                        <div>
                            <x-input-label for="name" :value="__('Nom et prénom')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{old('name', $borrower->name)}}" autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Adresse e-mail')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{old('email', $borrower->email)}}" autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="role" :value="__('Rôle')" />
                            <x-select-input id="role" name="role" class="mt-1 block w-full" value="{{old('role')}}">
                                <option value="Adhérent">Adhérent</option>
                                <option value="Bénévole">Bénévole</option>
                                <option value="Autre">Autre</option>
                            </x-select-input>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                        <script>
                            document.getElementById('role').value = "{{old('role', $borrower->role)}}";
                        </script>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Sauvegarder') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
