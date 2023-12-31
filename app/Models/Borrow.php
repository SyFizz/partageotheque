<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function borrower(){
        return $this->belongsTo(Borrower::class);
    }



}


