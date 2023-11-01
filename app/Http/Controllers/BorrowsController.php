<?php

namespace App\Http\Controllers;



use App\Mail\BorrowReminder;
use App\Models\Borrow;
use App\Models\Borrower;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;

class BorrowsController extends Controller
{
    public function scanItem()
    {
        return view('borrow.scanItem');
    }

    public function goToStepTwo(Request $request)
    {
        if(Item::where('item_name', $request->item_name)->first() == null){
            return redirect()->back()->with('error', 'Le matériel scanné n\'existe pas.');
        }
        if(Item::where('item_name', $request->item_name)->first()->is_borrowed){
            return redirect()->back()->with('error', 'Le matériel scanné est déjà emprunté.');
        }
        return redirect()->route('borrow.choose-borrower', ['item_name' => $request->item_name]);
    }

    public function chooseBorrower($item_name, Request $request)
    {

        if($request->ajax()){
            if($request->search == null){
                $borrowers = Borrower::all();
            } else {
                $borrowers = Borrower::where('name', 'like', '%'.$request->search.'%')->get();
            }
            return view('borrow.partials.borrowersList', compact('borrowers'))->render();
        } else {
            return view('borrow.chooseBorrower')
                ->with('item_name', $item_name)
                ->with('borrowers', Borrower::all());
        }


    }

    public function store(Request $request){
        if($request->borrower == null){
            return redirect()->back()->with('error', 'Veuillez choisir un emprunteur');
        }
        if(Borrower::find($request->borrower) == null){
            return redirect()->back()->with('error', 'L\'emprunteur n\'existe pas');
        }
        $borrower = Borrower::find($request->borrower);
        $item = Item::where('item_name', $request->item_name)->first();
        $item->is_borrowed = true;
        $borrow = new Borrow();
        $borrow->borrower_id = $borrower->id;
        $borrow->item_id = $item->id;
        $borrow->borrow_date = Carbon::now();
        $borrow->is_returned = false;
        $borrow->return_date = null;
        $borrow->save();
        $item->save();
        return redirect()->route('dashboard')->with('success', 'Emprunt enregistré');
    }


}
