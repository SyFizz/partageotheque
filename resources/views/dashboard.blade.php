<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mb-1.5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 pt-6 pb-4 text-gray-900 font-bold text-2xl">
                    {{ __("Accès rapide :") }}
                </div>
                <div class="px-6 pb-6 flex flex-wrap text-m">
                    <a href="{{route('borrow.scanItem')}}" class="m-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Déclarer un emprunt') }}
                    </a>
                    <a href="{{route('borrowers.create')}}" class="m-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Créer un emprunteur') }}
                    </a>
                    <a href="{{route('return.scanItem')}}" class="m-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Déclarer un retour') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-1.5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 pt-6 pb-4 text-gray-900 font-bold text-2xl">
                    {{ __("Statistiques :") }}
                </div>
                <div class="px-6 pb-6 text-m">
                    <div class="rounded-full px-3 m-2 font-bold">
                        {{ __('Nombre d\'emprunts en cours :') }}
                        <span class="px-2 py-1 font-normal">{{ \App\Models\Borrow::where('is_returned', 0)->count() > 0 ? \App\Models\Borrow::where('is_returned', 0)->count() : "Aucun prêt en cours" }}</span>
                    </div>
                    <div class="rounded-full px-3 m-2 font-bold">
                        {{ __('Nombre d\'emprunteurs :') }}
                        <span class="px-2 py-1 font-normal">{{$borrowers->count()}}</span>
                    </div>
                    <div class="rounded-full px-3 m-2 font-bold">
                        {{ __('Dernier matériel emprunté :') }}
                        <span class="px-2 py-1 font-normal">{{
                        !is_null($lastBorrow) ? $lastBorrow->item->item_name . " par " .  \App\Models\Borrower::find($lastBorrow->borrower_id)->name : "Aucun emprunt enregistré"
                        }}</span>

                    </div>
                </div>
            </div>
        </div>
        <div class="mt-1.5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 pt-6 pb-4 text-gray-900 font-bold text-2xl">
                    {{ __("Liste des prêts en cours :") }}
                </div>
                <div class="px-6 pb-6 text-m">
                    @if($borrows->where('is_returned', 0)->count() > 0)
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Matériel
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Emprunteur
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Emprunté le
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Envoyer un rappel
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($borrows->where('is_returned', 0) as $borrow)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 hover:text-blue-600 whitespace-nowrap dark:text-white"
                                        >
                                            {{$borrow->item->item_name}}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{$borrow->borrower->name}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{Carbon\Carbon::parse($borrow->borrow_date)->format('d/m/Y')}}
                                        </td>
                                        <td class="px-6 py-4">
                                            <form action="{{route('sendReminder')}}" method="POST">
                                                @csrf
                                                <input hidden name="borrow_id" value="{{$borrow->id}}"/>
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                    {{ __('Envoyer un rappel') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        {{ __('Aucun prêt en cours') }}
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
