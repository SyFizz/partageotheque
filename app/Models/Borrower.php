<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    public function borrows(){
        return $this->hasMany(Borrow::class);
    }

    public function nonReturnedBorrows(){
        return $this->borrows()->whereNull('return_date')->get();
    }

    public function returnedBorrows(){
        return $this->borrows()->whereNotNull('return_date')->get();
    }

    public function lastBorrow(){
        return $this->borrows()->latest()->first();
    }

    protected $fillable = [
        'name',
        'email',
        'role',
    ];

}
