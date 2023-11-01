<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des utilisateurs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mb-1.5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 pt-6 pb-4 text-gray-900 font-bold text-2xl">
                    {{ __("Accès rapide :") }}
                </div>
                <div class="px-6 pb-6 flex flex-wrap text-m">
                    <a href="{{route('users.create')}}" class="m-2 bg-blue-400 text-white hover:bg-blue-300 font-bold py-2 px-4 rounded">
                        {{ __('Créer un nouvel utilisateur') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="mb-1.5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 pt-6 pb-4 text-gray-900 font-bold text-2xl">
                    {{ __("Liste des utilisateurs :") }}
                </div>
                <div class="px-6 pt-6 pb-4 text-gray-900">

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Nom/Prénom
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Adresse e-mail
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Rôle
                                </th>
                                <th scope="col" class="text-center px-6 py-3">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$user->name}}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{$user->email}}
                                    </td>
                                    <td class="px-6 py-4">
                                        <script>
                                            if({{$user->role == "admin" ? "true" : "false"}}){
                                                document.write('<span class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">Administrateur</span>')
                                            }else{
                                                document.write('<span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Utilisateur</span>')
                                            }
                                        </script>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{route('users.show', $user->id)}}" class="m-2 inline bg-green-400 hover:bg-green-300 font-bold py-1.5 px-1.5 w-5 h-5 rounded">
                                            @svg('carbon-view', 'h-4 w-4 inline text-black')
                                        </a>
                                        <a href="{{route('users.edit', $user->id)}}" class="m-2 bg-blue-400 hover:bg-blue-300 font-bold py-1.5 px-1.5 w-5 h-5 rounded">
                                            @svg('carbon-edit', 'h-4 w-4 inline text-black')
                                        </a>
                                        @if(Auth::user()->id !== $user->id)
                                            <a onclick="deleteUser({{$user->id}}, '{{$user->email}}')" class="m-2 bg-red-400 hover:bg-red-300 font-bold py-1.5 px-1.5 w-5 h-5 rounded">
                                                @svg('carbon-trash-can', 'h-4 w-4 inline text-black')
                                            </a>
                                        @endif
                                        <form id="delete-user-form-{{$user->id}}" action="{{route('users.destroy', $user->id)}}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <script>
                                            function deleteUser(id, email) {
                                                if (confirm("Voulez-vous vraiment supprimer l'utilisateur " + email + " ?")) {
                                                    document.getElementById('delete-user-form-' + id).submit();
                                                }
                                            }
                                        </script>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="px-6 py-4">
                            {{$users->links()}}
                        </div>
                    </div>

                </div>
            </div>
    </div>
    </div>

</x-app-layout>
