<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des matériels') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mb-1.5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 pt-6 pb-4 text-gray-900 font-bold text-2xl">
                    {{ __("Accès rapide :") }}
                </div>
                <div class="px-6 pb-6 flex flex-wrap text-m">
                    <a href="{{route('items.create')}}" class="m-2 bg-green-400 hover:bg-green-300 font-bold py-2 px-4 rounded">
                        {{ __('Créer un nouveau matériel') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="mb-1.5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 pt-6 pb-4 text-gray-900 font-bold text-2xl">
                    {{ __("Liste des matériels :") }}
                </div>
                <div class="px-6 pt-6 pb-4 text-gray-900">

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Référence
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Est emprunté ?
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Emprunté par
                                </th>
                                <th scope="col" class="text-center px-6 py-3">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr class="hover:text-blue-500 bg-white text-gray-900 border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th onclick="window.location.href = '{{route('items.show', $item)}}';" scope="row" class="px-6 py-4 font-medium whitespace-nowrap dark:text-white">
                                        {{$item->item_name}}
                                    </th>
                                    <td onclick="window.location.href = '{{route('items.show', $item)}}';" class="px-6 py-4">
                                        {{$item->type}}
                                    </td>
                                    <td onclick="window.location.href = '{{route('items.show', $item)}}';" class="px-6 py-4">
                                        {{$item->is_borrowed ? "Oui" : "Non"}}
                                    </td>
                                    <td onclick="window.location.href = '{{route('items.show', $item)}}';" class="px-6 py-4">
                                        {{$item->is_borrowed ? $item->getBorrower()->name : ""}}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{route('items.show', $item->id)}}" class="m-2 inline bg-green-400 hover:bg-green-300 font-bold py-1.5 px-1.5 w-5 h-5 rounded">
                                            @svg('carbon-view', 'h-4 w-4 inline text-black')
                                        </a>
                                        <a href="{{route('items.edit', $item->id)}}" class="m-2 bg-blue-400 hover:bg-blue-300 font-bold py-1.5 px-1.5 w-5 h-5 rounded">
                                            @svg('carbon-edit', 'h-4 w-4 inline text-black')
                                        </a>
                                        <a onclick="deleteItem({{$item->id}}, '{{$item->item_name}}')" class="m-2 bg-red-400 hover:bg-red-300 font-bold py-1.5 px-1.5 w-5 h-5 rounded">
                                            @svg('carbon-trash-can', 'h-4 w-4 inline text-black')
                                        </a>
                                        <form id="delete-item-form-{{$item->id}}" action="{{route('items.destroy', $item->id)}}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <script>
                                            function deleteItem(id, item_name) {
                                                if (confirm("Voulez-vous vraiment supprimer le matériel " + item_name + " ?")) {
                                                    document.getElementById('delete-item-form-' + id).submit();
                                                }
                                            }
                                        </script>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="px-6 py-4">
                            {{$items->links()}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
