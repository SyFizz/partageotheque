<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails d\'un matériel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Informations du matériel') }}
                    </h2>
                    <div class="mt-6 space-y-6">
                        <div>
                            <x-input-label for="item_name" :value="__('Référence')" />
                            <x-text-input disabled readonly id="item_name" name="item_name" type="text" class="mt-1 block w-full bg-gray-100" value="{{$item->item_name}}" />
                        </div>

                        <div>
                            <x-input-label for="type" :value="__('Type')" />
                            <x-text-input readonly disabled id="type" name="type" type="text" class="mt-1 block w-full bg-gray-100" value="{{$item->type}}"/>
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-textarea-input readonly disabled id="description" name="description" class="mt-1 block w-full bg-gray-100" rows="4"></x-textarea-input>
                            <script>
                                let description = "{!! str_replace("\n", "\\n",$item->description) !!}" // Replace all \n by <br>
                                document.getElementById("description").value = description;
                                document.getElementById("description").rows=description.split("\n").length;
                            </script>
                        </div>



                        <div class="flex items-center gap-4">
                            <x-primary-button onclick="window.location.href='{{route('items.edit', $item)}}'">{{ __('Modifier ces informations') }}</x-primary-button>
                            <x-primary-button onclick="window.location.href='{{ url()->previous() }}'">{{ __('Revenir à la page précédente') }}</x-primary-button>
                        </div>
                    </div>

                </div>
            </div>
            @if($item->is_borrowed == 1)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Informations sur l\'emprunt en cours') }}
                        </h2>
                        <div class="mt-6 space-y-6">
                            <div>
                                <x-input-label for="borrowed_by" :value="__('Emprunté par')" />
                                <x-text-input readonly disabled id="borrowed_by" name="borrowed_by" type="text" class="mt-1 block w-full bg-gray-100" value="{{$item->getBorrower()->name}}"/>
                            </div>
                            <div>
                                <x-input-label for="borrowed_at" :value="__('Date d\'emprunt')" />
                                <x-text-input readonly disabled id="borrowed_at" name="borrowed_at" type="text" class="mt-1 block w-full bg-gray-100" value="{{$item->lastBorrow()->borrow_date}}"/>
                            </div>
                        </div>

                    </div>
                </div>
            @endif
            @if($item->getBorrowHistory()->count() > 0)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Historique des emprunts') }}
                        </h2>
                        <div class="mt-6 space-y-6">
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Emprunteur
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Emprunté le
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Rendu le
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item->getBorrowHistory() as $borrow)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:text-blue-600 hover:cursor-grab">
                                            <th scope="row" class="px-6 py-4" onclick="window.location.href = '{{route('borrowers.show', $borrow->borrower)}}'">
                                                {{$borrow->borrower->name}}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{$borrow->borrow_date}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{$borrow->return_date}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

</x-app-layout>
