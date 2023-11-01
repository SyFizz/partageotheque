<?php

use App\Http\Controllers\BorrowersController;
use App\Http\Controllers\BorrowsController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use App\Mail\BorrowReminder;
use App\Models\Borrow;
use App\Models\Borrower;
use App\Models\Item;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return to_route("dashboard");
});


Route::get('/dashboard', function () {
    return view('dashboard')
        ->with('borrows', Borrow::all())
        ->with('items', Item::all())
        ->with('borrowers', Borrower::all())
        ->with('lastBorrow', Borrow::latest()->first());
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/sendreminder', function (Request $request){
    $borrow = Borrow::find($request->borrow_id);
    Mail::to($borrow->borrower->email)->send(new BorrowReminder($borrow));
    return redirect()->back()->with('success', 'Le rappel a bien été envoyé.');
})->middleware(['auth', 'verified'])->name('sendReminder');

Route::prefix('users')->middleware(['auth', 'verified'])->group(function (){
   Route::get('/', [UsersController::class, 'index'])->name('users.index');
   Route::get('/create', [UsersController::class, 'create'])->name('users.create');
   Route::post('/create', [UsersController::class, 'store'])->name('users.store');
   Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
   Route::patch('/{user}/edit', [UsersController::class, 'update'])->name('users.update');
   Route::get('/{user}', [UsersController::class, 'show'])->name('users.show');
   Route::delete('/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
});

Route::prefix('items')->middleware(['auth', 'verified'])->group(function (){
    Route::get('/', [ItemsController::class, 'index'])->name('items.index');
    Route::get('/create', [ItemsController::class, 'create'])->name('items.create');
    Route::post('/create', [ItemsController::class, 'store'])->name('items.store');
    Route::get('/{item}/edit', [ItemsController::class, 'edit'])->name('items.edit');
    Route::patch('/{item}/edit', [ItemsController::class, 'update'])->name('items.update');
    Route::get('/{item}', [ItemsController::class, 'show'])->name('items.show');
    Route::delete('/{item}', [ItemsController::class, 'destroy'])->name('items.destroy');
});

Route::prefix('borrow')->middleware(['auth', 'verified'])->group(function(){
    Route::get('/', [BorrowsController::class, 'scanItem'])->name('borrow.scanItem');
    Route::post('/', [BorrowsController::class, 'goToStepTwo'])->name('borrow.stepTwo');

    Route::get('/autocomplete-borrower', [BorrowsController::class, 'autocompleteBorrower'])->name('borrow.searchBorrower');

    Route::get('/{item_name}', [BorrowsController::class, 'chooseBorrower'])->name('borrow.choose-borrower');
    Route::post('/{item_name}', [BorrowsController::class, 'store'])->name('borrow.store');
});

Route::prefix('return')->middleware(['auth', 'verified'])->group(function(){
   Route::get('/', [ReturnController::class, 'scanItem'])->name('return.scanItem');
   Route::post('/', [ReturnController::class, 'store'])->name('return.store');
});

Route::prefix('borrowers')->middleware(['auth','verified'])->group(function (){
   Route::get('/', [BorrowersController::class, 'index'])->name('borrowers.index');
    Route::get('/create', [BorrowersController::class, 'create'])->name('borrowers.create');
    Route::post('/create', [BorrowersController::class, 'store'])->name('borrowers.store');
    Route::get('/{borrower}/edit', [BorrowersController::class, 'edit'])->name('borrowers.edit');
    Route::patch('/{borrower}/edit', [BorrowersController::class, 'update'])->name('borrowers.update');
    Route::get('/search', [BorrowersController::class, 'search'])->name('borrowers.search');
    Route::get('/{borrower}', [BorrowersController::class, 'show'])->name('borrowers.show');
    Route::delete('/{borrower}', [BorrowersController::class, 'destroy'])->name('borrowers.destroy');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
