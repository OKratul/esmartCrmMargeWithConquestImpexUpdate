<?php

namespace App\Models\conquest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConquestTransection extends Model
{
    use HasFactory;

    protected $guarded;


    public function accounts(){

        return $this->belongsTo(ConquestAccount::class,'account_id');

    }

    public function invoices(){

        return $this->belongsTo(ConquestInvoice::class,'invoice_id');

    }

}
