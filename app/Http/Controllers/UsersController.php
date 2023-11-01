<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function index(): View
    {
        return view('users.index')
            ->with('users', User::paginate(10));
    }

    public function create(): View|RedirectResponse
    {
        if(auth()->user()->role === 'admin') {
            return view('users.create');
        } else {
            return redirect()->route('users.index')->with('error', 'Vous n\'avez pas les privilèges nécessaires pour créer un utilisateur !');
        }
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {

        if(auth()->user()->role === 'admin') {
            $user = User::create($request->validated());
            $user->sendEmailVerificationNotification();
            return redirect()->route('users.show', $user);
        } else {
            return redirect()->back()->with('error', 'Vous n\'avez pas les privilèges nécessaires pour créer un utilisateur !');
        }
    }

    public function edit(User $user): View|RedirectResponse
    {
        if(auth()->user()->role === 'admin') {
            return view('users.edit')
                ->with('user', $user);
        } else {
            if(auth()->user()->id === $user->id) {
                return view('users.edit')
                    ->with('user', $user);
            }
            return redirect()->route('users.index')->with('error', 'Vous n\'avez pas les privilèges nécessaires pour modifier un utilisateur !');
        }

    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {

        if(auth()->user()->role === 'admin') {
            if($request->password === null) {
                $user->update($request->except('password'));
            } else {
                $user->update($request->validated());
            }
            return redirect()->route('users.show', $user)->with('success', 'L\'utilisateur ' . $user->name . ' a bien été modifié !');
        } else {
            if(auth()->user()->id === $user->id) {
                if($request->password === null) {
                    $user->update($request->except('password'));
                } else {
                    $user->update($request->validated());
                }
                return redirect()->route('users.show', $user)->with('success', 'L\'utilisateur ' . $user->name . ' a bien été modifié !');

            }
            return redirect()->route('users.index')->with('error', 'Vous n\'avez pas les privilèges nécessaires pour modifier un utilisateur !');
        }

        //Update the user with the validated data, and ignore the password if it's empty
    }


    public function show(User $user): View
    {
        return view('users.show')
            ->with('user', $user);
    }

    public function destroy(User $user): RedirectResponse
    {

        if(auth()->user()->role === 'admin') {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'L\'utilisateur ' . $user->name . ' a bien été supprimé !');
        } else {
            return redirect()->route('users.index')->with('error', 'Vous n\'avez pas les privilèges nécessaires pour supprimer un utilisateur !');
        }
    }

}
