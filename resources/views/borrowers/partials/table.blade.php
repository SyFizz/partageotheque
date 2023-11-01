<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
        <tbody id="tableBody">
        <script>
            function confirmDeletion() {
                return confirm('Êtes-vous sûr de vouloir supprimer cet emprunteur ?');
            }
        </script>
        @foreach($borrowers as $borrower)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 content-center">
                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$borrower->name}}
                </th>
                <td class="px-6 py-4">
                    {{$borrower->email}}
                </td>
                <td class="px-6 py-4">
                    {{$borrower->role}}
                </td>
                <td class="flex items-center justify-items-center align-center align-items-center justify-center gap-6 pt-3 ">
                    <a href="{{route('borrowers.show', $borrower->id)}}"
                       class="flex items-center align-center align-items-center justify-center bg-green-400 hover:bg-green-300 font-bold w-7 h-7 rounded">
                        @svg('carbon-view', 'h-4 w-4 inline text-black')
                    </a>
                    <a href="{{route('borrowers.edit', $borrower->id)}}"
                       class="flex items-center justify-center bg-blue-400 hover:bg-blue-300 font-bold w-7 h-7 rounded">
                        @svg('carbon-edit', 'h-4 w-4 inline text-black')
                    </a>
                    <form action="{{route('borrowers.destroy', $borrower->id)}}" method="POST" onsubmit="return confirmDeletion()">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="flex items-center justify-center bg-red-400 hover:bg-red-300 font-bold w-7 h-7 rounded">
                            @svg('carbon-trash-can', 'h-4 w-4 inline text-black')
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
