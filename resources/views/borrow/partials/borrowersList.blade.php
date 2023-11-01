@if($borrowers->count() == 0)
    <div class="mt-1 block w-full">
        <p class="text-red-500">Aucun emprunteur n'a été trouvé.</p>
    </div>
@elseif($borrowers->count() == 1)
    <x-input-label for="borrower" :value="__('Emprunteur')" />
    <x-select-input  disabled id="borrower" name="borrower" class="mt-1 block w-full border-2 border-green-500 bg-green-100">
        @foreach($borrowers as $borrower)
            <option value="{{ $borrower->id }}">{{ $borrower->name }}</option>
        @endforeach
    </x-select-input>
@else
    <x-input-label for="borrower" :value="__('Emprunteur')" />
    <x-select-input id="borrower" name="borrower" class="mt-1 block w-full">
        @foreach($borrowers as $borrower)
            <option value="{{ $borrower->id }}">{{ $borrower->name }}</option>
        @endforeach
    </x-select-input>
@endif

<x-input-error :messages="$errors->get('borrower')" class="mt-2" />
@error('borrower')
<script>
    document.getElementById('borrower').classList.add('border-red-500');
</script>
@enderror
