<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'type',
        'description',
        'is_borrowed',
    ];

    public function borrows(){
        return $this->hasMany(Borrow::class);
    }

    public function lastBorrow(){
        return $this->borrows()->latest()->first();
    }

    public function getBorrower(){
        $borrows = Borrow::where('item_id', $this->id)->where('is_returned', false)->get();
        if($borrows->count() == 0){
            return null;
        }
        return Borrower::find($borrows->first()->borrower_id);
    }

    public function getBorrowHistory(){
        return Borrow::where('item_id', $this->id)->where('is_returned', true)->get();
    }

}
