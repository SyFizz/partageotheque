<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des emprunteurs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mb-1.5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 pt-6 pb-4 text-gray-900 font-bold text-2xl">
                    {{ __("Accès rapide :") }}
                </div>
                <div class="px-6 pb-6 flex flex-wrap text-m">
                    <a href="{{route('borrowers.create')}}"
                       class="m-2 bg-green-400 hover:bg-green-300 font-bold py-2 px-4 rounded">
                        {{ __('Créer un nouvel emprunteur') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="mb-1.5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 pt-6 pb-2 text-gray-900 font-bold text-2xl">
                    {{ __("Liste des emprunteurs :") }}
                </div>
                {{-- Search bar for the table --}}
                    <div class="px-6 pt-2 pb-6 text-gray-900 mb-4 w-full">
                        <div class="relative flex">
                            <div class="absolute top-0 left-0 inline-flex items-center w-full">
                                <x-text-input id="search" name="search-term" type="text" class="w-full mt-1 block" placeholder="Tapez-ici pour rechercher..." />
                            </div>
                        </div>
                    </div>

                <div id="borrowersContent" class="px-6 pt-6 pb-4 text-gray-900">
                    @include('borrowers.partials.table')
                </div>
                <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){

            const fetch_data = (page, search_term) => {

                if(search_term === undefined){
                    search_term = "";
                }
                $.ajax({
                    url:"{{route('borrowers.index')}}?page="+page+"&search_term="+search_term,
                    success:function(data){
                        $('#borrowersContent').html('');
                        $('#borrowersContent').html(data);
                    }
                })
            }
            $('body').on('keyup', '#search', function(){
                var search_term = $('#search').val();
                var page = $('#hidden_page').val();
                fetch_data(page, search_term);
            });

            $('body').on('click', '.pager a', function(event){
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                $('#hidden_page').val(page);
                var search_term = $('#search').val();
                fetch_data(page, search_term);
            });

        });
    </script>
</x-app-layout>
