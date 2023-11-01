<x-mail::message>
# Rappel de prêt

Cet rappel est automatique, merci de ne pas y répondre.

Vous avez emprunté le matériel ayant pour référence **{{ $borrow->item->item_name }}** le **{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d/m/Y') }}**.
Si vous avez oublié de le ramener, merci de le faire __dès que possible__.

Dans le cas ou vous en auriez besoin plus longtemps, merci de nous le signaler.

Voici la liste de vos emprunts en cours :
@foreach($borrow->borrower->nonReturnedBorrows() as $nonReturnedBorrow)
- **{{ $nonReturnedBorrow->item->item_name }}** emprunté depuis le **{{ \Carbon\Carbon::parse($nonReturnedBorrow->borrow_date)->format('d/m/Y') }}**
@endforeach

Cordialement,
le service informatique.
</x-mail::message>
