<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Retour d\'un matériel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Entrez maintenant la référence du matériel') }}
                    </h2>
                    <form method="post" action="{{ route('return.store') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('post')

                        <div>
                            <x-input-label for="item_name" :value="__('Identifiant du matériel')" />
                            <x-text-input autofocus id="item_name" name="item_name" type="text" class="mt-1 block w-2 h-2" value="{{old('item_name')}}" autocomplete="item_name" />
                            <x-input-error :messages="$errors->get('item_name')" class="mt-2" />
                            @error('item_name')
                            <script>
                                document.getElementById('item_name').classList.add('border-red-500');
                            </script>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Étape suivante') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
