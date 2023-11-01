<?php

namespace App\Http\Controllers;



use App\Models\Borrow;
use App\Models\Borrower;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReturnController extends Controller
{
    public function scanItem()
    {
        return view('return.scanItem');
    }

    public function store(Request $request){
        if($request->item_name == null){
            return redirect()->back()->with('error', 'Veuillez scanner un matériel afin de le déclarer comme retourné.');
        }
        if(Item::where('item_name', $request->item_name)->first() == null){
            return redirect()->back()->with('error', 'Le matériel scanné n\'existe pas.');
        }
        $item = Item::where('item_name', $request->item_name)->first();
        if($item->is_borrowed == false){
            return redirect()->back()->with('error', 'Le matériel scanné n\'est pas emprunté.');
        }
        $borrow = Borrow::where('item_id', $item->id)->where('is_returned', false)->first();
        $borrow->is_returned = true;
        $borrow->return_date = Carbon::now();
        $borrow->save();
        $item->is_borrowed = false;
        $item->save();
        return to_route('dashboard')->with('success', 'Le matériel a bien été déclaré comme retourné.');
    }

}
