<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvel emprunt') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Sélectionnez l\'emprunteur du matériel') }}
                    </h2>
                    <div class="mt-6">
                        <x-text-input autofocus id="search" name="search" type="text" class="mt-1 w-full block" value="{{old('search')}}" placeholder="Tapez ici pour rechercher..." />
                    </div>
                    <form method="post" action="{{ route('borrow.store', $item_name) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('post')

                        <div id="borrowersContent">
                            @include ('borrow.partials.borrowersList', ['borrowers' => $borrowers])
                        </div>

                        <input type="hidden" name="item_name" value="{{ $item_name }}">
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Valider l\'emprunt') }}</x-primary-button>
                            <x-danger-button href="{{ route('dashboard') }}">{{ __('Annuler') }}</x-danger-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){

            const fetch_data = (search_term) => {

                if(search_term === undefined){
                    search_term = "";
                }
                $.ajax({
                    url:"{{route('borrow.choose-borrower', $item_name)}}?search="+search_term,
                    success:function(data){
                        $('#borrowersContent').html('');
                        $('#borrowersContent').html(data);
                    }
                })
            }
            $('body').on('keyup', '#search', function(){
                var search_term = $('#search').val();
                fetch_data(search_term);
            });

        });
    </script>
</x-app-layout>
