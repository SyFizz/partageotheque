<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Borrow;
use App\Models\Item;
use Doctrine\DBAL\Query\QueryException;

class ItemsController extends Controller
{

    public function index()
    {
        $itemsPaginatedAndSortedByStatus = Item::all()->sortBy('is_borrowed')->paginate(20);
        return view('items.index')
            ->with('items', $itemsPaginatedAndSortedByStatus);
    }

    public function create()
    {
        if(auth()->user()->role === 'admin') {
            return view('items.create');
        } else {
            return redirect()->route('items.index')->with('error', 'Vous n\'avez pas les privilèges nécessaires pour créer un matériel !');
        }
    }

    public function store(StoreItemRequest $request)
    {
        if(auth()->user()->role === 'admin') {

            $item_name = $request->validated('item_name');
            $type = $request->validated('type');
            $description = str_replace("\r\n", "\n", $request->validated('description'));
            $is_borrowed = $request->validated('is_borrowed');


            $item = Item::create([
                'item_name' => $item_name,
                'type' => $type,
                'description' => $description,
                'is_borrowed' => $is_borrowed,
            ]);
            return redirect()->route('items.show', $item)->with('success', 'Le matériel a bien été créé !');
        } else {
            return redirect()->back()->with('error', 'Vous n\'avez pas les privilèges nécessaires pour créer un matériel !');
        }
    }

    public function show(Item $item)
    {
        return view('items.show')
            ->with('item', $item);
    }

    public function edit(Item $item)
    {
        if(auth()->user()->role === 'admin') {
            return view('items.edit')
                ->with('item', $item);
        } else {
            return redirect()->route('items.index')->with('error', 'Vous n\'avez pas les privilèges nécessaires pour modifier un matériel !');
        }
    }

    public function update(UpdateItemRequest $request, Item $item)
    {
        $item_name = $request->validated('item_name');
        $type = $request->validated('type');
        $description = str_replace("\r\n", "\n", $request->validated('description'));

        $item->update([
            'type' => $type,
            'description' => $description,
        ]);
        return redirect()->route('items.show', $item)->with('success', 'Le matériel a bien été modifié !');
    }

    public function destroy(Item $item)
    {
        if($item->is_borrowed){
            return redirect()->back()->with('error', 'Le matériel ne peut pas être supprimé car il est actuellement emprunté.');
        } else {
            $borrows = Borrow::where('item_id', $item->id)->get();
            foreach ($borrows as $borrow) {
                $borrow->delete();
            }
            $item->delete();
            return redirect()->route('items.index')->with('success', 'Le matériel a bien été supprimé !');
        }

    }

}
