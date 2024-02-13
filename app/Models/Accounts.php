<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payments(){
        return $this->hasMany(Payment::class,'account_id');
    }

    public function transactions(){

        return $this->hasMany(Transaction::class);
    }

    public function expanses(){

        return $this->hasMany(Expanse::class,'account_id');

    }

}
