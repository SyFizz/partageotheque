<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowerRequest;
use App\Http\Requests\UpdateBorrowerRequest;
use App\Models\Borrower;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BorrowersController extends Controller
{
    public function index(Request $request)
    {

        $borrowers = Borrower::query()->get();
        if($request->ajax()){
            $borrowers = Borrower::query()
                ->when($request->search_term, function($q)use($request){
                    $q->where('name', 'like', '%'.$request->search_term.'%')
                        ->orWhere('email', 'like', '%'.$request->search_term.'%')
                        ->orWhere('id', 'like', '%'.$request->search_term.'%')
                        ->orWhere('role', 'like', '%'.$request->search_term.'%');
                })
                ->when($request->role, function($q)use($request){
                    $q->where('role', $request->role);
                })->get();
            return view('borrowers.partials.table', compact('borrowers'))->render();
        }
        return view('borrowers.index', compact('borrowers'));
    }

    public function show(Borrower $borrower)
    {
        return view('borrowers.show')->with('borrower', $borrower);
    }

    public function create()
    {
        return view('borrowers.create');
    }

    public function store(StoreBorrowerRequest $request)
    {
        $borrower = Borrower::create($request->validated());

        return redirect()->route('borrowers.index')->with('success', 'L\'emprunteur a été créé avec succès.');
    }

    public function edit(Borrower $borrower)
    {
        return view('borrowers.edit')->with('borrower', $borrower);
    }

    public function update(UpdateBorrowerRequest $request, Borrower $borrower)
    {
        $borrower->update($request->validated());

        return redirect()->route('borrowers.index')->with('success', 'L\'emprunteur a été modifié avec succès.');
    }

    public function destroy(Borrower $borrower)
    {
        try {
            $borrower->delete();
        } catch (\Throwable $e) {
            return redirect()->route('borrowers.index')->with('error', 'Impossible de supprimer cet emprunteur car il est lié à un ou plusieurs emprunts.');
        }

        return redirect()->route('borrowers.index')->with('success', 'L\'emprunteur a été supprimé avec succès.');
    }

}
