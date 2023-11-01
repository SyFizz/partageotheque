<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Création d\'un matériel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Informations sur le matériel') }}
                    </h2>
                    <form method="post" action="{{ route('items.store') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('post')

                        <div>
                            <x-input-label for="item_name" :value="__('Référence du matériel')" />
                            <x-text-input id="item_name" name="item_name" type="text" class="mt-1 block w-full" value="{{old('item_name')}}" autocomplete="item_name" />
                            <x-input-error :messages="$errors->get('item_name')" class="mt-2" />
                            @error('item_name')
                            <script>
                                document.getElementById('item_name').classList.add('border-red-500');
                            </script>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="type" :value="__('Type')" />
                            <x-select-input id="type" name="type" class="mt-1 block w-full" value="{{old('type')}}">
                                <option value="Bureautique">Bureautique</option>
                                <option value="Bricolage">Bricolage</option>
                                <option value="Cuisine">Cuisine</option>
                                <option value="Musique/Fête">Musique/Fête</option>
                                <option value="Jardinage">Jardinage</option>
                                <option value="Jeux de société">Jeux de société</option>
                                <option value="Jeux vidéo/Rétrogaming">Jeux vidéo/Rétrogaming</option>
                                <option value="Loisirs">Loisirs</option>
                                <option value="Loisirs créatifs">Loisirs créatifs</option>
                                <option value="Puériculture">Puériculture</option>
                                <option value="Autre">Autre</option>
                            </x-select-input>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            <script>
                                document.getElementById('type').value = "{{old('type', 'Autre')}}";
                            </script>
                            @error('type')
                            <script>
                                document.getElementById('type').classList.add('border-red-500');
                            </script>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-textarea-input id="description" name="description" class="mt-1 block w-full" rows="4" value="{{old('description')}}"></x-textarea-input>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            <script>
                                let description = "{!! str_replace("\r\n", "\\n",old('description')) !!}" // Replace all \n by <br>
                                document.getElementById("description").value = description;
                            </script>
                            @error('description')
                            <script>
                                document.getElementById('description').classList.add('border-red-500');
                            </script>
                            @enderror
                        </div>

                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="is_borrowed" value="0">


                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Créer le matériel') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
