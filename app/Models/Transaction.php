<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function accounts(){
        return $this->belongsTo(Accounts::class,'account_id');
    }

    public function payments(){
        return $this->belongsTo(Payment::class,'payment_id');
    }

    public function expanses(){
        return $this->belongsTo(Expanse::class,'expanse_id');
    }

}
