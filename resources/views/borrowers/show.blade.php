<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Affichage d\'un emprunteur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Informations de l\'emprunteur') }}
                    </h2>
                    <div class="mt-6 space-y-6">
                    <div>
                        <x-input-label for="name" :value="__('Nom et prénom')" />
                        <x-text-input disabled readonly id="name" name="name" type="text" class="mt-1 block w-full bg-gray-100" value="{{$borrower->name}}" autocomplete="name" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Adresse e-mail')" />
                        <x-text-input readonly disabled id="email" name="email" type="email" class="mt-1 block w-full bg-gray-100" value="{{$borrower->email}}" autocomplete="email" />
                    </div>

                    <div>
                        <x-input-label for="role" :value="__('Rôle')" />
                        <x-select-input readonly disabled id="role" name="role" class="mt-1 block w-full bg-gray-100">
                            <option value="Adhérent">Adhérent</option>
                            <option value="Bénévole">Bénévole</option>
                            <option value="Autre">Autre</option>
                        </x-select-input>

                        <script>
                            document.getElementById('role').value = '{{$borrower->role}}';
                        </script>
                    </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button onclick="window.location.href='{{route('borrowers.edit', $borrower)}}'">{{ __('Modifier l\'emprunteur') }}</x-primary-button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Prêts en cours') }}
                    </h2>
                    <div class="mt-6 space-y-6">
                        @if($borrower->nonReturnedBorrows()->count() == 0)
                            <p class="text-gray-500">Aucun prêt n'est en cours pour cet emprunteur.</p>
                        @else
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Référence du matériel
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Emprunté le
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($borrower->nonReturnedBorrows() as $borrow)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 hover:text-blue-600 whitespace-nowrap dark:text-white"
                                                onclick="window.location.href='{{route('items.show', $borrow->item_id)}}'">
                                                {{\App\Models\Item::find($borrow->item_id)->item_name}}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{Carbon\Carbon::parse($borrow->borrow_date)->format('d/m/Y')}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Historique des prêts') }}
                    </h2>
                    <div class="mt-6 space-y-6">
                        @if($borrower->returnedBorrows()->count() == 0)
                            <p class="text-gray-500">Aucun prêt n'a été effectué par cet emprunteur.</p>
                        @else
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Matériel
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
                                    @foreach($borrower->returnedBorrows() as $borrow)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:text-blue-600"
                                            onclick="window.location.href = '{{route('items.show', $borrow->item)}}'">
                                            <th scope="row" class="px-6 py-4 font-bold whitespace-nowrap">
                                                {{$borrow->item->item_name}}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{Carbon\Carbon::parse($borrow->borrow_date)->format('d/m/Y')}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{Carbon\Carbon::parse($borrow->return_date)->format('d/m/Y')}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
